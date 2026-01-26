<?php
require_once '../src/Database.php';
require_once '../src/UserKYC.php';
require_once '../src/LetterTypeManager.php';
require_once '../src/LetterTemplate.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action === 'get_user_data') {
    $cand_id = $_GET['cand_id'] ?? '';
    
    if (empty($cand_id)) {
        echo json_encode(['success' => false, 'message' => 'Candidate ID required']);
        exit;
    }
    
    $user = UserKYC::getByCandId($cand_id);
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }
    
    // Parse additional data if it exists
    if (isset($user['additional_data']) && !empty($user['additional_data'])) {
        $user['additional_data'] = json_decode($user['additional_data'], true);
    }
    
    echo json_encode(['success' => true, 'data' => $user]);
    exit;
}

if ($action === 'get_letter_type_fields') {
    $type_slug = $_GET['type'] ?? '';
    
    if (empty($type_slug)) {
        echo json_encode(['success' => false, 'message' => 'Type required']);
        exit;
    }
    
    $type = LetterTypeManager::getTypeBySlug($type_slug);
    
    if (!$type) {
        echo json_encode(['success' => false, 'message' => 'Letter type not found']);
        exit;
    }
    
    $fields = json_decode($type['fields_json'], true);
    echo json_encode(['success' => true, 'fields' => $fields]);
    exit;
}

if ($action === 'render_preview') {
    $type_id = $_POST['letter_type_id'] ?? 0;
    $fields = $_POST['fields'] ?? [];
    
    // Merge top-level fields like roll_no into the data array
    $data = $fields;
    $data['roll_no'] = $_POST['roll_no'] ?? '';
    $data['cand_id'] = $_POST['cand_id'] ?? '';
    
    // Handle signature preview (base64 from file input)
    if (isset($_POST['signature_preview']) && !empty($_POST['signature_preview'])) {
        $data['signature_image'] = $_POST['signature_preview'];
    }
    
    $type = LetterTypeManager::getTypeById($type_id);
    
    if ($type) {
        $letterType = ['name' => $type['name'], 'slug' => $type['slug']];
        // Return raw HTML for the iframe
        echo LetterTemplate::renderLetter($data, $letterType);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
?>

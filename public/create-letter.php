<?php
require_once '../src/Database.php';
require_once '../src/LetterManager.php';
require_once '../src/LetterTypeManager.php';
require_once '../src/LetterTemplate.php';
require_once '../src/UserKYC.php';

$action = $_GET['action'] ?? 'step1';
$csrf_token = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_letter'])) {
    $fields = $_POST['fields'] ?? [];
    
    // Handle signature upload
    $signature_path = '';
    if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/uploads/signatures/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['signature']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $filename = uniqid('sig_', true) . '.' . $file_extension;
            $target_path = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['signature']['tmp_name'], $target_path)) {
                $signature_path = 'uploads/signatures/' . $filename;
                $fields['signature_image'] = $signature_path;
            }
        }
    }
    
    $letter_id = LetterManager::saveLetter(
        $_POST['cand_id'],
        $_POST['roll_no'],
        $_POST['letter_type_id'],
        $fields
    );
    header("Location: view-letter.php?id=" . $letter_id);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Letter | DocPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #0f2854;
            --primary-hover: #1c4d8d;
            --bg-light: #bde8f5;
            --text-dark: #2d2436;
        }
        
        body {
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
        }
        
        .navbar-custom {
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }
        
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 600;
            transition: all 0.3s;
            margin: 0 10px;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
            transform: translateY(-2px);
        }
        
        .btn-admin {
            background: var(--primary);
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .btn-admin:hover {
            background: var(--primary-hover);
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        
        .card-header {
            background: #ffffff;
            color: var(--text-dark);
            border-bottom: 1px solid #e5e7eb;
            border: none;
            border-radius: 15px 15px 0 0;
            font-weight: 600;
            padding: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0.75rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background: var(--primary-hover);
        }
        
        .letter-paper {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .text-muted {
            color: rgba(0,0,0,0.6) !important;
        }
        
        .btn-dark {
            background: #1f2937;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-dark:hover {
            background: #111827;
        }
        
        .auto-fetch-indicator {
            color: #28a745;
            display: block;
            margin-top: 5px;
            font-style: italic;
        }
        
        #previewFrame {
            width: 100%;
            height: 600px;
            border: none;
            background: #525659; /* Dark grey background for contrast */
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar-custom">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="navbar-brand"><i class="bi bi-file-earmark-text-fill me-2"></i>DocPortal</span>
            <div class="d-flex align-items-center gap-3">
                <a href="index.php" class="nav-link"><i class="bi bi-house-door-fill me-1"></i> Home</a>
                <a href="letters.php" class="nav-link"><i class="bi bi-table me-1"></i> View Letters</a>
                <a href="kyc.php" class="nav-link"><i class="bi bi-person-badge-fill me-1"></i> KYC Management</a>
            </div>
        </div>
    </div>
</nav>

<div class="container pb-5 mt-4">
    <?php if ($action === 'step1'): ?>
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-white"><h5 class="mb-0">Create New Letter</h5></div>
            <div class="card-body">
                <form action="create-letter.php" method="get" id="step1Form">
                    <input type="hidden" name="action" value="step2">
                    <div class="mb-3">
                        <label class="form-label">Candidate ID</label>
                        <input type="text" name="cand_id" class="form-control" id="step1CandId" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type of Letter</label>
                        <select name="type" class="form-select" id="step1Type" required>
                            <option value="">-- Select Type --</option>
                            <?php foreach(LetterTypeManager::getAllTypes() as $lt): ?>
                                <option value="<?= $lt['slug'] ?>"><?= $lt['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Next / Fill Letter</button>
                </form>
            </div>
        </div>
    <?php elseif ($action === 'step2'): 
        $type = LetterTypeManager::getTypeBySlug($_GET['type'] ?? '');
        $fields = json_decode($type['fields_json'], true);
        $cand_id = htmlspecialchars($_GET['cand_id'] ?? '');
        $user_data = UserKYC::getByCandId($cand_id);
    ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white"><strong>Fill Information</strong></div>
                    <div class="card-body">
                        <form id="letterForm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="letter_type_id" value="<?= $type['id'] ?>">
                            <input type="hidden" name="cand_id" value="<?= htmlspecialchars($cand_id) ?>">
                            
                            <?php if ($user_data): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>✓ Auto-fetched Data:</strong> User information loaded from KYC database.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    Roll Number
                                    <?php if (isset($user_data['roll_no'])): ?>
                                        <span class="badge bg-success ms-2">Auto-filled</span>
                                    <?php endif; ?>
                                </label>
                                <input type="text" name="roll_no" class="form-control live-input" data-key="roll_no" value="<?= htmlspecialchars($user_data['roll_no'] ?? '') ?>" <?= isset($user_data['roll_no']) ? 'readonly' : '' ?> required>
                            </div>
                            
                            <?php foreach($fields as $f): 
                                $field_value = '';
                                
                                // Auto-populate from KYC if field matches
                                if ($user_data) {
                                    // Map start_date to date_of_joining from KYC
                                    if ($f['name'] === 'start_date' && isset($user_data['date_of_joining'])) {
                                        $field_value = $user_data['date_of_joining'];
                                    } elseif (isset($user_data[$f['name']])) {
                                        $field_value = $user_data[$f['name']];
                                    }
                                }
                                
                                $is_autofilled = !empty($field_value);
                            ?>
                                <div class="mb-3">
                                    <label class="form-label">
                                        <?= $f['label'] ?>
                                        <?php if ($is_autofilled): ?>
                                            <span class="badge bg-success ms-2">Auto-filled</span>
                                        <?php endif; ?>
                                    </label>
                                    <?php if($f['type'] === 'textarea'): ?>
                                        <textarea name="fields[<?= $f['name'] ?>]" class="form-control live-input" data-key="<?= $f['name'] ?>" <?= $is_autofilled ? 'readonly' : '' ?> required><?= htmlspecialchars($field_value) ?></textarea>
                                    <?php else: ?>
                                        <input type="<?= $f['type'] ?>" name="fields[<?= $f['name'] ?>]" class="form-control live-input" data-key="<?= $f['name'] ?>" value="<?= htmlspecialchars($field_value) ?>" <?= $is_autofilled ? 'readonly' : '' ?> required>
                                    <?php endif; ?>
                                    <?php if ($is_autofilled): ?>
                                        <small class="auto-fetch-indicator">📋 From database</small>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-pen-fill me-1"></i> Signature Upload
                                    <small class="text-muted d-block">
                                        <strong>Recommended dimensions:</strong> 250px width × 80px height (or similar ratio)<br>
                                        <strong>Formats:</strong> JPG, PNG, GIF | <strong>Max size:</strong> 2MB<br>
                                        <em>For best results, use a transparent background PNG with signature in black/dark color</em>
                                    </small>
                                </label>
                                <input type="file" name="signature" id="signatureUpload" class="form-control live-input" accept="image/*" data-key="signature_image">
                                <div id="signaturePreview" class="mt-2" style="display: none;">
                                    <img id="signaturePreviewImg" src="" alt="Signature Preview" style="max-height: 80px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                </div>
                            </div>
                            
                            <button type="submit" name="save_letter" class="btn btn-success w-100">Save & Preview</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-4" style="position: sticky; top: 90px; z-index: 900;">
                    <div class="card-header bg-white"><strong>Live Preview (A4 Size)</strong></div>
                    <iframe id="previewFrame" title="Letter Preview"></iframe>
                </div>
            </div>
        </div>
    <?php elseif ($action === 'preview'): 
        $letter = LetterManager::getLetter($_GET['id'] ?? 0);
        if (!$letter) {
            echo '<div class="alert alert-danger">Letter not found!</div>';
            exit;
        }
        $data = json_decode($letter['data_json'], true);
        $letterType = ['name' => $letter['type_name'], 'slug' => $letter['type_slug']];
    ?>
        <div class="text-center mb-4 d-print-none">
            <button onclick="downloadPDF()" class="btn btn-dark">Download</button>
            <a href="create-letter.php" class="btn btn-outline-primary">Create Another</a>
        </div>
        <div class="letter-paper" id="finalLetter">
            <?= LetterTemplate::renderLetter($data, $letterType) ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function downloadPDF() {
    const element = document.getElementById('finalLetter');
    // Target inner container for clean A4 capture
    const content = element.querySelector('.letter-container') || element;
    
    // Save original margin to restore later
    const originalMargin = content.style.margin;
    // Force margin to 0 for capture so it aligns left
    content.style.margin = '0';

    const opt = {
        margin: [0, 0, 0, 0],
        filename: 'letter.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, x: 0, scrollY: 0 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(content).save().then(() => {
        content.style.margin = originalMargin;
    });
}

const inputs = document.querySelectorAll('.live-input');
const previewFrame = document.getElementById('previewFrame');
const signatureUpload = document.getElementById('signatureUpload');
const signaturePreview = document.getElementById('signaturePreview');
const signaturePreviewImg = document.getElementById('signaturePreviewImg');

if (inputs.length > 0 && previewFrame) {
    // Debounce function to limit API calls while typing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    const updatePreview = debounce(function() {
        const formData = new FormData(document.getElementById('letterForm'));
        
        // Handle signature image preview
        const signatureFile = signatureUpload?.files[0];
        if (signatureFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create a hidden input with base64 data for preview
                formData.append('signature_preview', e.target.result);
                sendPreviewRequest(formData);
            };
            reader.readAsDataURL(signatureFile);
        } else {
            sendPreviewRequest(formData);
        }
    }, 500);
    
    function sendPreviewRequest(formData) {
        fetch('api.php?action=render_preview', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            const doc = previewFrame.contentWindow.document;
            doc.open();
            // Inject styles to make the preview look neat inside the iframe
            const previewStyle = `
                <style>
                    html { background-color: #525659 !important; width: 100%; height: 100%; }
                    body { 
                        background-color: #525659 !important; 
                        margin: 0; 
                        padding: 30px 0; 
                        min-height: 100%; 
                        display: flex; 
                        justify-content: center; 
                    }
                    .letter-container { 
                        transform: scale(0.85); 
                        transform-origin: top center; 
                        box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
                        margin: 0 !important;
                    }
                    ::-webkit-scrollbar { width: 8px; }
                    ::-webkit-scrollbar-thumb { background: #888; }
                </style>
            `;
            doc.write('<!DOCTYPE html>' + html + previewStyle);
            doc.close();
        })
        .catch(error => console.error('Error updating preview:', error));
    }

    inputs.forEach(input => input.addEventListener('input', updatePreview));
    
    // Handle signature upload preview
    if (signatureUpload) {
        signatureUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    signaturePreviewImg.src = e.target.result;
                    signaturePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
                updatePreview();
            } else {
                signaturePreview.style.display = 'none';
            }
        });
    }
    
    updatePreview(); // Initial preview
}
</script>
</body>
</html>

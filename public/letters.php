<?php
require_once '../src/Database.php';
require_once '../src/LetterManager.php';
require_once '../src/LetterTypeManager.php';

$csrf_token = '';

// Get all letters
try {
    $all_letters = LetterManager::getAllLetters();
} catch (Exception $e) {
    $all_letters = [];
    $error = "Error loading letters: " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Letters | DocPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #0f2854;
            --bg-light: #bde8f5;
            --text-dark: #2d2436;
        }
        body { 
            background-color: var(--bg-light); 
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
        .main-content { padding: 30px; }
        .table-card { background: white; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 20px; border: none; }
        .btn-primary { background-color: var(--primary); border: none; }
        .btn-primary:hover { background-color: #1c4d8d; }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar-custom">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="navbar-brand"><i class="bi bi-file-earmark-text-fill me-2"></i>DocPortal</span>
            <a href="index.php" class="nav-link"><i class="bi bi-house-door-fill me-1"></i> Home</a>
        </div>
    </div>
</nav>

<div class="container-fluid main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Documentation Repository</h3>
                <span class="badge bg-primary px-3 py-2">Total: <?= count(LetterManager::getAllLetters()) ?> Records</span>
            </div>
            
            <div class="table-card">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cand ID</th>
                            <th>Roll Number</th>
                            <th>Letter Type</th>
                            <th>Created On</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($all_letters)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">No letters created yet</td></tr>
                        <?php else: ?>
                            <?php foreach($all_letters as $l): ?>
                            <tr>
                                <td>#<?= $l['id'] ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($l['cand_id'] ?? '-') ?></span></td>
                                <td><span class="fw-bold"><?= htmlspecialchars($l['roll_no']) ?></span></td>
                                <td><span class="badge bg-info text-dark"><?= $l['type_name'] ?></span></td>
                                <td class="text-muted small"><?= date('M d, Y H:i', strtotime($l['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="view-letter.php?id=<?= $l['id'] ?>" class="btn btn-sm btn-primary">View Letter</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php require_once 'footer.php'; ?>
</body>
</html>

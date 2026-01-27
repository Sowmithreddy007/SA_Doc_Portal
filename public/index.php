<?php
require_once 'require_auth.php';
require_once '../src/Database.php';
require_once '../src/LetterManager.php';
require_once '../src/UserKYC.php';

$totalLetters = null;
$totalKyc = null;
try {
    $totalLetters = count(LetterManager::getAllLetters());
} catch (\Throwable $e) {
    $totalLetters = null;
}
try {
    $totalKyc = count(UserKYC::getAll());
} catch (\Throwable $e) {
    $totalKyc = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocPortal - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #0f2854;
            --primary-hover: #1c4d8d;
            --bg-light: #bde8f5;
            --text-dark: #2d2436;
            --card: rgba(189, 232, 245, 0.92);
            --glass: rgba(255, 255, 255, 0.14);
        }
        html { scroll-behavior: smooth; }
        
        body {
            background: linear-gradient(135deg, #0f2854 0%, #1c4d8d 33%, #4988c4 66%, #bde8f5 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        .navbar-custom {
            background: var(--bg-light);
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

        .page-wrap {
            padding: 28px 16px 36px;
        }

        .hero-card {
            background: var(--glass);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 24px 22px;
            color: #fff;
            box-shadow: 0 18px 50px rgba(0,0,0,0.18);
        }

        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 0.2px;
            margin: 0 0 6px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.25);
        }

        .hero-subtitle {
            margin: 0;
            opacity: 0.95;
            font-size: 1rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        .pill {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.22);
            color: #fff;
            border-radius: 999px;
            padding: 6px 12px;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }
        
        .card-feature {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background: var(--card);
            transition: all 0.3s;
            text-align: center;
            padding: 25px;
            height: 100%;
            margin: 0 auto;
        }
        
        .card-feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .card-feature .icon {
            font-size: 1.6rem;
            margin-bottom: 8px;
            color: var(--primary);
        }
        
        .card-feature h4 {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 5px;
        }
        
        .card-feature p {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--primary);
            margin: 2px 0 4px;
        }
        
        .btn-feature {
            background: var(--primary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            padding: 8px 20px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
        }
        
        .btn-feature:hover {
            background: var(--primary-hover);
            color: white;
            transform: scale(1.05);
        }

        .btn-logout {
            background: var(--primary);
            color: #fff !important;
            border-radius: 10px;
            padding: 8px 14px;
            font-weight: 700;
            text-decoration: none;
            border: 0;
            transition: all 0.25s;
        }
        .btn-logout:hover { background: var(--primary-hover); transform: translateY(-1px); }
        
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar-custom">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="navbar-brand"><i class="bi bi-file-earmark-text-fill me-2"></i>DocPortal</span>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-md-inline">Welcome, <?= htmlspecialchars($_SESSION['display_name'] ?? $_SESSION['username'] ?? 'User') ?></span>
                <a href="login.php?logout=1" class="btn-logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
            </div>
        </div>
    </div>
</nav>

<div class="page-wrap">
    <div class="container" style="max-width: 1100px;">
        <div class="hero-card mb-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                <div>
                    <div class="hero-title">Welcome to DocPortal</div>
                    <p class="hero-subtitle">Create letters, manage KYC, and export documents beautifully.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="pill"><i class="bi bi-shield-lock-fill me-2"></i>Restricted Access</span>
                    <span class="pill"><i class="bi bi-person-badge-fill me-2"></i><?= htmlspecialchars($_SESSION['display_name'] ?? $_SESSION['username'] ?? 'User') ?></span>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <!-- Actions -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-pencil-square"></i></div>
                    <h4>Create New Letter</h4>
                    <p>Generate professional letters with auto-populated KYC data.</p>
                    <a href="create-letter.php" class="btn-feature">Create</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-collection"></i></div>
                    <h4>Letter Repository</h4>
                    <p class="mb-2">Browse, preview, print, and download all generated letters.</p>
                    <p class="text-muted small mb-3 fw-semibold">
                        There are currently
                        <span class="text-dark"><?= $totalLetters === null ? '—' : (int)$totalLetters ?></span>
                        letters
                    </p>
                    <a href="letters.php" class="btn-feature">Browse</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-person-badge"></i></div>
                    <h4>KYC Management</h4>
                    <p class="mb-2">Maintain candidate records used for automatic letter generation.</p>
                    <p class="text-muted small mb-3 fw-semibold">
                        KYC registrations:
                        <span class="text-dark"><?= $totalKyc === null ? '—' : (int)$totalKyc ?></span>
                    </p>
                    <a href="kyc.php" class="btn-feature">Manage</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

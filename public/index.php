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
            --accent1: #e67e22;
            --accent2: #3498db;
            --accent3: #27ae60;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        html { 
            scroll-behavior: smooth; 
        }
        
        body {
            background: linear-gradient(135deg, #0f2854 0%, #1c4d8d 33%, #4988c4 66%, #bde8f5 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .navbar-custom {
            background: linear-gradient(90deg, var(--bg-light) 0%, rgba(189, 232, 245, 0.95) 100%);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
            animation: slideInRight 0.6s ease-out;
        }
        
        .navbar-brand i {
            color: var(--accent1);
        }
        
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 600;
            transition: all 0.3s;
            margin: 0 10px;
        }
        
        .nav-link:hover {
            color: var(--accent1) !important;
            transform: translateY(-2px);
        }

        .page-wrap {
            padding: 40px 16px 36px;
            flex: 1;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.08) 100%);
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 32px;
            color: #fff;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
            z-index: 0;
        }

        .hero-card > * {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: -1px;
            margin: 0 0 12px 0;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            margin: 0;
            opacity: 0.98;
            font-size: 1.1rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            font-weight: 500;
        }

        .pill {
            background: rgba(255, 255, 255, 0.22);
            border: 1.5px solid rgba(255, 255, 255, 0.35);
            color: #fff;
            border-radius: 999px;
            padding: 8px 14px;
            font-weight: 700;
            font-size: 0.85rem;
            white-space: nowrap;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .pill:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .pill i {
            margin-right: 6px;
        }
        
        .card-feature {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            background: linear-gradient(135deg, var(--card) 0%, rgba(189, 232, 245, 0.7) 100%);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
            padding: 32px 28px;
            height: 100%;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .card-feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
            z-index: 0;
        }

        .card-feature:hover::before {
            left: 100%;
        }

        .card-feature:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2), 0 0 60px rgba(230, 126, 34, 0.15);
        }

        .card-feature > * {
            position: relative;
            z-index: 1;
        }
        
        .card-feature .icon {
            font-size: 2.5rem;
            margin-bottom: 16px;
            color: var(--primary);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .card-feature:nth-child(1) .icon { animation-delay: 0.1s; color: #3498db; }
        .card-feature:nth-child(2) .icon { animation-delay: 0.2s; color: #e67e22; }
        .card-feature:nth-child(3) .icon { animation-delay: 0.3s; color: #27ae60; }

        .card-feature:hover .icon {
            transform: scale(1.15) rotate(5deg);
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
        }
        
        .card-feature h4 {
            color: var(--primary);
            font-weight: 800;
            font-size: 1.2rem;
            margin-bottom: 12px;
            letter-spacing: -0.3px;
        }
        
        .card-feature p {
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 12px;
            line-height: 1.6;
            font-weight: 500;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary);
            margin: 2px 0 4px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .btn-feature {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            border: none;
            border-radius: 10px;
            font-weight: 700;
            color: white;
            padding: 10px 24px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            display: inline-block;
            font-size: 0.95rem;
            box-shadow: 0 5px 15px rgba(15, 40, 84, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-feature::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-feature:hover::after {
            width: 300px;
            height: 300px;
        }
        
        .btn-feature:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(15, 40, 84, 0.4);
        }

        .btn-feature:active {
            transform: translateY(-1px);
        }

        .btn-logout {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: #fff !important;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 700;
            text-decoration: none;
            border: 0;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(15, 40, 84, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover { 
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 40, 84, 0.3);
        }

        .text-muted {
            font-weight: 600;
            color: rgba(45, 36, 54, 0.7) !important;
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

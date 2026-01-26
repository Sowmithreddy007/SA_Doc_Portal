<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/Database.php';
require_once '../src/Auth.php';

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
        }
        html { scroll-behavior: smooth; }
        
        body {
            background: linear-gradient(135deg, #0f2854 0%, #1c4d8d 33%, #4988c4 66%, #bde8f5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            overflow: hidden;
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
        
        .hero-section {
            background: transparent;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-content p {
            font-size: 1.1rem;
            margin-bottom: 80px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }
        
        .card-feature {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background: var(--bg-light);
            transition: all 0.3s;
            text-align: center;
            padding: 25px;
            height: 100%;
            max-width: 320px;
            margin: 0 auto;
        }
        
        .card-feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .card-feature .icon {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: var(--primary);
        }
        
        .card-feature h4 {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .card-feature p {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 10px;
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
            background: #453a50;
            color: white;
            transform: scale(1.05);
        }
        
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar-custom">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="navbar-brand"><i class="bi bi-file-earmark-text-fill me-2"></i>DocPortal</span>
            <span class="fw-bold" style="color: var(--primary);">SA projects</span>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <h1>Welcome to DocPortal</h1>
        <p>Manage your documents and KYC information efficiently</p>
    </div>
    
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-md-4 col-lg-4">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-pencil-square"></i></div>
                    <h4>Create New Letter</h4>
                    <p>Generate professional letters with auto-populated KYC data.</p>
                    <a href="create-letter.php" class="btn-feature">Get Started</a>
                </div>
            </div>
            
            <div class="col-md-4 col-lg-4">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-file-earmark-text"></i></div>
                    <h4>View Letters</h4>
                    <p>Access all your generated letters in one place.</p>
                    <a href="letters.php" class="btn-feature">View All</a>
                </div>
            </div>
            
            <div class="col-md-4 col-lg-4">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-person-badge"></i></div>
                    <h4>KYC Management</h4>
                    <p>Manage user information and KYC details.</p>
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

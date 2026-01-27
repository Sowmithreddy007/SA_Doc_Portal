<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/Auth.php';

$error = '';

if (isset($_GET['logout'])) {
    Auth::logout();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (Auth::login($username, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $error = 'Invalid username or password. Access restricted to executive body members only.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DocPortal</title>
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
            background: linear-gradient(135deg, #0f2854 0%, #1c4d8d 33%, #4988c4 66%, #bde8f5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
        }
        
        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            padding: 50px 40px;
            text-align: center;
        }
        
        .login-header {
            margin-bottom: 35px;
        }
        
        .login-header .logo-icon {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .login-header h2 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
            font-size: 1.8rem;
        }
        
        .login-header p {
            color: #666;
            font-size: 0.95rem;
            margin: 0;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 40, 84, 0.1);
        }
        
        .btn-login {
            background: var(--primary);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            padding: 12px;
            width: 100%;
            font-size: 1rem;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(15, 40, 84, 0.3);
        }
        
        .alert-danger {
            border-radius: 10px;
            border: none;
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        
        .restricted-badge {
            display: inline-block;
            background: var(--bg-light);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 20px;
        }
        
        .input-group-icon {
            position: relative;
        }
        
        .input-group-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 10;
        }
        
        .input-group-icon .form-control {
            padding-left: 45px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h2>DocPortal</h2>
                <p>Executive Body Access</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <div class="input-group-icon">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="username" class="form-control" required autofocus placeholder="Enter your username">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                    </div>
                </div>
                
                <button type="submit" name="login" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>
            
            <div class="restricted-badge">
                <i class="bi bi-shield-check me-1"></i>Restricted Access
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

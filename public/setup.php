<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/Database.php';

$message = '';
$error = '';

if (isset($_POST['setup'])) {
    try {
        $db = Database::getInstance();
        
        // Create tables
        $db->exec("
            DROP TABLE IF EXISTS audit_log;
            DROP TABLE IF EXISTS letters;
            DROP TABLE IF EXISTS letter_types;
            DROP TABLE IF EXISTS user_kyc;
            DROP TABLE IF EXISTS users;
        ");
        
        // Users table
        $db->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) UNIQUE NOT NULL,
                password_hash VARCHAR(255) NOT NULL,
                display_name VARCHAR(150),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Letter types table
        $db->exec("
            CREATE TABLE letter_types (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(100) UNIQUE NOT NULL,
                fields_json TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // User KYC table
        $db->exec("
            CREATE TABLE user_kyc (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cand_id VARCHAR(50) UNIQUE NOT NULL,
                roll_no VARCHAR(50) NOT NULL,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255),
                phone VARCHAR(20),
                position VARCHAR(255),
                department VARCHAR(255),
                date_of_joining DATE,
                date_of_birth DATE,
                address TEXT,
                city VARCHAR(100),
                state VARCHAR(100),
                pincode VARCHAR(10),
                qualification VARCHAR(255),
                designation VARCHAR(255),
                additional_data JSON,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
            )
        ");
        
        // Letters table
        $db->exec("
            CREATE TABLE letters (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cand_id VARCHAR(50) NOT NULL,
                roll_no VARCHAR(50) NOT NULL,
                letter_type_id INT NOT NULL,
                data_json TEXT NOT NULL,
                created_by INT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (letter_type_id) REFERENCES letter_types(id) ON DELETE CASCADE,
                FOREIGN KEY (cand_id) REFERENCES user_kyc(cand_id) ON DELETE CASCADE
            )
        ");
        
        // Audit log table
        $db->exec("
            CREATE TABLE audit_log (
                id INT AUTO_INCREMENT PRIMARY KEY,
                letter_id INT NOT NULL,
                action VARCHAR(50) NOT NULL,
                user_id INT NULL,
                details TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Seed admin user (password: admin123)
        $password_hash = password_hash('admin123', PASSWORD_BCRYPT);
        $db->exec("INSERT INTO users (username, password_hash, display_name) 
                   VALUES ('admin', '$password_hash', 'System Administrator')");
        
        // Seed letter types
        $letter_types = [
            ['Release / Notice of Term Completion & Release', 'release', '[{"name":"present_date","label":"Present Date","type":"date","required":true},{"name":"name","label":"Name","type":"text","required":true},{"name":"position","label":"Position","type":"text","required":true},{"name":"start_date","label":"Start Date","type":"date","required":true},{"name":"end_date","label":"End Date","type":"date","required":true}]'],
            ['Appointment', 'appointment', '[{"name":"present_date","label":"Present Date","type":"date","required":true},{"name":"name","label":"Name","type":"text","required":true},{"name":"position","label":"Position","type":"text","required":true},{"name":"start_date","label":"Start Date","type":"date","required":true}]'],
            ['LOR', 'lor', '[{"name":"present_date","label":"Present Date","type":"date","required":true},{"name":"name","label":"Name","type":"text","required":true},{"name":"position","label":"Position","type":"text","required":true},{"name":"start_date","label":"Start Date","type":"date","required":true},{"name":"custom_body","label":"Recommendation Text","type":"textarea","required":true}]'],
            ['Promotion', 'promotion', '[{"name":"present_date","label":"Present Date","type":"date","required":true},{"name":"name","label":"Name","type":"text","required":true},{"name":"previous_position","label":"Previous Position","type":"text","required":true},{"name":"present_position","label":"Present Position","type":"text","required":true},{"name":"start_date","label":"Start Date","type":"date","required":true},{"name":"years_served","label":"Years Served","type":"number","required":true},{"name":"last_working_day","label":"Last Working Day","type":"date","required":true}]'],
            ['Termination', 'termination', '[{"name":"present_date","label":"Present Date","type":"date","required":true},{"name":"name","label":"Name","type":"text","required":true},{"name":"remarks","label":"Remarks/Reason","type":"textarea","required":true}]'],
            ['Undertaking (1st year)', 'undertaking', '[{"name":"present_date","label":"Present Date","type":"date","required":true},{"name":"name","label":"Name","type":"text","required":true},{"name":"position","label":"Position","type":"text","required":true},{"name":"remarks","label":"Remarks","type":"textarea","required":true},{"name":"duration","label":"Duration","type":"text","required":true}]']
        ];
        
        foreach ($letter_types as $lt) {
            $db->exec("INSERT INTO letter_types (name, slug, fields_json) VALUES ('$lt[0]', '$lt[1]', '$lt[2]')");
        }
        
        $message = '✅ Database setup completed successfully! Admin user created with username: <strong>admin</strong> and password: <strong>admin123</strong>';
        
    } catch (\Exception $e) {
        $error = '❌ Error: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>DocPortal Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #0f2854 0%, #1c4d8d 33%, #4988c4 66%, #bde8f5 100%); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: sans-serif;
            padding: 20px;
        }
        
        .setup-card { 
            background: #ffffff; 
            border: none; 
            border-radius: 20px; 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); 
            padding: 40px; 
            width: 100%; 
            max-width: 500px; 
        }
        
        .setup-card h3 {
            color: #0f2854;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .setup-card p {
            color: #666;
            margin-bottom: 30px;
        }
        
        .btn-setup { 
            background: #0f2854; 
            border: none; 
            padding: 12px; 
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: background 0.3s;
        }
        
        .btn-setup:hover {
            background: #1c4d8d;
            color: white;
        }
        
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .info-box {
            background: #bde8f5;
            border-left: 4px solid #0f2854;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .info-box strong {
            color: #0f2854;
        }
    </style>
</head>
<body>
    <div class="setup-card">
        <h3>🚀 DocPortal Setup</h3>
        <p>Initialize the database with tables and seed data</p>
        
        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <div class="info-box">
                <strong>✅ Next Steps:</strong><br>
                1. Go to <a href="login.php">Login Page</a><br>
                2. Use credentials above to log in<br>
                3. Access admin features
            </div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="info-box mb-4">
                    <strong>⚠️ Warning:</strong><br>
                    This will create/reset all database tables and seed initial data.
                </div>
                <button type="submit" name="setup" class="btn btn-setup w-100 mb-3">Setup Database</button>
            </form>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

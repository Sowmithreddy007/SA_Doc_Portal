<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {
    /**
     * Inline (hardcoded) in-house credentials.
     * You can add more users here.
     *
     * NOTE: This bypasses the database for authentication.
     */
    private static function inlineUsers(): array {
        return [
            // username => [password, display_name, id]
            'admin' => [
                'password' => 'L&D@123',
                'display_name' => 'System Administrator',
                'id' => 1,
            ],
        ];
    }

    public static function login($username, $password) {
        $username = (string)($username ?? '');
        $password = (string)($password ?? '');

        // 1) Inline login (no DB required)
        $inline = self::inlineUsers();
        if (isset($inline[$username]) && hash_equals((string)$inline[$username]['password'], $password)) {
            $_SESSION['user_id'] = (int)$inline[$username]['id'];
            $_SESSION['username'] = $username;
            $_SESSION['display_name'] = (string)($inline[$username]['display_name'] ?? $username);
            return true;
        }

        // 2) Optional DB login (if DB is configured)
        try {
            require_once 'Database.php';
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['display_name'] = $user['display_name'];
                return true;
            }
        } catch (\Throwable $e) {
            // Ignore DB errors; inline auth still works.
        }

        return false;
    }

    public static function logout() {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    public static function check() {
        return isset($_SESSION['user_id']);
    }

    public static function generateCSRF() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCSRF($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

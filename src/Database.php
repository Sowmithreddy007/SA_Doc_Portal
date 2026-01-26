<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = 'localhost';
        $db   = 'doc_portal';
        $user = 'root';
        $pass = 'Sowmith@DB07';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        // PDO option constants (using integer values for compatibility)
        $options = [
            3 => 2,  // PDO::ATTR_ERR_MODE => PDO::ERR_MODE_EXCEPTION
            19 => 2, // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC  
            20 => false, // PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
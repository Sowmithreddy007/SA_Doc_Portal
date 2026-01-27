<?php
require_once 'Database.php';

class LetterManager {
    public static function saveLetter($cand_id, $roll_no, $type_id, $data, $user_id = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO letters (cand_id, roll_no, letter_type_id, data_json, created_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$cand_id, $roll_no, $type_id, json_encode($data), $user_id]);
        $letter_id = $db->lastInsertId();
        
        self::logAudit($letter_id, 'created', $user_id);
        return $letter_id;
    }

    public static function getLetter($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT l.*, lt.name as type_name, lt.slug as type_slug FROM letters l JOIN letter_types lt ON l.letter_type_id = lt.id WHERE l.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function logAudit($letter_id, $action, $user_id, $details = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO audit_log (letter_id, action, user_id, details) VALUES (?, ?, ?, ?)");
        $stmt->execute([$letter_id, $action, $user_id, $details]);
    }

    public static function getAllLetters() {
        $db = Database::getInstance();
        return $db->query("SELECT l.*, lt.name as type_name FROM letters l JOIN letter_types lt ON l.letter_type_id = lt.id ORDER BY l.created_at DESC")->fetchAll();
    }

    public static function deleteLetter($id, $user_id = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM letters WHERE id = ?");
        $ok = $stmt->execute([$id]);

        if ($ok) {
            self::logAudit($id, 'deleted', $user_id);
        }

        return $ok;
    }
}

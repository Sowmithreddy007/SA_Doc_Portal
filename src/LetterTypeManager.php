<?php
require_once 'Database.php';

class LetterTypeManager {
    public static function getAllTypes() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM letter_types")->fetchAll();
    }

    public static function getTypeBySlug($slug) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM letter_types WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    public static function getTypeById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM letter_types WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function updateFields($id, $fields_json) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE letter_types SET fields_json = ? WHERE id = ?");
        return $stmt->execute([$fields_json, $id]);
    }
}

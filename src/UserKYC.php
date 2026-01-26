<?php
require_once 'Database.php';

class UserKYC {
    
    /**
     * Get user KYC data by candidate ID
     */
    public static function getByCandId($cand_id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_kyc WHERE cand_id = ?");
        $stmt->execute([$cand_id]);
        return $stmt->fetch();
    }

    /**
     * Get user KYC data by roll number
     */
    public static function getByRollNo($roll_no) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_kyc WHERE roll_no = ?");
        $stmt->execute([$roll_no]);
        return $stmt->fetch();
    }
    
    /**
     * Save user KYC data
     */
    public static function save($data) {
        $db = Database::getInstance();
        
        // Check if record exists
        $existing = self::getByCandId($data['cand_id']);
        
        if ($existing) {
            // Update existing record
            $stmt = $db->prepare("UPDATE user_kyc SET roll_no=?, name=?, email=?, phone=?, position=?, department=?, date_of_joining=?, date_of_birth=?, address=?, city=?, state=?, pincode=?, qualification=?, designation=?, additional_data=?, updated_at=CURRENT_TIMESTAMP WHERE cand_id=?");
            return $stmt->execute([
                $data['roll_no'],
                $data['name'] ?? null,
                $data['email'] ?? null,
                $data['phone'] ?? null,
                $data['position'] ?? null,
                $data['department'] ?? null,
                $data['date_of_joining'] ?? null,
                $data['date_of_birth'] ?? null,
                $data['address'] ?? null,
                $data['city'] ?? null,
                $data['state'] ?? null,
                $data['pincode'] ?? null,
                $data['qualification'] ?? null,
                $data['designation'] ?? null,
                isset($data['additional_data']) ? json_encode($data['additional_data']) : null,
                $data['cand_id']
            ]);
        } else {
            // Insert new record
            $stmt = $db->prepare("INSERT INTO user_kyc (cand_id, roll_no, name, email, phone, position, department, date_of_joining, date_of_birth, address, city, state, pincode, qualification, designation, additional_data) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $data['cand_id'],
                $data['roll_no'],
                $data['name'] ?? null,
                $data['email'] ?? null,
                $data['phone'] ?? null,
                $data['position'] ?? null,
                $data['department'] ?? null,
                $data['date_of_joining'] ?? null,
                $data['date_of_birth'] ?? null,
                $data['address'] ?? null,
                $data['city'] ?? null,
                $data['state'] ?? null,
                $data['pincode'] ?? null,
                $data['qualification'] ?? null,
                $data['designation'] ?? null,
                isset($data['additional_data']) ? json_encode($data['additional_data']) : null
            ]);
        }
    }
    
    /**
     * Delete user KYC data
     */
    public static function delete($cand_id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM user_kyc WHERE cand_id = ?");
        return $stmt->execute([$cand_id]);
    }
    
    /**
     * Get all users KYC data
     */
    public static function getAll() {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM user_kyc ORDER BY created_at DESC")->fetchAll();
    }
}
?>

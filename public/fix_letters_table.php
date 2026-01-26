<?php
require_once '../src/Database.php';

try {
    $db = Database::getInstance();
    echo "<h3>Database Schema Repair</h3>";

    // Check if cand_id exists in letters table
    $stmt = $db->query("SHOW COLUMNS FROM letters LIKE 'cand_id'");
    if (!$stmt->fetch()) {
        echo "Column 'cand_id' is missing in 'letters' table. Adding it...<br>";
        
        // Add the column
        $db->exec("ALTER TABLE letters ADD COLUMN cand_id VARCHAR(50) NOT NULL AFTER id");
        echo "<span style='color:green'>✅ Successfully added 'cand_id' column.</span><br>";
        
        // Attempt to add Foreign Key (optional, depends on user_kyc table state)
        try {
            $db->exec("ALTER TABLE letters ADD CONSTRAINT fk_letters_cand_id FOREIGN KEY (cand_id) REFERENCES user_kyc(cand_id) ON DELETE CASCADE");
            echo "<span style='color:green'>✅ Successfully added Foreign Key constraint.</span><br>";
        } catch (Exception $e) {
            echo "<span style='color:orange'>⚠️ Could not add Foreign Key (user_kyc table might be missing or data mismatch). Skipping.</span><br>";
        }
    } else {
        echo "<span style='color:blue'>ℹ️ Column 'cand_id' already exists. No changes needed.</span><br>";
    }
    
    echo "<br><a href='create-letter.php'>Return to Create Letter</a>";

} catch (Exception $e) {
    echo "<span style='color:red'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</span>";
}
?>
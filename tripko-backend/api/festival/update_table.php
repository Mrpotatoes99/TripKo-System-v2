<?php
require_once(__DIR__ . '/../../config/db.php');

try {
    // Add status column if it doesn't exist
    $conn->query("ALTER TABLE festivals ADD COLUMN IF NOT EXISTS status ENUM('active', 'inactive') DEFAULT 'active'");
    
    // Update column constraints
    $conn->query("ALTER TABLE festivals 
        MODIFY name VARCHAR(150) NOT NULL,
        MODIFY date DATE NOT NULL,
        MODIFY description TEXT NOT NULL");
        
    echo "Table structure updated successfully";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
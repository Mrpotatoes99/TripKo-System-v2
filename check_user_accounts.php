<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/tripko-backend/config/Database.php');

$database = new Database();
$conn = $database->getConnection();

try {
    echo "<h2>User Accounts Status</h2>";
    
    // Check user_type table
    $typeQuery = "SELECT * FROM user_type";
    $typeResult = $conn->query($typeQuery);
    echo "<h3>User Types:</h3>";
    while($row = $typeResult->fetch_assoc()) {
        echo "Type ID: {$row['user_type_id']} - {$row['type_name']}<br>";
    }
    
    // Check user_status table
    $statusQuery = "SELECT * FROM user_status";
    $statusResult = $conn->query($statusQuery);
    echo "<h3>User Statuses:</h3>";
    while($row = $statusResult->fetch_assoc()) {
        echo "Status ID: {$row['user_status_id']} - {$row['status_name']}<br>";
    }
    
    // Check user accounts
    $userQuery = "SELECT u.user_id, u.username, u.user_type_id, u.user_status_id, 
                         ut.type_name, us.status_name
                  FROM user u
                  JOIN user_type ut ON u.user_type_id = ut.user_type_id
                  JOIN user_status us ON u.user_status_id = us.user_status_id";
    $userResult = $conn->query($userQuery);
    echo "<h3>User Accounts:</h3>";
    while($row = $userResult->fetch_assoc()) {
        echo "User ID: {$row['user_id']}, Username: {$row['username']}, " .
             "Type: {$row['type_name']}, Status: {$row['status_name']}<br>";
    }
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
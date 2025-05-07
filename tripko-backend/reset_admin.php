<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    $username = "admin";
    $password = "admin123"; // Change this to your desired admin password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Update the admin user (assuming user_id = 1 is admin)
    $sql = "UPDATE user SET username = ?, password = ? WHERE user_id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hash);
    
    if ($stmt->execute()) {
        echo "Admin credentials have been reset successfully!<br>";
        echo "Username: " . $username . "<br>";
        echo "Password: " . $password . "<br>";
    } else {
        throw new Exception("Failed to reset admin credentials");
    }

} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
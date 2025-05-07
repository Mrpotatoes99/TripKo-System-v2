<?php
// tripko-backend/register.php

// Debug mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once __DIR__ . '/config/Database.php';

// Initialize database connection
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        header('Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=empty');
        exit();
    }

    try {
        // Check if username already exists
        $check_stmt = $conn->prepare("SELECT user_id FROM user WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            header('Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=exists');
            exit();
        }

        // Begin transaction
        $conn->begin_transaction();

        // Hash password and insert new user with user_type_id = 2 (regular user) and active status
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO user (username, password, user_type_id, user_status_id) VALUES (?, ?, 2, 1)");
        $stmt->bind_param("ss", $username, $hashed_password);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to create user");
        }

        // Get the new user's ID
        $user_id = $stmt->insert_id;
        
        // Create user profile
        $profile_stmt = $conn->prepare("INSERT INTO user_profile (user_id) VALUES (?)");
        $profile_stmt->bind_param("i", $user_id);
        
        if (!$profile_stmt->execute()) {
            throw new Exception("Failed to create user profile");
        }

        // Commit the transaction
        $conn->commit();
            
        header('Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?success=1');
        exit();

    } catch (Exception $e) {
        if ($conn->connect_error === null) {
            $conn->rollback();
        }
        error_log("Registration error: " . $e->getMessage());
        header('Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=system');
        exit();
    }
} else {
    header('Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php');
    exit();
}
?>

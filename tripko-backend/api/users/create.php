<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once(__DIR__ . '/../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate required fields
    $required_fields = ['username', 'password', 'user_type', 'status'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception("Missing required field: {$field}");
        }
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $user_type_id = $_POST['user_type'];
    $user_status_id = $_POST['status'];

    // Start transaction
    $conn->begin_transaction();

    // Check if username already exists
    $check_stmt = $conn->prepare("SELECT user_id FROM user WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        throw new Exception("Username already exists");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO user (username, password, user_type_id, user_status_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $username, $hashed_password, $user_type_id, $user_status_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create user: " . $stmt->error);
    }

    // Get the new user's ID
    $user_id = $stmt->insert_id;
    
    // Create user profile
    $profile_stmt = $conn->prepare("INSERT INTO user_profile (user_id) VALUES (?)");
    $profile_stmt->bind_param("i", $user_id);
    $profile_stmt->execute();

    // Commit transaction
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "User created successfully"
    ]);

} catch (Exception $e) {
    if ($conn && $conn->connect_error === null) {
        $conn->rollback();
    }
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
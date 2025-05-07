<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/Database.php';

// Initialize database connection using the Database class
$database = new Database();
$conn = $database->getConnection();

// Check if connection was successful
if (!$conn) {
    error_log("Failed to connect to database");
    header("Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=connection");
    exit();
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Using htmlspecialchars for sanitization
        $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
        $password = $_POST['password'] ?? '';

        // Input validation
        if (empty($username) || empty($password)) {
            header("Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=empty");
            exit();
        }

        // Prepare statement to prevent SQL injection using mysqli syntax
        $sql = "SELECT u.*, ut.type_name, us.status_name 
                FROM user u 
                JOIN user_type ut ON u.user_type_id = ut.user_type_id 
                JOIN user_status us ON u.user_status_id = us.user_status_id 
                WHERE u.username = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            // Check if user is active
            if ($user['status_name'] !== 'Active') {
                header("Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=inactive");
                exit();
            }

            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type_id'] = $user['user_type_id'];
            $_SESSION['user_type'] = $user['type_name'];
            
            // Regenerate session ID for security
            session_regenerate_id(true);

            // Set session timeout to 2 hours
            $_SESSION['expires'] = time() + (2 * 60 * 60);

            if ($user['user_type_id'] == 1) {
                header("Location: ../tripko-frontend/file_html/dashboard.php");
            } else {
                header("Location: ../tripko-frontend/file_html/homepage.php");
            }
            exit();
        } else {
            error_log("Login failed - Invalid credentials for user: " . $username);
            header("Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=invalid");
            exit();
        }
    }
} catch(Exception $e) {
    error_log("Database error: " . $e->getMessage());
    header("Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=system");
    exit();
}
?>
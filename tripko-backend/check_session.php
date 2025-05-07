<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkSession($required_type = null) {
    // Check if session exists
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type_id'])) {
        header("Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=session");
        exit();
    }

    // Check session expiration
    if (isset($_SESSION['expires']) && time() > $_SESSION['expires']) {
        session_destroy();
        header("Location: ../tripko-frontend/file_html/SignUp_LogIn_Form.php?error=timeout");
        exit();
    }

    // If specific user type is required
    if ($required_type !== null) {
        if ($_SESSION['user_type_id'] != $required_type) {
            if ($_SESSION['user_type_id'] == 1) {
                header("Location: ../tripko-frontend/file_html/dashboard.php");
            } else {
                header("Location: ../tripko-frontend/file_html/homepage.php");
            }
            exit();
        }
    }

    // Extend session timeout
    $_SESSION['expires'] = time() + (2 * 60 * 60);
}

function checkAdminSession() {
    checkSession(1); // 1 is admin type
}

function checkUserSession() {
    checkSession(2); // 2 is regular user type
}

function isAdmin() {
    return isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>
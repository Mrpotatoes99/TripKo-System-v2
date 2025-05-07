<?php
// db.php

$servername = "localhost";   // usually localhost
$username = "root";           // your database username
$password = "";               // your database password
$dbname = "tripko_db";    // your database name

try {
    // Create mysqli connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset to utf8mb4
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $conn->error);
    }
    
} catch(Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

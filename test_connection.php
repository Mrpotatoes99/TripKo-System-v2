<?php
include_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

if($db) {
    echo "<br>Database connection is working!";
    
    // Test query
    try {
        $query = "SELECT COUNT(*) as count FROM tourist_spots";
        $result = $db->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<br>Number of tourist spots: " . $row['count'];
        } else {
            throw new Exception("Query error: " . $db->error);
        }
    } catch(Exception $e) {
        echo "<br>Query error: " . $e->getMessage();
    }
} else {
    echo "<br>Database connection failed!";
}
?>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: http://localhost");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");

require_once(__DIR__ . '/../../config/db.php');
include_once(__DIR__ . '/../../config/check_session.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }

    $sql = "
        SELECT
            s.spot_id,
            s.name,
            s.description,
            s.town_id,
            s.category,
            s.contact_info,
            s.image_path,
            s.status,
            t.town_name
        FROM tourist_spots AS s
        LEFT JOIN towns AS t ON s.town_id = t.town_id
        " . (!isAdmin() ? "WHERE s.status = 'active' OR s.status IS NULL" : "") . "
        ORDER BY s.spot_id DESC
    ";
    
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }

    echo json_encode(['records' => $records]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
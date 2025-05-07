<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include your DB connection
require_once(__DIR__ . '/../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }

    $sql = "
      SELECT
        f.festival_id as id,
        f.name,
        f.description,
        f.date,
        f.status,
        f.image_path,
        f.town_id,
        t.town_name
      FROM festivals AS f
      LEFT JOIN towns AS t ON f.town_id = t.town_id
      ORDER BY f.date DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }

    echo json_encode(['records' => $records]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Could not read festivals: ' . $e->getMessage()
    ]);
}

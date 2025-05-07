<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once(__DIR__ . '/../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing festival ID']);
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
        WHERE f.festival_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $festival = $result->fetch_assoc();

    if ($festival) {
        echo json_encode(['success' => true, 'festival' => $festival]);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Festival not found']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
<?php
require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../config/check_session.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if (!isAdmin()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

try {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['spot_id']) || !isset($data['status'])) {
        throw new Exception('Missing required fields');
    }

    $spot_id = $data['spot_id'];
    $status = $data['status'];

    if (!in_array($status, ['active', 'inactive'])) {
        throw new Exception('Invalid status value');
    }

    $stmt = $conn->prepare("UPDATE tourist_spots SET status = ? WHERE spot_id = ?");
    $stmt->bind_param("si", $status, $spot_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to update status');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
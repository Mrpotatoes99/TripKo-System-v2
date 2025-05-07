<?php
require_once(__DIR__ . '/../../config/db.php');
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents('php://input'), true);
$itinerary_id = $data['itinerary_id'] ?? '';
$status = $data['status'] ?? '';

if (!$itinerary_id || !$status || !in_array($status, ['active', 'inactive'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid itinerary ID or status']);
    exit;
}

$stmt = $conn->prepare("UPDATE itineraries SET status = ? WHERE itinerary_id = ?");
$stmt->bind_param("si", $status, $itinerary_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update itinerary status']);
}
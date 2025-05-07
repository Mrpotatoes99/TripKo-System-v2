<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once(__DIR__ . '/../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }

    $festival_id = $_POST['festival_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $description = $_POST['description'] ?? null;
    $date = $_POST['date'] ?? null;
    $town_id = $_POST['municipality'] ?? null;

    if (!$festival_id || !$name || !$description || !$date || !$town_id) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Handle image upload if a new image was provided
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/TripKo-System/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = $filename;
            
            // Update with new image
            $stmt = $conn->prepare("UPDATE festivals SET name = ?, description = ?, date = ?, town_id = ?, image_path = ? WHERE festival_id = ?");
            $stmt->bind_param("sssisi", $name, $description, $date, $town_id, $image_path, $festival_id);
        } else {
            throw new Exception("Failed to upload image");
        }
    } else {
        // Update without changing the image
        $stmt = $conn->prepare("UPDATE festivals SET name = ?, description = ?, date = ?, town_id = ? WHERE festival_id = ?");
        $stmt->bind_param("sssii", $name, $description, $date, $town_id, $festival_id);
    }

    $stmt->execute();

    if ($stmt->affected_rows >= 0) { // Using >= 0 because even if no changes were made, it's still a success
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update festival']);
    }

    $stmt->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
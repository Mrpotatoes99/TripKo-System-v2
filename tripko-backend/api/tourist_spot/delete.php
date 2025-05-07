<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/db.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        throw new Exception('Invalid request method');
    }

    $spot_id = isset($_GET['spot_id']) ? $_GET['spot_id'] : null;
    
    if (!$spot_id) {
        throw new Exception('Missing spot_id parameter');
    }

    // Start transaction
    $conn->begin_transaction();

    // Get image path before deletion
    $stmt = $conn->prepare("SELECT image_path FROM tourist_spots WHERE spot_id = ?");
    $stmt->bind_param("i", $spot_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $spot = $result->fetch_assoc();

    // First delete related records from visitors_tracking
    $stmt = $conn->prepare("DELETE FROM visitors_tracking WHERE spot_id = ?");
    $stmt->bind_param("i", $spot_id);
    $stmt->execute();

    // Then delete the tourist spot
    $stmt = $conn->prepare("DELETE FROM tourist_spots WHERE spot_id = ?");
    $stmt->bind_param("i", $spot_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // If deletion was successful and there was an image, delete it
        if ($spot && $spot['image_path']) {
            $image_path = "../../../uploads/" . $spot['image_path'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        // Commit the transaction
        $conn->commit();
        
        echo json_encode([
            "success" => true,
            "message" => "Tourist spot and related records deleted successfully."
        ]);
    } else {
        throw new Exception("Tourist spot not found");
    }

} catch (Exception $e) {
    // Rollback the transaction on error
    if ($conn && $conn->connect_error === null) {
        $conn->rollback();
    }
    
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
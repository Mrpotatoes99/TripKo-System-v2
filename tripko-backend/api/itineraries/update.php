<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/db.php';

try {
    // Get posted data
    $itinerary_id = isset($_POST['itinerary_id']) ? $_POST['itinerary_id'] : die(json_encode(["success" => false, "message" => "Missing itinerary ID"]));
    $destination = isset($_POST['destination']) ? $_POST['destination'] : null;
    $name = isset($_POST['itinerary_name']) ? $_POST['itinerary_name'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $environmental_fee = isset($_POST['environmental_fee']) ? $_POST['environmental_fee'] : null;
    $max_visitors = isset($_POST['max_visitors']) ? $_POST['max_visitors'] : null;

    // Validate required fields
    if (!$name || !$description || !$destination) {
        die(json_encode([
            "success" => false,
            "message" => "Missing required fields"
        ]));
    }

    // Start transaction
    $conn->begin_transaction();

    // Update itinerary basic info
    $stmt = $conn->prepare("UPDATE itineraries SET 
        destination_id = ?, 
        name = ?, 
        description = ?, 
        environmental_fee = ?, 
        max_visitors = ?
        WHERE itinerary_id = ?");

    $stmt->bind_param("issdii", 
        $destination,
        $name,
        $description,
        $environmental_fee,
        $max_visitors,
        $itinerary_id
    );

    if (!$stmt->execute()) {
        throw new Exception("Failed to update itinerary");
    }

    // Handle image uploads if any
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $uploadDir = "../../../uploads/";
        $uploadedFiles = [];
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Process each uploaded file
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['images']['name'][$key];
            $file_size = $_FILES['images']['size'][$key];
            $file_tmp = $_FILES['images']['tmp_name'][$key];
            $file_type = $_FILES['images']['type'][$key];
            
            // Generate unique filename
            $uniqueName = uniqid() . '_' . $file_name;
            $targetFile = $uploadDir . $uniqueName;
            
            // Move uploaded file
            if (move_uploaded_file($file_tmp, $targetFile)) {
                $uploadedFiles[] = $uniqueName;
                
                // Insert image record
                $stmt = $conn->prepare("INSERT INTO itinerary_images (itinerary_id, image_path) VALUES (?, ?)");
                $stmt->bind_param("is", $itinerary_id, $uniqueName);
                
                if (!$stmt->execute()) {
                    throw new Exception("Failed to save image record");
                }
            } else {
                throw new Exception("Failed to upload image: " . $file_name);
            }
        }
    }

    // Commit transaction
    $conn->commit();

    // Return success response
    echo json_encode([
        "success" => true,
        "message" => "Itinerary updated successfully"
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
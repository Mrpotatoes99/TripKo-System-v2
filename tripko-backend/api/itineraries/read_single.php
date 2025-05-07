<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/db.php';

try {
    // Get ID from query string
    $id = isset($_GET['id']) ? intval($_GET['id']) : die(json_encode([
        "success" => false,
        "message" => "Missing itinerary ID"
    ]));

    // Prepare query
    $query = "SELECT i.*, t.name as destination_name, 
              GROUP_CONCAT(ii.image_path) as image_paths
              FROM itineraries i 
              LEFT JOIN towns t ON i.destination_id = t.town_id
              LEFT JOIN itinerary_images ii ON i.itinerary_id = ii.itinerary_id
              WHERE i.itinerary_id = ?
              GROUP BY i.itinerary_id";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $itinerary = $result->fetch_assoc();
            
            // Convert image_paths string to array if exists
            if ($itinerary['image_paths']) {
                $itinerary['images'] = explode(',', $itinerary['image_paths']);
                unset($itinerary['image_paths']); // Remove the concatenated string
            } else {
                $itinerary['images'] = [];
            }

            echo json_encode([
                "success" => true,
                "itinerary" => $itinerary
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Itinerary not found"
            ]);
        }
    } else {
        throw new Exception("Failed to execute query");
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
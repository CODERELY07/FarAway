<?php

require_once './../../connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $property_id = $_POST['property_id'];
    $amenity = $_POST['amenity'];

    
    try {

        // Fetch current amenities value from the database
        $stmt = $conn->prepare("SELECT amentities FROM properties WHERE property_id = :property_id");
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        // echo json_encode(['message' => $property, 'success' => true]);

   
        if ($property) {
          
            $amentities = $property['amentities'];
          
            // Remove the specified amenity from the list
            $amenitiesArray = explode(',', $amentities);  
            if (in_array($amenity, $amenitiesArray)) {
                $updatedAmenities = array_diff($amenitiesArray, [$amenity]);  // Remove the selected amenity
          
                // // Recreate the amenities list as a string
                $updatedAmenitiesString = implode(',', $updatedAmenities);
                
                // // Update the database with the new amenities list
                $updateStmt = $conn->prepare("UPDATE properties SET amentities = :amentities WHERE property_id = :property_id");
                $updateStmt->bindParam(':amentities', $updatedAmenitiesString, PDO::PARAM_STR);
                $updateStmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
                $updateStmt->execute();

                // Respond with success
                echo json_encode(['success' => true]);
            } else {
                // Amenity not found in the list
                echo json_encode(['success' => false, 'message' => 'Amenity not found']);
            }
        } else {
            // Property not found
            echo json_encode(['success' => false, 'message' => 'Property not found']);
        }
    } catch (PDOException $e) {
        // Send an error response if something goes wrong
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>

<?php

require_once './../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $property_id = $_POST['property_id'];
    
    try {
        // First, delete related rows from history
        $stmt = $conn->prepare("DELETE FROM history WHERE property_id = :property_id");
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();

        // First, delete related photos from the property_photos table
        $stmt = $conn->prepare("DELETE FROM property_photos WHERE property_id = :property_id");
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Then, delete the property from the properties table
        $stmt = $conn->prepare("DELETE FROM properties WHERE property_id = :property_id");
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Property deleted successfully', 'redirect' => './views/host/manage_properties.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Property not found']);
        }
    } catch (PDOException $e) {
        // Send an error response if something goes wrong
        echo json_encode(['success' => false, 'message' => $e->getMessage(), 'error' => $e->getMessage()]);
    }
}

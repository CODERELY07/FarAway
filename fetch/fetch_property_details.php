<?php
session_start();
include './../connection.php'; 

if (isset($_GET['id'])) {
    $propertyId = $_GET['id'];
    $host_id = $_SESSION['user_id']; 
    
    try {
    
        // $stmt = $conn->prepare("SELECT * FROM properties WHERE property_id = :property_id AND host_id = :host_id");
        $stmt = $conn->prepare("SELECT p.*, c.*, u.*,p.name AS property_name, u.name AS host_name
                        FROM properties p
                        JOIN categories c ON p.category_id = c.category_id
                        JOIN users u ON p.host_id = u.user_id
                        WHERE p.property_id = :property_id AND p.host_id = :host_id");

        $stmt->bindParam(':property_id', $propertyId);
        $stmt->bindParam(':host_id', $host_id);
        $stmt->execute();

        $propertyData = $stmt->fetch(PDO::FETCH_ASSOC);  

        if ($propertyData) {
        
            $photoStmt = $conn->prepare("SELECT * FROM property_photos WHERE property_id = :property_id");
            $photoStmt->bindParam(':property_id', $propertyId);
            $photoStmt->execute();

     
            $photos = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

  
            $propertyData['photos'] = $photos;
            
            echo json_encode($propertyData);
        } else {
            echo json_encode(["error" => "Property not found or doesn't belong to the host."]);
        }
    } catch (PDOException $e) {
        // Error handling
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
} else {
    // If no property ID is provided in the request
    echo json_encode(["error" => "No property ID provided."]);
}
?>

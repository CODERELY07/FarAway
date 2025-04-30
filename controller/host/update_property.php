<?php

require_once './../../connection.php';


$property_id = $_POST['id'];
$column = $_POST['column'];
$value = $_POST['value'];

try {
    $stmt = $conn->prepare("UPDATE properties SET $column = :value WHERE property_id = :property_id");
    $stmt->execute(['value' => $value, 'property_id' => $property_id]);
    echo json_encode(['properties' => 'data updated Successfully!']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

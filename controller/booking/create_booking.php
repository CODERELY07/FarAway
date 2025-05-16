<?php
require_once './../../connection.php';
session_start();
try {

    $user_id = (int) $_POST['user_id'];
    $property_id = (int) $_POST['property_id'];
    $check_in = $_POST['check_in_date'];
    $check_out = $_POST['check_out_date'];

    // Basic validation
    if (!$check_in || !$check_out || $check_in >= $check_out) {
        die("Invalid check-in or check-out date.");
    }

    // Check for overlapping bookings
    $stmt = $conn->prepare("
        SELECT * FROM reservation
        WHERE property_id = :property_id
        AND status IN ('pending', 'booked')
        AND NOT (check_out_date <= :check_in OR check_in_date >= :check_out)
    ");
    $stmt->execute([
        ':property_id' => $property_id,
        ':check_in' => $check_in,
        ':check_out' => $check_out
    ]);

    if ($stmt->rowCount() > 0) {
        echo "Property already booked for the selected dates.";
    } else {
        // Insert new reservation
        $insert = $conn->prepare("
            INSERT INTO reservation (user_id, property_id, status, check_in_date, check_out_date)
            VALUES (:user_id, :property_id, 'pending', :check_in, :check_out)
        ");
        $insert->execute([
            ':user_id' => $user_id,
            ':property_id' => $property_id,
            ':check_in' => $check_in,
            ':check_out' => $check_out
        ]);

        echo "Booking request sent! Reservation ID: " . $conn->lastInsertId();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

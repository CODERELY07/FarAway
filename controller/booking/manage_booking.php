<?php
require_once './../../connection.php';
session_start();
$host_id = $_SESSION['user_id'];
$reservation_id = (int) $_POST['reservation_id'];
$action = $_POST['action'];

try {
    $stmt = $conn->prepare("
        SELECT r.reservation_id, p.host_id
        FROM reservation r
        JOIN properties p ON r.property_id = p.property_id
        WHERE r.reservation_id = :reservation_id AND p.host_id = :host_id AND r.status = 'pending'
    ");
    $stmt->execute([':reservation_id' => $reservation_id, ':host_id' => $host_id]);
    $res = $stmt->fetch();

    if (!$res) {
        http_response_code(403);
        echo "Unauthorized or invalid reservation.";
        exit;
    }

    $newStatus = $action === 'accept' ? 'booked' : 'canceled';
    $update = $conn->prepare("UPDATE reservation SET status = :status WHERE reservation_id = :reservation_id");
    $update->execute([':status' => $newStatus, ':reservation_id' => $reservation_id]);

    echo "Reservation " . ($action === 'accept' ? "accepted!" : "declined!");

} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}
?>

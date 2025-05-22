<?php
require_once './../../connection.php';
session_start();

$host_id = $_SESSION['user_id'];
$reservation_id = (int) $_POST['reservation_id'];
$action = $_POST['action'];

try {
    // Check if reservation belongs to host either in reservation or history
    $stmt = $conn->prepare("
        SELECT r.reservation_id, p.host_id
        FROM reservation r
        JOIN properties p ON r.property_id = p.property_id
        WHERE r.reservation_id = :reservation_id AND p.host_id = :host_id
        UNION
        SELECT h.reservation_id, p.host_id
        FROM history h
        JOIN properties p ON h.property_id = p.property_id
        WHERE h.reservation_id = :reservation_id AND p.host_id = :host_id
    ");
    $stmt->execute([':reservation_id' => $reservation_id, ':host_id' => $host_id]);
    $res = $stmt->fetch();

    if (!$res) {
        http_response_code(403);
        echo "Unauthorized or invalid reservation.";
        exit;
    }

    if ($action === 'done') {
        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT * FROM reservation WHERE reservation_id = :reservation_id");
        $stmt->execute([':reservation_id' => $reservation_id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            $conn->rollBack();
            http_response_code(404);
            echo "Reservation not found.";
            exit;
        }

        $insert = $conn->prepare("
            INSERT INTO history (reservation_id, user_id, property_id, check_in_date, check_out_date)
            VALUES (:reservation_id, :user_id, :property_id, :check_in_date, :check_out_date)
        ");
        $insert->execute([
            ':reservation_id' => $reservation['reservation_id'],
            ':user_id' => $reservation['user_id'],
            ':property_id' => $reservation['property_id'],
            ':check_in_date' => $reservation['check_in_date'],
            ':check_out_date' => $reservation['check_out_date'],
        ]);

        $delete = $conn->prepare("DELETE FROM reservation WHERE reservation_id = :reservation_id");
        $delete->execute([':reservation_id' => $reservation_id]);

        $conn->commit();
        echo "Reservation marked as done and moved to history.";

    } elseif ($action === 'undone') {
        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT * FROM history WHERE reservation_id = :reservation_id");
        $stmt->execute([':reservation_id' => $reservation_id]);
        $history = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$history) {
            $conn->rollBack();
            http_response_code(404);
            echo "History record not found.";
            exit;
        }

        $insert = $conn->prepare("
            INSERT INTO reservation (reservation_id, user_id, property_id, check_in_date, check_out_date, status)
            VALUES (:reservation_id, :user_id, :property_id, :check_in_date, :check_out_date, 'booked')
        ");
        $insert->execute([
            ':reservation_id' => $history['reservation_id'],
            ':user_id' => $history['user_id'],
            ':property_id' => $history['property_id'],
            ':check_in_date' => $history['check_in_date'],
            ':check_out_date' => $history['check_out_date'],
        ]);

        $delete = $conn->prepare("DELETE FROM history WHERE reservation_id = :reservation_id");
        $delete->execute([':reservation_id' => $reservation_id]);

        $conn->commit();
        echo "Reservation marked as undone and moved back to reservations.";

    } elseif ($action === 'delete') {
        $delete = $conn->prepare("DELETE FROM history WHERE reservation_id = :reservation_id");
        $delete->execute([':reservation_id' => $reservation_id]);
        echo "History record deleted.";
    } else {
        http_response_code(400);
        echo "Invalid action.";
    }
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}
?>

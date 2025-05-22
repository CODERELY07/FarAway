<?php
require_once './../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action'];

    try {
        if ($action === 'done') {
            $conn->beginTransaction();

            // Fetch reservation data
            $stmt = $conn->prepare("SELECT * FROM reservation WHERE reservation_id = :reservation_id");
            $stmt->execute([':reservation_id' => $reservation_id]);
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$reservation) {
                echo "Reservation not found.";
                exit;
            }

            // Insert into history table
            $insert = $conn->prepare("
                INSERT INTO history (user_id, property_id, reservation_id, status, check_in_date, check_out_date)
                VALUES (:user_id, :property_id, :reservation_id, 'done', :check_in_date, :check_out_date)
            ");
            $insert->execute([
                ':user_id' => $reservation['user_id'],
                ':property_id' => $reservation['property_id'],
                ':reservation_id' => $reservation['reservation_id'],
                ':check_in_date' => $reservation['check_in_date'],
                ':check_out_date' => $reservation['check_out_date']
            ]);

            // Delete reservation
            $delete = $conn->prepare("DELETE FROM reservation WHERE reservation_id = :reservation_id");
            $delete->execute([':reservation_id' => $reservation_id]);

            $conn->commit();

            echo "Reservation moved to history and deleted.";
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM reservation WHERE reservation_id = :reservation_id");
            $stmt->execute([':reservation_id' => $reservation_id]);
            echo "Reservation deleted.";
        } else {
            echo "Invalid action.";
        }
    } catch (PDOException $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        echo "Error: " . $e->getMessage();
    }
}
?>

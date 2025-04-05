<?php

include './../../connection.php';
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE verification_token = :token LIMIT 1");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $userId = $user['user_id'];

        // Update verified_email and clear token
        $stmt = $conn->prepare("UPDATE users SET verified_email = NOW(), verification_token = NULL WHERE user_id = :id");
        $stmt->bindParam(':id', $userId);

        if ($stmt->execute()) {
            unset($_SESSION['message']);
            header("Location: ./../../index.php");
            exit;
        } else {
            echo "Verification failed. Please try again.";
        }
    } else {
        echo "Invalid or expired verification link.";
    }
} else {
    echo "No token provided.";
}
?>

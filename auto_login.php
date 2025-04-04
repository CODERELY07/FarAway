<?php
session_start();
include './connection.php';

$response = ['loggedIn' => false];

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me']) && isset($_COOKIE['user_email'])) {
    $email = $_COOKIE['user_email'];
    $token = $_COOKIE['remember_me'];

    try {
        $stmt = $conn->prepare("SELECT user_id, name FROM users WHERE email = :email AND remember_me = :token");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['name'];
            $response['loggedIn'] = true;
            $response['username'] = $user['name'];
        }
    } catch (PDOException $e) {
        error_log("Auto login error: " . $e->getMessage());
    }
}

echo json_encode($response);

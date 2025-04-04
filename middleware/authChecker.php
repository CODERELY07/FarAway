<?php

    session_start();
    include './../../connection.php';
    // Check if the user is already logged in
    if (isset($_SESSION['user_id']) ) {
        // Redirect to dashboard or home page
        header('Location: ./../../index.php');
        exit;
    }

    // Check for remember_me cookies
    if (isset($_COOKIE['remember_me']) && isset($_COOKIE['user_email'])) {
        $email = $_COOKIE['user_email'];
        $token = $_COOKIE['remember_me'];

        try {
            // Prepare SQL query to find the user by email and token
            $stmt = $conn->prepare("SELECT user_id, name FROM users WHERE email = :email AND remember_me = :token");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                // Fetch the user data
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['name'];
                header('Location: ./../../index.php');
            }
        } catch (PDOException $e) {
            // Handle any database errors
            error_log("Database Error: " . $e->getMessage());
        }
    }

?>
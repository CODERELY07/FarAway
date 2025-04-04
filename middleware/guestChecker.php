<?php
    // Check if the user is already logged in
    if (!isset($_SESSION['user_id']) ) {
        // Redirect to dashboard or home page
        header('Location: ./signin.php');
        exit;
    }
?>
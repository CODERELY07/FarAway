<?php
    session_start();

    session_unset();

    session_destroy();

    setcookie('user_email', '', time() - 3600, '/');  
    setcookie('user_password', '', time() - 3600, '/');  

    header('Location: ./views/auth/signin.php');
    exit;
?>
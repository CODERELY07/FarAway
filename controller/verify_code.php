<?php
session_start(); 

if (isset($_POST['token']) && isset($_POST['code'])) {
    if ($_POST['token'] !== $_SESSION['reset_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid session token.', 'code' => 'first' . $_POST['code']]);
        exit;
    }
    if (isset($_SESSION['verification_code']) && $_POST['code'] == $_SESSION['verification_code']) {
        echo json_encode([
            "success" => true,
            "redirect" => "./views/auth/reset_password.php"
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid verification code.', 'code' => 'second' . $_POST['code']]);
    }
}
?>
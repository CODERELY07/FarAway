<?php
session_start();
include './../connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    if (strlen($newPassword) < 6 || !preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/\d/', $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long and contain both letters and numbers.']);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);


    if (!isset($_SESSION['verification_email'])) {
        echo json_encode(['success' => false, 'message' => 'No verification email found in session.']);
        exit;
    }

    $userEmail = $_SESSION['verification_email'];


    $stmt = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");

    if ($stmt->execute(['password' => $hashedPassword, 'email' => $userEmail])) {

        session_destroy();
        unset($_SESSION);
        
        echo json_encode(['success' => true, 'message' => 'Password has been reset successfully.', 'redirect' => './views/auth/signin.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to reset the password. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
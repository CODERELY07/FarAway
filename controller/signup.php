<?php

include './../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $terms = isset($_POST['terms']) ? $_POST['terms'] : '';
    $errors = [];
    
    // Validate Name
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    } elseif (strlen($name) < 3) {
        $errors['name'] = "Name must be at least 3 characters long.";
    }
    if (empty($terms) || $terms !== 'on') {
        $errors['terms'] = "You must agree to the Terms and Conditions.";
    }
    // Validate Email
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Validate Password
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $errors['password'] = "Password must be at least 8 characters long and contain both letters and numbers.";
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }


    try {
        // Check if email exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'errors' => ['email' => 'This email is already registered.']]);
            exit;
        }

        // Hash Password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert User
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User registered successfully.', 'redirect' => './signin.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'An error occurred during registration.']);
        }
        exit;

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
?>

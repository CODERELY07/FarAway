<?php
// TODO: Remove the error reporting and aother for debugging create separate folder for documentation
ob_start();
session_start();
include './../connection.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input fields
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = $_POST['remember_me'] ?? '';
    // recaptcha
    $g_recaptcha = $_POST['g-recaptcha-response'] ?? '';
    $errors = [];

    // Check if both fields are filled
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }
    if(empty($g_recaptcha)){
        $errors['message'] = "Please verify that you are not a robot.";
    }

     // recaptcha

    // If there are errors, send them as a response
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }
    // recaptcha
    if(isset($g_recaptcha) && $g_recaptcha == ''){
 
        $secretKey = "6LfU5AkrAAAAACBrzDv9R7iJ3dqodsRmOynj9EDt";
        $response = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR']; 
     
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
        $response = file_get_contents($url);

        $responseKeys = json_decode($response, true);

        if ($responseKeys['success'] !== true) {
            $errors['message'] = "Please verify that you are not a robot.";
        } else {
            $errors['message'] = "reCAPTCHA verified successfully!";
        }
        
    }
   
    try {
        // Prepare SQL query
        $stmt = $conn->prepare("SELECT user_id, password, name, remember_me,email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($stmt->rowCount() === 1) {
            // Fetch the user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the password matches
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];

                // Remember ME token
                if (isset($_POST['remember_me'])) {
                    $token = bin2hex(random_bytes(16));

                    $updateStmt = $conn->prepare("UPDATE users SET remember_me = :token WHERE user_id = :user_id");
                    $updateStmt->bindParam(':token', $token);
                    $updateStmt->bindParam(':user_id', $user['user_id']);
                    $updateStmt->execute();

                    // Set cookies to remember the user for 30 days
                    setcookie("user_email", $email, time() + (30 * 24 * 60 * 60), "/");
                    setcookie("remember_me", $token, time() + (30 * 24 * 60 * 60), "/");
                } else {
                    // If not checked, clear cookies and token
                    setcookie("user_email", "", time() - 3600, "/");
                    setcookie("remember_me", "", time() - 3600, "/");
                    
                    // Clear the remember token in the database
                    $updateStmt = $conn->prepare("UPDATE users SET remember_me = NULL WHERE user_id = :user_id");
                    $updateStmt->bindParam(':user_id', $user['user_id']);
                    $updateStmt->execute();
                }

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['email'] = $user['email'];
         
                // Send a success response
                echo json_encode(['success' => true, 'message' => 'Login successful.', 'redirect' => './views/auth/verify_email.php']);
                exit;
            } else {
                // Password mismatch error
                echo json_encode(['success' => false, 'message' => 'Invalid Credintials.']);
            }
        } else {
            // User not found
            echo json_encode(['success' => false, 'message' => 'No user found with that email.']);
        }

    } catch (PDOException $e) {
        // Database error handling
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}

// End output buffering and flush the output buffer
ob_end_flush();
?>

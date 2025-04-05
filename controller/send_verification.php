<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

ini_set('display_errors', 1);  // Disable error display
error_reporting(E_ALL);         // Enable error reporting
ini_set('log_errors', 1);       // Enable error logging
ini_set('error_log', 'debug.log'); // Specify log file

// Use PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './../connection.php';

require './../vendor/autoload.php'; 


session_start(); 
ob_clean();


if (isset($_POST['resetEmail'])) {
  $email = $_POST['resetEmail'];

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['success' => false, 'message' => 'Invalid email address']);
      
      exit;
   }
   
   try {
          // Prepare SQL query
          $stmt = $conn->prepare("SELECT email FROM users WHERE email = :email");
          $stmt->bindParam(':email', $email, PDO::PARAM_STR);
          $stmt->execute();
          
          if ($stmt->rowCount() === 1) {
               // Fetch the user data
               $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    
               $verificationCode = rand(100000, 999999);

               $resetToken = bin2hex(random_bytes(16)); 


               $_SESSION['verification_code'] = $verificationCode;
               $_SESSION['verification_email'] = $email;
               $_SESSION['reset_token'] = $resetToken;

          
               $mail = new PHPMailer(true);

               $debugOutput = '';

               try {
                    
                    $mail->isSMTP(); 
                    $mail->Host = 'smtp.gmail.com'; 
                    $mail->SMTPAuth = true; 
                    $mail->Username = 'calipjo.markely@gmail.com'; 
                    $mail->Password = 'mogn trwp crra eose';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                    $mail->Port = 587; 

                    $mail->setFrom('calipjo.markely@gmail.com', 'Mark Ely Calipjo');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Code';
                    $mail->Body    = "Your verification code is: <strong>$verificationCode</strong>";

                    // Enable debugging
                    $mail->SMTPDebug = 2; 
                    $mail->Debugoutput = function($str) use (&$debugOutput) { $debugOutput .= $str . "\n"; };

                    // Send email
                    $mail->send();

                    echo json_encode(['success' => true, 'token' => $resetToken, 'message' => 'Email Send Success', 'redirect' => './views/auth/verify_code.php']);
               } catch (Exception $e) {
                    error_log('Mailer Error: ' . $mail->ErrorInfo);
                    echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo, 'debug' => $debugOutput]);
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
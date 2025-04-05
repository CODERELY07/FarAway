<?php

session_start();
include './../connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './../vendor/autoload.php';
echo $_SESSION['name'] . "es";
if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT verified_email,verification_token FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
        if(is_null($result['verified_email']) && is_null($result['verification_token'])){  
            $email = $_SESSION['email'];
            $name = $_SESSION['username'];
            $token = bin2hex(random_bytes(32)); // Secure random token
            $verificationLink = "http://localhost/FarAway/views/auth/verify.php?token=" . $token;

            // Save token in DB
            $stmt = $conn->prepare("UPDATE users SET verification_token = :token WHERE email = :email");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Send email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'calipjo.markely@gmail.com';
                $mail->Password = 'enbe zjec fwiu zzoa';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('calipjo.markely@gmail.com', 'Mark Ely Calipjo');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Verify your email address';
                $mail->Body = "
                    <h2>Hi {$name},</h2>
                    <p>Please verify your email by clicking the link below:</p>
                    <a href='{$verificationLink}'>Verify Email</a>
                    <br><br>
                    <small>If you didn't sign up, you can ignore this email.</small>
                ";
                $mail->send();
                header("Location: ./../views/auth/verify_email.php");
                $_SESSION['message'] = "Check Your Email to verify";
                exit;
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }

        }else{
            header("Location: ./../views/auth/verify_email.php");
            exit;
        }
    }
}
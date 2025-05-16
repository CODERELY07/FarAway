<?php
require 'db.php';

$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$message_text = $_POST['message_text'];

if (empty($sender_id) || empty($receiver_id) || empty($message_text)) {
    die("All fields are required.");
}

$stmt = $conn->prepare("INSERT INTO messages (sender_id, reciever_id, message_text) VALUES (?, ?, ?)");
$stmt->execute([$sender_id, $receiver_id, $message_text]);

echo "Message sent successfully!";
?>

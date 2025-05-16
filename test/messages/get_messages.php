<?php
require 'db.php';

$user1 = $_GET['user1'];
$user2 = $_GET['user2'];

$stmt = $conn->prepare("
    SELECT m.message_id, m.message_text, m.sender_id, m.reciever_id, m.sent_at, u.name AS sender_name
    FROM messages m
    JOIN users u ON m.sender_id = u.user_id
    WHERE (m.sender_id = ? AND m.reciever_id = ?)
       OR (m.sender_id = ? AND m.reciever_id = ?)
    ORDER BY m.sent_at ASC
");

$stmt->execute([$user1, $user2, $user2, $user1]);
$messages = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($messages);
?>

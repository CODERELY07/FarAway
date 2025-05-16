<?php
require 'db.php';

$stmt = $conn->query("SELECT user_id, name FROM users ORDER BY name");
$users = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($users);
?>

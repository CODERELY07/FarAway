<?php

    session_start();
    include './../connection.php';
    $host_id = $_SESSION['user_id'];

    try{
        $stmt = $conn->prepare("SELECT * FROM properties WHERE host_id = :host_id");
        $stmt->bindParam(':host_id', $host_id);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
  
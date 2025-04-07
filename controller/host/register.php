<?php
    session_start();
    require_once './../../connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $address = isset($_POST['address']) ? htmlspecialchars(trim($_POST['address'])) : '';
        $shopname = isset($_POST['shopname']) ? trim($_POST['shopname']) : '';
        $user_id = $_SESSION['user_id'];
        $errors = [];
    
        // Validate Address
        if (empty($address)) {
            $errors['address'] = "Address is required.";
        }
    
        // Validate Shop Name
        if (empty($shopname)) {
            $errors['shopname'] = "Shop name is required.";
        }
    
        // Check if shop name is already taken
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE shopname = :shopname LIMIT 1");
        $stmt->bindParam(':shopname', $shopname);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $errors['shopname'] = "This Shop Name is already registered.";
        }

        // If there are validation errors, return them
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit;
        }
        
        try {
            // Correct SQL statement: no quotes around placeholders
            $stmt = $conn->prepare("UPDATE users SET shopname = :shopname, address = :address WHERE user_id = :user_id");
            $stmt->bindParam(':shopname', $shopname);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':user_id', $user_id);
            
            if ($stmt->execute()) {
                // Successful update, return success message and redirect path
                echo json_encode(['success' => true, 'message' => 'User updated successfully.', 'redirect' => './logout.php']);
            } else {
                // If update failed, return failure message
                echo json_encode(['success' => false, 'message' => 'An error occurred during the update.']);
            }
            exit;
    
        } catch (PDOException $e) {
            // Handle database error
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
?>

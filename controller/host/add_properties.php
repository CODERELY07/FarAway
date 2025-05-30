<?php
// Include database connection


session_start();
require_once './../../connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize response
    $response = array('status' => 'error', 'message' => 'Something went wrong.');

    // Validate required fields
    if (isset($_POST['name'], $_POST['category_id'], $_POST['description'], $_POST['region'], $_POST['province'], $_POST['city'], $_POST['price'], $_POST['barangay'], $_POST['max_guest'], $_POST['num_bed'], $_POST['num_baths'])) {

        // Prepare data
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $region = $_POST['region_text'];
        $province = $_POST['province_text'];
        $city = $_POST['city_text'];
        $barangay = $_POST['barangay_text'];
        $street = $_POST['street'] ?? ''; // Optional
        $zone = $_POST['zone'] ?? ''; // Optional
        $price = $_POST['price'];
        $max_guest = $_POST['max_guest'];
        $num_bed = $_POST['num_bed'];
        $num_baths = $_POST['num_baths'];
        $host_id = $_SESSION['user_id'];

        // Handle amenities (store as a comma-separated list)
        $amenities = isset($_POST['amenities']) ? implode(',', $_POST['amenities']) : null;

        // front photo
        $front_photo = '';
        if (isset($_FILES['front_photo']) && $_FILES['front_photo']['error'] === UPLOAD_ERR_OK) {
            $front_photo_tmp = $_FILES['front_photo']['tmp_name'];
            $front_photo_name = $_SESSION['user_id'] . '_front_' . basename($_FILES['front_photo']['name']);
            $upload_dir = './../../uploads/'; 
            $front_photo_path = $upload_dir . $front_photo_name;

            // Validate file type and size
            $file_type = mime_content_type($front_photo_tmp);
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($file_type, $allowed_types)) {
               
                if (move_uploaded_file($front_photo_tmp, $front_photo_path)) {
                      // change upload dir for fetching
                    $front_photo = './uploads/' . $front_photo_name;
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to upload front photo.'
                    ];
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Invalid front photo file type.'
                ];
                echo json_encode($response);
                exit;
            }
        }

      
      
        // Insert property details into the database, including amenities as a string
        $stmt = $conn->prepare("INSERT INTO properties (host_id, category_id, name, description, region, province, city, barangay, street, zone, price, max_guests, num_bedrooms, num_bathrooms, amentities, front_photo) 
        VALUES (:host_id, :category_id, :name, :description, :region, :province, :city, :barangay, :street, :zone, :price, :max_guests, :num_bedrooms, :num_bathrooms, :amenities, :front_photo)");
        
        $stmt->bindParam(':host_id', $host_id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':barangay', $barangay);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':zone', $zone);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':max_guests', $max_guest);
        $stmt->bindParam(':num_bedrooms', $num_bed);
        $stmt->bindParam(':num_bathrooms', $num_baths);
        $stmt->bindParam(':amenities', $amenities);
        $stmt->bindParam(':front_photo', $front_photo);
        
        // Execute the insert statement
        if ($stmt->execute()) {
            // Get the inserted property ID
            $property_id = $conn->lastInsertId();

            // Handle file uploads (photos)
            if (isset($_FILES['photos']) && count($_FILES['photos']['name']) > 0) {
              
                $upload_dir = './../../uploads/'; // Adjust this path as needed
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true); 
                }

                // Upload other photos
                foreach ($_FILES['photos']['name'] as $key => $name) {
                    $upload_dir = './../../uploads/';
                    $file_tmp = $_FILES['photos']['tmp_name'][$key];
                    $file_name = $_SESSION['user_id'] . '_' . basename($name);
                    $file_path = $upload_dir . $file_name;
                    
                    
                    // Validate file type and size
                    $file_type = mime_content_type($file_tmp);
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($file_type, $allowed_types)) {
                      
                        $response = [
                            'status' => 'error',
                            'message' => 'Invalid file type: ' . $file_name
                        ];
                        
                        $stmt = $conn->prepare("DELETE FROM properties WHERE property_id = :property_id");
                        $stmt->bindParam(':property_id', $property_id);
                        $stmt->execute();
                        echo json_encode($response);
                        exit;
                    }
            
                    // Check if file exists, skip if it does
                    if (file_exists($file_path)) {
                        $response = [
                            'status' => 'error',
                            'message' => 'File already exists: ' . $file_name
                        ];
                        
                        $stmt = $conn->prepare("DELETE FROM properties WHERE property_id = :property_id");
                        $stmt->bindParam(':property_id', $property_id);
                        $stmt->execute();
                        echo json_encode($response);
                        exit;
                    }
            
                    // Move the file and insert into the database
                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $upload_dir = $file_path;
                      
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Failed to upload file: ' . $file_name
                        ];
                        echo json_encode($response);
                        exit;
                    }
                    $upload_dir = './uploads/' . $file_name;
                    $stmt = $conn->prepare("INSERT INTO property_photos (property_id, photo_path) VALUES (:property_id, :upload_dir)");
                    $stmt->bindParam(':property_id', $property_id);
                    $stmt->bindParam(':upload_dir', $upload_dir);
                    $stmt->execute();
   
                }
            }

            // Return success response
            $response = [
                'status' => 'success',
                'message' => 'Property added successfully!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to add property. Please try again.'
            ];
        }
    } else {
        $response = [
        'status' => 'error',
            'message' => 'All required fields must be filled out.'
        ];
    }

    // Return response as JSON
    echo json_encode($response);
}
?>

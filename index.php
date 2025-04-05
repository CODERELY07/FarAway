<?php 
    include './partials/head.php'; 
    include './partials/header.php'; 

    include './connection.php';
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $stmt = $conn->prepare("SELECT verified_email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        
        if($stmt->rowCount() > 0){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if(is_null($result['verified_email'])){
            
                header("Location: ./views/auth/verify_email.php");
                
                exit;
            }
        }
    }
    $response = ['loggedIn' => false];
    
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me']) && isset($_COOKIE['user_email'])) {
        $email = $_COOKIE['user_email'];
        $token = $_COOKIE['remember_me'];
    
        try {
            $stmt = $conn->prepare("SELECT user_id, name FROM users WHERE email = :email AND remember_me = :token");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
    
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['name'];
                $response['loggedIn'] = true;
                $response['username'] = $user['name'];
            }
        } catch (PDOException $e) {
            error_log("Auto login error: " . $e->getMessage());
        }
    }
    
    
?>

<main class="mt-12 ">
    <div class="bg-white flex py-3 px-2 rounded-full  p-2 border-gray-200  shadow-sm overflow-hidden max-w-5xl mx-auto">
        <input type="email" placeholder="Search Place..." class="w-full outline-none bg-white pl-6 text-lg text-gray-700" />
        <button type="button" class="bg-blue-600 hover:bg-blue-700 transition-all text-white text-lg rounded-full px-6 py-3 shadow-lg transform hover:scale-105">
        <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
    <div class="inset-shadow-xs p-3 mt-4 flex items-center justify-center">
      <!-- Category List -->
    <ul id="category-list" class="flex px-2 gap-2 mx-auto pt-5 max-w-4xl overflow-hidden space-x-4 lg:space-x-0 lg:flex-row">
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Student Housing</h5>
            </a>
        </li>
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Townhouses</h5>
            </a>
        </li>
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Office Buildings</h5>
            </a>
        </li>
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Hotels</h5>
            </a>
        </li>
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Apartment</h5>
            </a>
        </li>
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Resorts</h5>
            </a>
        </li>
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Restaurant</h5>
            </a>
        </li>
        <li class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0">
            <a href="#">
                <h5 class="mb-2">Store</h5>
            </a>
        </li>
    </ul>
    <div class="lg:mr-8" style="min-width:80px;text-align:right">
        <span>Filters</span>
        <i class="fa-solid fa-filter"></i>
    </div>
    </div>

    <?php include 'includes/properties.php';?>
</main>
<script>
    // Reload to twice to automcatically refresh
      if (!localStorage.getItem('reloadedOnce')) {
        localStorage.setItem('reloadedOnce', 'true');
        location.reload();
        } else {
            localStorage.removeItem('reloadedOnce');
        }
</script>

<?php include './partials/footer.php'; ?>

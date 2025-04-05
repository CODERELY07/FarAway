<?php 
  session_start();

  include './../../partials/head.php'; 
  include './../../connection.php'; 

  if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT verified_email FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    
    if($stmt->rowCount() > 0){
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
        if(!is_null($result['verified_email'])){
            header("Location: ./../../index.php");
            
            exit;
        }
    }
}
?>

<main class="min-h-screen flex items-center justify-center bg-gray-100">
    

    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-lg">
        <?php 
            if(isset($_SESSION['message'])):
        ?>
        <div class="mt-4 mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md">
            <?php echo $_SESSION['message']?>
        </div>
        <?php endif; ?>
        <div class="text-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Verify Your Email</h2>
        </div>
        <div class="space-y-4">
            <p class="text-gray-600 text-sm">Please verify your email address to continue using your account.</p>
            
            <div class="flex justify-center space-x-4">
                <a href="./controller/verify_email.php" class="w-full text-white bg-blue-600 hover:bg-blue-700 rounded-lg py-2 px-4 text-center transition duration-200">Verify</a>
            </div>

            <div class="flex justify-center mt-4">
                <a href="./logout.php" class="text-blue-600 hover:text-blue-800 text-sm">Logout</a>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>

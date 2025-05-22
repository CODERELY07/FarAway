
<?php 
  session_start();
  include './../../partials/head.php'; 
  require_once './../../connection.php';

  // Check if 'id' is set in the URL
    if (isset($_GET['id'])) {
        $propertyId = $_GET['id'];
    } else {
        echo "Property ID not provided!";
        exit;
    }
?>
<main class="min-h-screen">
    <div class="container w-full" id="property-details">
        <!-- Property details will be dynamically loaded here -->
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./js/fetch.js?<?php echo time()?>"></script>


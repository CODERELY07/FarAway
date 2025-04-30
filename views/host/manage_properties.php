<?php 
  session_start();
  include './../../partials/head.php'; 
  require_once './../../connection.php';
?>
<main class="min-h-screen">
    <div class="w-screen bg-gray-100 flex">
        <?php include './../../partials/host/dashabord_sidebar.php';?>
        <div class="flex-1 bg-white p-6">
            <div class="mt-10 grid max-w-xxl grid-cols-1 gap-6 px-2 md:max-w-screen-xxl md:grid-cols-2 md:px-10 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 3xl:grid-cols-6" id="properties-container">
                <!-- Property cards will be here -->
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./views/host/ph-address-selector.js"></script>
<script src="./js/fetch.js?<?php echo time()?>"></script>


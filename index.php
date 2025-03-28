<?php include './partials/header.php'; ?>

<main class="mt-12 ">
    <div class="bg-white flex py-3 px-2 rounded-full  p-2 border-gray-200  shadow-sm overflow-hidden max-w-5xl mx-auto">
        <input type="email" placeholder="Search Something..." class="w-full outline-none bg-white pl-6 text-lg text-gray-700" />
        <button type="button" class="bg-blue-600 hover:bg-blue-700 transition-all text-white text-lg rounded-full px-6 py-3 shadow-lg transform hover:scale-105">
        <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
    <div class="inset-shadow-xs p-3 mt-4 ">
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
    </div>
    <?php include 'includes/properties.php';?>
</main>


<?php include './partials/footer.php'; ?>

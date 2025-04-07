<?php 
  include './../../partials/head.php'; 
?>

<main class="min-h-screen flex items-center justify-center">
    <section class="shadow-blue-100 mx-auto max-w-screen-lg rounded-xl bg-white text-gray-600 shadow-lg sm:my-10 sm:border">
  <div class="container mx-auto flex flex-col flex-wrap px-5 pb-12">

    <!-- Account Information Section -->
    <div id="account-info" class="flex w-full flex-col">
      <h1 class="text-2xl pt-5 pb-3 font-semibold">Account</h1>
      <p>Register Your Account to Start Leasing</p>
      <form id="registerForm">
        <div class="mt-4 grid items-center gap-3 gap-y-5 sm:grid-cols-4">
            <div class="flex flex-col">
            <label class="mb-1 ml-3 font-semibold text-gray-500">Shop Name</label>
            <input class="rounded-lg border px-2 py-2 shadow-sm outline-none focus:ring" type="text" id="shopname" name="shopname">
            </div>
            <div class="text-red-600" id="shopenameError"></div> 
            <div class="flex flex-col w-full sm:col-span-3">
            <label class="mb-1 ml-3 font-semibold text-gray-500">Address</label>
            <input class="rounded-lg border px-2 py-2 shadow-sm outline-none focus:ring" type="text" id="address" name="address">
            </div>
            <div class="text-red-600" id="addressError"></div> 
            </div>
        </div>
        <div class="flex flex-col justify-between mt-4 sm:flex-row">
            <a href="./index.php">
                <button class="group order-1 my-2 flex w-full items-center justify-center rounded-lg bg-gray-200 py-2 text-center font-bold text-gray-600 outline-none transition sm:w-40 focus:ring hover:bg-gray-300">Cancel</button>
            </a>
            <button type="Submit" id="continue-to-business" class="group my-2 flex w-full items-center justify-center rounded-lg bg-blue-700 py-2 text-center font-bold text-white outline-none transition sm:order-1 sm:w-40 focus:ring">
            Submit
            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:translate-x-2 ml-4 h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
            </button>
        </div>
      </form>
    </div>
    </div>
  </div>
</section>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="./js/main.js"></script>


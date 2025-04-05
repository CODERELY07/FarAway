<?php 
  include './../../partials/head.php'; 
  include './../../middleware/authChecker.php';

?>

<main class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm">
        <div role="alert" class="rounded-md border border-gray-300 bg-white p-4 v shadow-sm" id="popUpMessage">
            <div class="flex items-start gap-4" >
            <div class="flex-1">
                <strong class="font-medium text-red-900" id="status"></strong>

                <p class="mt-0.5 text-sm text-red-700" id="message" ></p>
            </div>
            <button
                class="-m-1 rounded-full p-1.5 text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-700"
                type="button"
                aria-label="Dismiss alert"
            >
            </button>
            </div>
        </div>
        <div class="form-container bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <div class="logo-container text-center text-xl font-semibold mb-4">
            Forgot Password
            </div>

            <form class="form" id="emailForm">
                <div class="form-group mb-4">
                    <label for="resetEmail" class="block text-sm font-medium">Email</label>
                    <input type="text" id="resetEmail" name="resetEmail" placeholder="Enter your email" required class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>

                <button class="form-submit-btn w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition"  id="reset-btn"  type="submit">Send Email</button>
            </form>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>


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
        <form class="otp-Form mt-10" id="codeForm">
            <span class="mainHeading text-xl font-semibold mb-4">Enter Verification Code</span>
        
            <p class="otpSubheading text-gray-600 mb-4">We have sent a verification code to your Email</p>
            <div class="inputContainer flex space-x-2 justify-center mb-4">
                <input required="required" maxlength="1" type="text" class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 caret-blue-500" id="otp-input1">
                <input required="required" maxlength="1" type="text" class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 caret-blue-500" id="otp-input2">
                <input required="required" maxlength="1" type="text" class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 caret-blue-500" id="otp-input3">
                <input required="required" maxlength="1" type="text" class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 caret-blue-500" id="otp-input4">
                <input required="required" maxlength="1" type="text" class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 caret-blue-500" id="otp-input5">
                <input required="required" maxlength="1" type="text" class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 caret-blue-500" id="otp-input6">
            </div>
            <button class="verifyButton bg-blue-500 text-white hover:bg-blue-600 transition-all" id="verify-button" type="submit">Verify</button>
            <!-- <button class="exitBtn">×</button>
            <p class="resendNote">Didn't receive the code? <button class="resendBtn">Resend Code</button></p> -->
        </form>
    </div>
    

</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>


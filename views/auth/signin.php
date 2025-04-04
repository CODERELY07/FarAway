<?php 
  include './../../partials/head.php'; 
  include './../../middleware/authChecker.php';

?>

<main>
<div class="flex w-screen flex-wrap text-slate-800">
  <div class="relative hidden h-screen select-none flex-col justify-center bg-blue-600 text-center md:flex md:w-1/2">
    <div class="mx-auto py-16 px-8 text-white xl:w-[40rem]">
      <span class="rounded-full bg-white px-3 py-1 font-medium text-blue-600">Fast Booking</span>
      <p class="my-6 text-3xl font-semibold leading-10">Be the renter or be the ownser, Let's start your business now!</p>
      <p class="mb-4"> A platform that gives fast and easy access helping you manage bookings with ease.</p>
      <a href="#" class="font-semibold tracking-wide text-white underline underline-offset-4">Learn More</a>
    </div>
    <!-- <img class="mx-auto w-11/12 max-w-lg rounded-lg object-cover" src="/images/SoOmmtD2P6rjV76JvJTc6.png" /> -->
  </div>
  <div class="flex w-full flex-col md:w-1/2">
    <div class="flex justify-center pt-12 md:justify-start md:pl-12">
      <a href="./../../index.php" class="text-2xl font-bold text-blue-600 logo"> FarAway</a>
    </div>
    <div class="my-auto mx-auto flex flex-col justify-center px-6 pt-8 md:justify-start lg:w-[28rem]">
      <p class="text-center text-3xl mb-4 font-bold md:text-left md:leading-tight">Create your free account</p>
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
      <button class="-2 mt-4 flex items-center justify-center rounded-md border px-4 py-1 outline-none ring-gray-400 ring-offset-2 transition hover:border-transparent hover:bg-black hover:text-white focus:ring-2"><img class="mr-2 h-5" src="https://static.vecteezy.com/system/resources/previews/022/613/027/non_2x/google-icon-logo-symbol-free-png.png" alt /> Sign In  with Google</button>
      <div class="relative mt-8 flex h-px place-items-center bg-gray-200">
        <div class="absolute left-1/2 h-6 -translate-x-1/2 bg-white px-4 text-center text-sm text-gray-500">Or use email instead</div>
      </div>
      <form class="flex flex-col items-stretch pt-3 md:pt-8" id="signinForm">
        <div class="flex flex-col pt-4">
          <div class="relative flex overflow-hidden rounded-md border-1 transition focus-within:border-blue-600 border-slate-600">
            <input type="email" id="login-email" name="email" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Email" />
          </div>
          <div class="text-red-600" id="emailErrorSignin"></div> 
        </div>
        <div class="flex justify-end my-1">
          <a href="#" class="mb-2 text-center text-sm font-medium text-gray-600 md:text-left">Forgot password?</a>
        </div>
        <div class="flex flex-col">
          <div class="relative flex overflow-hidden rounded-md border-1 transition focus-within:border-blue-600 border-slate-600">
            <input type="password" id="login-password" name="password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Password (minimum 8 characters)" />
          </div>
          <div class="text-red-600" id="passwordErrorSignin"></div> 
        </div>
        <div class="block mt-3 mb-3">
          <input class="mt-1 mr-2 h-5 w-5 appearance-none rounded border border-gray-300 bg-contain bg-no-repeat align-top text-black shadow checked:bg-blue-500 focus:border-blue-500 focus:shadow" type="checkbox" name="remember_me" id="remember_me" style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 10l3 3l6-6'/%3e%3c/svg%3e&quot;)" />
          <label class="inline-block" for="remember_me"> Remember Me </label>
        </div>
        <div class="g-recaptcha" data-sitekey="6LfU5AkrAAAAABM-BLreTArgHIflZUxXZolwVkJ2" name="g-recaptcha-response"></div>
        <button type="submit" class="mt-6 rounded-lg bg-blue-600 px-4 py-2 text-center text-base font-semibold text-white shadow-md outline-none ring-blue-500 ring-offset-2 transition hover:bg-blue-700 focus:ring-2 md:w-32">Sign in</button>
        <p class="mt-6 text-center font-medium md:text-left">
        Doesn't Have an Account Yet?
        <a href="signup.php" class="whitespace-nowrap font-semibold text-blue-600">Signup here</a>
      </p>
      </form>
    </div>
  </div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./../../js/main.js"></script>


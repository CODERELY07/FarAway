<?php include './../../partials/head.php'; ?>

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
      <a href="./index.php" class="text-2xl font-bold text-blue-600 logo"> Rentify</a>
    </div>
    <div class="my-auto mx-auto flex flex-col justify-center px-6 pt-8 md:justify-start lg:w-[28rem]">
      <p class="text-center text-3xl font-bold md:text-left md:leading-tight">Create your free account</p>
      
      <form class="flex flex-col items-stretch pt-3 md:pt-8" id="signupForm">
        <div class="flex flex-col pt-4">
          <div class="relative flex overflow-hidden rounded-md border-1 transition focus-within:border-blue-600 border-slate-600">
            <input type="text" name="name" id="login-name" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Name" />
          </div>
          <div class="text-red-600" id="nameError"></div> 
        </div>
        <div class="flex flex-col pt-4">
          <div class="relative flex overflow-hidden rounded-md border-1 transition focus-within:border-blue-600 border-slate-600">
            <input type="email" name="email" id="login-email" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Email" />
          </div>
          <div class="text-red-600" id="emailError"></div> 
        </div>
        <div class="mb-4 flex flex-col pt-4">
          <div class="relative flex overflow-hidden rounded-md border-1 transition focus-within:border-blue-600 border-slate-600">
            <input type="password" name="password" id="login-password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Password (minimum 8 characters)" />
          </div>
          <div class="text-red-600" id="passwordError"></div> 
        </div>
        <div class="block">
          <input class="mr-2 h-5 w-5 appearance-none rounded border border-gray-300 bg-contain bg-no-repeat align-top text-black shadow checked:bg-blue-600 focus:border-blue-600 focus:shadow" name="terms" type="checkbox" id="terms" style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 10l3 3l6-6'/%3e%3c/svg%3e&quot;)"/>
          <label class="inline-block" for="terms"> I agree to the <a class="underline" href="#">Terms and Conditions</a></label>
          <div class="text-red-600" id="termsError"></div> 
        </div>
        <button type="submit" class="mt-6 rounded-lg bg-blue-600 px-4 py-2 text-center text-base font-semibold text-white shadow-md outline-none ring-blue-500 ring-offset-2 transition hover:bg-blue-700 focus:ring-2 md:w-32">Sign up</button>
        <p class="mt-6 text-center font-medium md:text-left">
        Already have an account?
        <a href="./views/auth/signin.php" class="whitespace-nowrap font-semibold text-blue-600">Signin here</a>
      </p>
      </form>
    </div>
  </div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>

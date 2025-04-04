<?php session_start();?>
<header class="bg-white p-4 shadow-md">
  <div class="mx-auto max-w-screen-xxl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="md:flex md:items-center md:gap-12">
        <a class="block text-teal-600" href="#">
          <span class="sr-only">Home</span>
           <h1 class="logo text-blue-500">FarAway</h1>
        </a>
      </div>

      <div class="hidden md:block">
        <?php include 'nav.php'?>
      </div>

      <div class="flex items-center gap-4">
        <?php 
             if (!isset($_SESSION['user_id']) ):
        ?>
          <div class="sm:flex sm:gap-4">
            <a
              class="rounded-md bg-slate-950 px-5 py-2.5 text-sm font-medium text-white shadow-sm"
              href="./views/auth/signin.php"
            >
              Sign In
            </a>

            <div class="hidden sm:flex">
              <a
                class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600"
                href="./views/auth/signup.php"
              >
                Sign Up
              </a>
            </div>
          </div>
        <?php else: ?>
          <div class="hidden sm:flex">
              <a
                class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600"
                href="./logout.php"
              >
                Logout
              </a>
            </div>
        <?php endif; ?>
        <div class="block md:hidden">
          <button
            class="rounded-sm bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="size-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</header>


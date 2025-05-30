<?php 
session_start();?>
<header class="bg-white p-4 shadow-md">
  <div class="mx-auto max-w-screen-xxl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="md:flex md:items-center md:gap-12">
        <a class="block text-teal-600" href="#">
          <span class="sr-only">Home</span>
           <h1 class="logo text-blue-500">Rentify</h1>
        </a>
      </div>

      <div class="flex gap-4">
        <?php 
             if (!isset($_SESSION['user_id']) ):
        ?>
          <div class="flex items-center">
            <a
              class="rounded-md bg-slate-950 px-5 py-2.5 text-sm font-medium text-white shadow-sm"
              href="./views/auth/signin.php"
            >
              Sign In
            </a>

            <div>
              <a
                class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600"
                href="./views/auth/signup.php"
              >
                Sign Up
              </a>
            </div>
          </div>
        <?php else: ?>
          <div class="sm:flex">
                <div class="my-20 pointer toggle-button">
                  <div class="relative flex w-60 items-center overflow-hidden rounded-lg bg-white p-4 ">
                    <div class="shrink-0 h-12 w-12 rounded-full bg-gray-100"></div>
                    <div class="ml-3">
                      <p class="font-medium text-gray-800"><?php echo $_SESSION['username']?></p>
                    </div>
                  </div>
                </div>
                <div class="toggle-parent"></div>
                  <div class="toggle-content hide">
                    <ul>
                        <li class="hover:bg-sky-50">
                            <i class="fa-solid fa-list-check"></i>
                            <span>
                              <a class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600" href="./views/user/manage_booking_user.php">
                                  My Bookings
                              </a>
                            </span>
                        </li>
                        <li class="hover:bg-sky-50">
                            <i class="fa-solid fa-message"></i>                          
                            <span>    
                              <a class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600" href="./views/user/messages.php">
                                Message
                              </a>
                            </span>
                        <?php if(isset($_SESSION['shopname']) && !is_null($_SESSION['shopname'])): ?>
                        <li class="hover:bg-sky-50 ">
                          <i class="fa-brands fa-sellsy"></i>
                          <span>    
                            <a class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600" href="./views/host/dashboard.php">
                              Dashboard
                            </a>
                          </span>
                        </li>
                        <?php else:?>
                        <li class="hover:bg-sky-50 ">
                          <i class="fa-brands fa-sellsy"></i>
                          <span>    
                            <a class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600" href="./views/host/index.php">
                              Start Leasing
                            </a>
                          </span>
                        </li>
                        <?php endif;?>
                        <li class="hover:bg-sky-50 ">
                          <i class="fa-solid fa-right-from-bracket"></i>
                          <span>    
                            <a class="rounded-md  px-5 py-2.5 text-sm font-medium text-slate-600" href="./logout.php">
                              Logout
                            </a>
                          </span>
                        </li>
                    </ul>
                  </div>
                </div>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>


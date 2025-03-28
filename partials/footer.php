<!-- partials/footer.php -->
 <!-- Change this footer and learn the js -->
<footer class="border-t-1 border-t-slate-500">
  <div class="mx-auto grid max-w-screen-xl gap-y-8 gap-x-12 px-4 py-10 sm:px-20 md:grid-cols-2 xl:grid-cols-4 xl:px-10">
    <div class="max-w-sm">
      <div class="mb-6 flex h-10 items-center space-x-2">
        <img class="h-full object-contain" src="/images/logo-circle.png" alt="" />
        <span class="text-lg logo font-medium text-blue-600">FarAway</span>
      </div>
      <div class="text-gray-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis ad a officia ea expedita!</div>
    </div>
    <div class="">
      <div class="mt-4 mb-2 font-medium xl:mb-4">Guides</div>
      <nav aria-label="Guides Navigation" class="text-gray-500">
        <ul class="space-y-3">
          <li><a class="hover:text-blue-600 hover:underline" href="#">How to make a footer</a></li>
          <li><a class="hover:text-blue-600 hover:underline" href="#">Designing your app</a></li>
          <li><a class="hover:text-blue-600 hover:underline" href="#">Getting help from the community</a></li>
          <li><a class="hover:text-blue-600 hover:underline" href="#">Pricing vs Hourly Rate</a></li>
        </ul>
      </nav>
    </div>
    <div class="">
      <div class="mt-4 mb-2 font-medium xl:mb-4">Links</div>
      <nav aria-label="Footer Navigation" class="text-gray-500">
        <ul class="space-y-3">
          <li><a class="hover:text-blue-600 hover:underline" href="#">Home</a></li>
          <li><a class="hover:text-blue-600 hover:underline" href="#">About</a></li>
          <li><a class="hover:text-blue-600 hover:underline" href="#">Guest Favorites</a></li>
          <li><a class="hover:text-blue-600 hover:underline" href="#">Contact</a></li>
        </ul>
      </nav>
    </div>
    <div class="">
      <div class="mt-4 mb-2 font-medium xl:mb-4">Support Us</div>
      <!-- <div class="flex flex-col">
        <div class="mb-4">
          <a href="https://www.producthunt.com/products/Apple?utm_source=badge-follow&utm_medium=badge&utm_souce=badge-Apple" target="_blank"><img src="https://api.producthunt.com/widgets/embed-image/v1/follow.svg?post_id=100070&theme=light" alt="Apple - Think&#0032;Different | Product Hunt" style="width: 250px; height: 54px;" width="250" height="54" /></a>
        </div>
      </div> -->
    </div>
  </div>
  <div class="border-t border-t-slate-400">
    <div class="mx-auto flex max-w-screen-xl flex-col gap-y-4 px-4 py-3 text-center text-gray-500 sm:px-20 lg:flex-row lg:justify-between lg:text-left xl:px-10">
      <p class="">© 2025 FarAway | All Rights Reserved</p>
      <p class="">
        <a class="" href="#">Privacy Policy</a>
        <span>|</span>
        <a class="" href="#">Terms of Service</a>
      </p>
    </div>
  </div>
</footer>

    <script>
  const list = document.getElementById('category-list');
  let isMouseDown = false;
  let startX;
  let scrollLeft;

  list.addEventListener('mousedown', (e) => {
    isMouseDown = true;
    startX = e.pageX - list.offsetLeft;
    scrollLeft = list.scrollLeft;
  });

  list.addEventListener('mouseleave', () => {
    isMouseDown = false;
  });

  list.addEventListener('mouseup', () => {
    isMouseDown = false;
  });

  list.addEventListener('mousemove', (e) => {
    if (!isMouseDown) return;
    e.preventDefault();
    const x = e.pageX - list.offsetLeft;
    const walk = (x - startX) * 3; // scroll-fast speed (higher number = faster)
    list.scrollLeft = scrollLeft - walk;
  });

  // Mobile touch support
  list.addEventListener('touchstart', (e) => {
    isMouseDown = true;
    startX = e.touches[0].pageX - list.offsetLeft;
    scrollLeft = list.scrollLeft;
  });

  list.addEventListener('touchend', () => {
    isMouseDown = false;
  });

  list.addEventListener('touchmove', (e) => {
    if (!isMouseDown) return;
    e.preventDefault();
    const x = e.touches[0].pageX - list.offsetLeft;
    const walk = (x - startX) * 3; // scroll-fast speed (higher number = faster)
    list.scrollLeft = scrollLeft - walk;
  });
</script>

</body>
</html>
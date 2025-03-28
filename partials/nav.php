<nav aria-label="Global">
    <ul class="flex items-center gap-6 text-sm">
        <li>
            <a class="text-slate-900 transition hover:text-slate-900/75 text-base <?php echo ($_SERVER['REQUEST_URI'] == '/FarAway/index.php' ? 'active-link' : ''); ?>" href="/FarAway/index.php"> Home </a>
        </li>
        <li>
            <a class="text-slate-900 transition hover:text-slate-900/75 text-base <?php echo ($_SERVER['REQUEST_URI'] == '/FarAway/about.php' ? 'active' : ''); ?>" href="/FarAway/about.php"> About </a>
        </li>
        <li>
            <a class="text-slate-900 transition hover:text-slate-900/75 text-base <?php echo ($_SERVER['REQUEST_URI'] == '/FarAway/guest-favorites.php' ? 'active' : ''); ?>" href="/FarAway/guest-favorites.php"> Guest Favorites </a>
        </li>
    </ul>
</nav>

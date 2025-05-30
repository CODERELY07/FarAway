<?php 
    include './partials/head.php'; 
    include './partials/header.php'; 

    include './connection.php';
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $stmt = $conn->prepare("SELECT verified_email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        
        if($stmt->rowCount() > 0){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if(is_null($result['verified_email'])){
            
                header("Location: ./views/auth/verify_email.php");
                
                exit;
            }
        }
    }
    $response = ['loggedIn' => false];
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me']) && isset($_COOKIE['user_email'])) {
        $email = $_COOKIE['user_email'];
        $token = $_COOKIE['remember_me'];
        try {
            $stmt = $conn->prepare("SELECT user_id, name FROM users WHERE email = :email AND remember_me = :token");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
    
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['name'];
                $response['loggedIn'] = true;
                $response['username'] = $user['name'];
            }
        } catch (PDOException $e) {
            error_log("Auto login error: " . $e->getMessage());
        }
    }
?>

<main class="mt-12 ">
    <div class="bg-white flex py-3 px-2 rounded-full  p-2 border-gray-200  shadow-sm overflow-hidden max-w-5xl mx-auto">
        <input type="text" id="searchInput" placeholder="Search Place..." class="w-full outline-none bg-white pl-6 text-lg text-gray-700" />
       

        <button type="button" class="bg-blue-600 hover:bg-blue-700 transition-all text-white text-lg rounded-full px-6 py-3 shadow-lg transform hover:scale-105">
        <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
    <div class="inset-shadow-xs p-3 mt-4 flex items-center justify-center">
        
        <?php
            $stmt = $conn->query("SELECT * FROM categories");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <ul id="category-list" class="flex px-2 gap-2 mx-auto pt-5 max-w-4xl overflow-hidden space-x-4 lg:space-x-0 lg:flex-row">
            
            <?php foreach ($categories as $cat): ?>
                <li 
                class="p-2 border border-gray-200 rounded-lg shadow-sm flex-shrink-0 cursor-pointer category-item" 
                data-category-id="<?= $cat['category_id'] ?>"
                >
                    <h5 class="mb-2"><?= htmlspecialchars($cat['category_name']) ?></h5>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

    <div id="defaultProperties">
        <?php include 'includes/properties.php'; ?>
    </div>
        <div id="searchResults" class="mt-8 max-w-screen-xl flex justify-center gap-5 items-center mx-auto hidden">
            <!-- Full property cards will be inserted here -->
        </div>

</main>
<script>
    // Reload to twice to automcatically refresh
      if (!localStorage.getItem('reloadedOnce')) {
        localStorage.setItem('reloadedOnce', 'true');
        location.reload();
        } else {
            localStorage.removeItem('reloadedOnce');
        }
     
        const searchInput = document.getElementById('searchInput');
        const defaultProperties = document.getElementById('defaultProperties');
        const resultsBox = document.getElementById('searchResults');
        const categoryItems = document.querySelectorAll('.category-item');


        searchInput.addEventListener('input', function () {
            const query = this.value.trim();

            if (query.length > 1) {
                fetch(`./util/search.php?query=${encodeURIComponent(query)}`)
                    .then(response => response.text())
                    .then(html => {
                        resultsBox.innerHTML = html;
                        resultsBox.classList.remove('hidden');
                        defaultProperties.classList.add('hidden');
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        resultsBox.innerHTML = '<p class="text-red-500">Something went wrong.</p>';
                        resultsBox.classList.remove('hidden');
                        defaultProperties.classList.add('hidden');
                    });
            } else {
                resultsBox.innerHTML = '';
                resultsBox.classList.add('hidden');
                defaultProperties.classList.remove('hidden');
            }
        });

        categoryItems.forEach(item => {
            item.addEventListener('click', () => {
                const categoryId = item.dataset.categoryId;
                fetch(`./util/category_filter.php?category_id=${categoryId}`)
                    .then(response => response.text())
                    .then(html => {
                        resultsBox.innerHTML = html;
                        resultsBox.classList.remove('hidden');
                        defaultProperties.classList.add('hidden');
                    })
                    .catch(err => {
                        console.error('Category load error:', err);
                        resultsBox.innerHTML = '<p class="text-red-500">Failed to load category properties.</p>';
                        resultsBox.classList.remove('hidden');
                        defaultProperties.classList.add('hidden');
                    });
            });
        });
</script>

<?php include './partials/footer.php'; ?>

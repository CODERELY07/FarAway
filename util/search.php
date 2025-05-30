<?php
include('../connection.php');

if (!isset($_GET['query']) || trim($_GET['query']) === '') {
    echo '';
    exit;
}

$query = '%' . $_GET['query'] . '%';

try {
    $stmt = $conn->prepare("SELECT * FROM properties WHERE name LIKE :query OR city LIKE :query OR province LIKE :query");
    $stmt->bindParam(':query', $query);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($properties) > 0) {
        foreach ($properties as $property) {
            $photo = "https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg";
            if (!empty($property['front_photo'])) {
                $photo = $property['front_photo'];
            }
            ?>
            <a href="./views/user/property_details.php?id=<?= $property['property_id'] ?>" class="block my-20 h-full">
                <article class="flex flex-col max-w-sm h-full overflow-hidden rounded-xl text-gray-700 shadow-md duration-300 ease-in-out hover:shadow-xl cursor-pointer bg-white">
                    <div class="flex-shrink-0">
                        <img 
                            src="<?= $photo ?>" 
                            alt="Property Front photo" 
                            class="w-full h-40 sm:h-108 md:h-44 lg:h-48 xl:h-52 object-cover rounded-t-xl transition"
                            loading="lazy"
                        />
                    </div>
                    <div class="flex flex-col flex-1 p-4 pb-0"> 
                        <div class="pb-2">
                            <h1 class="text-xl sm:text-2xl font-semibold truncate"><?= $property['name'] ?></h1>
                            <span class="block text-base sm:text-lg text-gray-600 hover:text-blue-600 font-medium duration-300 ease-in-out truncate">
                                <?= $property['region'] . ' ' . $property['province'] . ' ' . $property['city'] . ' ' . $property['barangay'] ?>
                            </span>
                        </div>
                        <ul class="flex items-center border-t border-b border-gray-200 py-2">
                            <li class="mr-4 flex items-center">
                                <i class="fa-solid fa-bed mr-2 text-xl sm:text-2xl text-blue-600"></i>
                                <span class="text-xs sm:text-sm"><?= $property['num_bedrooms'] ?> Beds</span>
                            </li>
                            <li class="mr-4 flex items-center">
                                <i class="fa-solid fa-shower mr-2 text-xl sm:text-2xl text-blue-600"></i>
                                <span class="text-xs sm:text-sm"><?= $property['num_bathrooms'] ?> Baths</span>
                            </li>
                        </ul>
                        <ul class="flex justify-between pt-2 pb-3">
                            <li>
                                <span class="text-xs sm:text-sm text-gray-400">Price</span>
                                <p class="text-base font-medium">&#8369; <?= $property['price'] ?></p>
                            </li>
                            <li>
                                <span class="text-xs sm:text-sm text-gray-400">Rating</span>
                                <ul class="flex items-center">
                                    <li class="text-yellow-500">
                                        <!-- Add stars if needed -->
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </article>
            </a>
            <?php
        }
    } else {
        echo '<p class="text-center text-gray-500">No properties found.</p>';
    }

} catch (PDOException $e) {
    echo '<p class="text-red-500">Error: ' . $e->getMessage() . '</p>';
}

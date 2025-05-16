
<?php 

  include('./connection.php');

  try{
    $stmt = $conn->prepare("SELECT * FROM properties");
    $stmt->execute();

    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }catch(PDOException $e){
    echo "Database Error: " . $e;
  }

?>
<section class="bg-white px-2 sm:px-4 py-8 sm:py-10">
  <h1 class="mb-8 text-center text-3xl sm:text-4xl font-bold text-gray-800">House</h1>

  <?php if(!empty($properties)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-6">

      <?php foreach($properties as $property): ?>
        <?php
          $photo = "https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg";
          if(!empty($property['front_photo']) && file_exists($property['front_photo'])){
            $photo = $property['front_photo'];
          }
        ?>
        <a href="./views/user/property_details.php?id=<?php echo $property['property_id']?>" class="block h-full">
          <article class="flex flex-col h-full overflow-hidden rounded-xl text-gray-700 shadow-md duration-300 ease-in-out hover:shadow-xl cursor-pointer bg-white">
            <div class="flex-shrink-0">
              <img 
                src="<?php echo $photo ?>" 
                alt="Property Front photo" 
                class="w-full h-40 sm:h-48 md:h-44 lg:h-48 xl:h-52 object-cover rounded-t-xl transition"
                loading="lazy"
              />
            </div>
            <div class="flex flex-col flex-1 p-4 pb-0"> 
              <div class="pb-2">
                <h1 class="text-xl sm:text-2xl font-semibold truncate">
                  <?php echo $property['name']?>
                </h1>
                <span class="block text-base sm:text-lg text-gray-600 hover:text-blue-600 font-medium duration-300 ease-in-out truncate">
                  <?php 
                    echo $property['region'] . " " . $property['province'] . " " . $property['city'] . " " . $property['barangay'];
                  ?>
                </span>
              </div>
              <ul class="flex items-center border-t border-b border-gray-200 py-2">
                <li class="mr-4 flex items-center">
                  <i class="fa-solid fa-bed mr-2 text-xl sm:text-2xl text-blue-600"></i>
                  <span class="text-xs sm:text-sm"><?php echo $property['num_bedrooms'] ?> Beds</span>
                </li>
                <li class="mr-4 flex items-center">
                  <i class="fa-solid fa-shower mr-2 text-xl sm:text-2xl text-blue-600"></i>
                  <span class="text-xs sm:text-sm"><?php echo $property['num_bathrooms']?> Baths</span>
                </li>
              </ul>
              <ul class="flex justify-between pt-2 pb-3">
                <li>
                  <span class="text-xs sm:text-sm text-gray-400">Price</span>
                  <p class="text-base font-medium">&#8369; <?php echo $property['price']?></p>
                </li>
                <li>
                  <span class="text-xs sm:text-sm text-gray-400">Rating</span>
                  <ul class="flex items-center">
                    <li class="text-yellow-500">
                      <!-- Star SVG here -->
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </article>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else:?>
    <p class="text-center text-gray-500">No properties found.</p>
  <?php endif?>
</section>

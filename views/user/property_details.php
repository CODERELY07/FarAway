<?php 
    include './../../connection.php';
  

    $property_id = $_GET['id'];
    if(!isset($_GET['id']) && empty($_GET['id'])){
        header("Location: ./../../index.php");
    }
    
    $property_id = intval($_GET['id']);
    try{
        
        $stmt = $conn->prepare("
        SELECT 
          properties.*, 
          users.name AS host_name, 
          categories.*
        FROM properties
        JOIN users ON users.user_id = properties.host_id
        JOIN categories USING(category_id)
        WHERE properties.property_id = :property_id
      ");
      
        $stmt->bindParam(':property_id', $property_id);
        $stmt->execute();

        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$property){
            die("Property Not Found");
        }
    }catch(PDOException $e){
        echo "Dabase Error: " . $e;
    }
    include './../../partials/head.php'; 
    include './../../partials/header.php'; 

    $photo = "https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg";
    if(!empty($property['front_photo']) && file_exists("./../../" . $property['front_photo'])){
        $photo = "./" . $property['front_photo'];
    }
   
?>

<main class="mt-12">
        <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <img class="object-cover object-center h-40 max-w-full rounded-lg md:h-60" src="<?php echo $photo ?>" alt="Property Photo" />
                </div>
            </div>
            <div class="w-screen h-screen overflow-hidden">
                <div class="mx-auto max-w-screen-lg px-3 py-10">
                    <div class="flex">
                        <div class="space-y-3">
                            <h5 class="text-sm font-medium uppercase text-gray-400">
                                <?php echo $property['category_name']?>
                            </h5>
                            <h1 class="text-3xl font-semibold" id="name">
                                <?php echo $property['name']?></h1>
                                <textarea id="description" class="w-full rounded mt-2"><?php echo $property['description']?></textarea>
                            <ul class="flex gap-4">
                            <li class="flex items-center">
                                <span class="mr-1.5 rounded bg-gray-900 px-2 text-sm font-semibold text-white"> 4.9 </span>
                                <div class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-blue-500">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-blue-500">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-blue-500">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-blue-500">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-gray-400">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="mx-4">
                                    <i class="fa-solid fa-bed mr-2 text-2xl text-blue-600"></i>
                                    <span class="text-sm" id="num_bedrooms">
                                        <?php echo $property['num_bedrooms'];?>
                                    </span><span>Beds</span>
                                </div>
                                <div class="mx-4">
                                    <i class="fa-solid fa-shower mr-2 text-2xl text-blue-600"></i>
                                    <span class="text-sm" id="num_bathrooms"> <?php echo $property['num_bathrooms'];?> </span><span>Baths</span>
                                </div>
                                    <div class="mx-4">
                                    <i class="fa-solid fa-user mr-2 text-2xl text-blue-600"></i>
                                    <span class="text-sm" id="max_guests">
                                        <?php echo $property['max_guests']?></span><span> Max Guest</span>
                                </div>
                            </li>
                            </ul>
                            <ul class="sm:flex items-center text-sm text-gray-500">
                                <li>Host by <a href="#" class="font-bold"> <?php echo $property['host_name']?> </a></li>
                                <span class="hidden sm:inline mx-3 text-2xl">·</span>
                                <li>Last updated 01/2022</li>
                            </ul>
                            <div class="max-w-2xl mt-5 lg:pr-24">
                                <p class="mb-2 text-blue-600"> Price</p>
                                <h3 class="mb-5 text-3xl font-semibold">
                                    ₱<span id="price"><?php echo number_format($property['price'], 2); ?></span>
                                    </h3>

                                    <p class="mb-16 text-lg text-gray-600">
                                    Address: 
                                    <?php
                                        $addressParts = [];

                                        if (!empty($property['region']))   $addressParts[] = $property['region'];
                                        if (!empty($property['province'])) $addressParts[] = $property['province'];
                                        if (!empty($property['city']))     $addressParts[] = $property['city'];
                                        if (!empty($property['barangay'])) $addressParts[] = $property['barangay'];
                                        if (!empty($property['street']))   $addressParts[] = $property['street'];

                                        echo implode(', ', $addressParts);
                                    ?>

                                    <?php if (!empty($property['zone'])): ?>
                                        Zone <span id="zone"><?php echo htmlspecialchars($property['zone']); ?></span>
                                    <?php endif; ?>
                                    </p>

                            </div>
                            <?php
                       
                                $amenityMap = [
                                'air_conditioning' => [
                                    'icon' => '<i class="fa-solid fa-wind text-xl"></i>',
                                    'title' => 'Air Conditioning',
                                    'description' => 'Cool and comfortable air temperature.',
                                ],
                                'swimming_pool' => [
                                    'icon' => '<i class="fa-solid fa-water-ladder text-xl"></i>',
                                    'title' => 'Swimming Pool',
                                    'description' => 'Access to a private or shared pool.',
                                ],
                                'wifi' => [
                                    'icon' => '<i class="fa-solid fa-wifi text-xl"></i>',
                                    'title' => 'Wi-Fi',
                                    'description' => 'High-speed wireless internet access.',
                                ],
                                'parking' => [
                                    'icon' => '<i class="fa-solid fa-square-parking text-xl"></i>',
                                    'title' => 'Parking',
                                    'description' => 'Free or paid parking available.',
                                ],
                                ];

                            
                                $selectedAmenities = array_map('trim', explode(',', $property['amentities']));

                                foreach ($selectedAmenities as $amenityKey):
                                if (isset($amenityMap[$amenityKey])):
                                    $amenity = $amenityMap[$amenityKey];
                                ?>
                                    <div class="mb-5 flex font-medium amenity delete-amenity" data-amenity="<?php echo htmlspecialchars($amenityKey); ?>">
                                    <div class="mr-4">
                                        <?php echo $amenity['icon']; ?>
                                    </div>
                                    <div>
                                        <p class="mb-2"><?php echo $amenity['title']; ?></p>
                                        <span class="font-normal text-gray-600"><?php echo $amenity['description']; ?></span>
                                    </div>
                                    </div>
                                <?php 
                                endif;
                                endforeach; 
                                ?>
                        </div>
                        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
                            <h2 class="text-2xl font-bold mb-6 text-center">Book a Property</h2>

                            <!-- Booking Form -->
                            <form id="booking-form" class="space-y-4">

                            <div>
                               
                                <input type="hidden" name="user_id"     value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''  ?>"
                                class="w-full border px-4 py-2 rounded">
                            </div>
                            <div>
                               
                                <input type="hidden" name="property_id" value="<?php echo $property_id?>"  class="w-full border px-4 py-2 rounded">
                            </div>
                            <div>
                                <label class="block font-medium">Select Check-in & Check-out:</label>
                                <input type="text" id="booking-dates" placeholder="Select date range" class="w-full border px-4 py-2 rounded bg-white">
                                <input type="hidden" name="check_in_date" id="check_in_date">
                                <input type="hidden" name="check_out_date" id="check_out_date">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 cursor-pointer">Book Now</button>
                            </div>

                            <div id="form-message" class="text-center mt-4 text-lg font-medium"></div>
                            </form>
                        </div>
                    </div>          
                </div>
            </div>
        </div>
</main>
<script>
      $(document).ready(function () {
      // Load disabled date ranges
   
    flatpickr("#booking-dates", {
      mode: "range",
      dateFormat: "Y-m-d",
      onChange: function(selectedDates) {
        if (selectedDates.length === 2) {
          document.getElementById('check_in_date').value = flatpickr.formatDate(selectedDates[0], 'Y-m-d');
          document.getElementById('check_out_date').value = flatpickr.formatDate(selectedDates[1], 'Y-m-d');
        }
      }
    });



      // Handle form submission via AJAX
      $('#booking-form').on('submit', function (e) {
        e.preventDefault(); // prevent form from submitting normally

        $.ajax({
          url: 'controller/booking/create_booking.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function (response) {
            $('#form-message').text(response).removeClass('text-red-600').addClass('text-green-600');
            $('#booking-form')[0].reset();
          },
          error: function () {
            $('#form-message').text('Something went wrong.').removeClass('text-green-600').addClass('text-red-600');
          }
        });
      });
    });
</script>
<?php include './../../partials/footer.php'; ?>

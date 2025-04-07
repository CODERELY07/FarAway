
<?php 
  session_start();
  include './../../partials/head.php'; 
  require_once './../../connection.php';
?>
<main class="min-h-screen">
    <div class="w-screen bg-gray-100 flex">
        <?php include './../../partials/host/dashabord_sidebar.php';?>
        <div class="flex-1 bg-white p-6">
        <form id="addProperties" enctype="multipart/form-data" class="my-4 max-w-screen-xl border border-gray-300 px-4 shadow-xl sm:mx-4 sm:rounded-xl sm:px-4 sm:py-4 md:mx-auto">
            <div class="flex flex-col border-b border-gray-300 py-4 sm:flex-row sm:items-start">
                <div class="shrink-0 mr-auto sm:py-3">
                    <p class="font-medium">Property Details</p>
                    <p class="text-sm text-gray-600">Add Your New Property</p>
                </div>
                <button type="submit" class="hidden rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white sm:inline focus:outline-none focus:ring hover:bg-blue-700">Save</button>
            </div>
            <div class="flex flex-wrap gap-4 border-b border-gray-300 py-4">
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Name</p>
                    <input placeholder="Property Name" name="name" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" />
                </div>
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Category</p>
                    <select name="category_id" class="w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1">
                    <option value="">Select Category</option>
                        <?php 
                            // Fetch categories from the database
                            $stmt = $conn->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            
                            while ($category = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                            
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
           
            <div class="flex flex-col gap-4 border-b border-gray-300 py-4 sm:flex-row">
                <p class="shrink-0 w-32 font-medium">Descripton</p>
                <input placeholder="Property Description" name="description" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" />
            </div>
         
            <div class="flex flex-col gap-4 border-b border-gray-300 py-4 sm:flex-row">
                <p class="shrink-0 w-32 font-medium">Region *</p>
                <select name="region" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" id="region"></select>
                <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
            </div>
            <div class="flex flex-col gap-4 border-b border-gray-300 py-4 sm:flex-row">
                <p class="shrink-0 w-32 font-medium">Province *</p>
                <select name="province" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" id="province"></select>
                <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
            </div>
            <div class="flex flex-col gap-4 border-b border-gray-300 py-4 sm:flex-row">
                <p class="shrink-0 w-32 font-medium">City / Municipality *</p>
                <select name="city" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" id="city"></select>
                <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
            </div>
            <div class="flex flex-col gap-4 border-b border-gray-300 py-4 sm:flex-row">
                <p class="shrink-0 w-32 font-medium">Barangay *</p>
                <select name="barangay" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" name="barangay" id="barangay"></select>
                <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
            </div>
            <div class="flex flex-wrap gap-4 border-b border-gray-300 py-4">
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Street (Optional) </p>
                    <input type="text" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" name="street">
                </div> 
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Zone  (Optional)</p>
                    <input type="text"class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" name="zone">
                </div>
            </div>
          
            <div class="flex flex-wrap gap-4 border-b border-gray-300 py-4">
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Price</p>
                    <input type="text" class="w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" name="price">
                </div>
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Max Guest</p>
                    <input type="number" class="w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" name="max_guest">
                </div>
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Number of bedrooms</p>
                    <input type="number" class="w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" name="num_bed">
                </div>
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Number of bathrooms</p>
                    <input type="number" class="w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" name="num_baths">
                </div>
                
                <div class="flex items-center w-auto">
                    <p class="shrink-0 w-32 font-medium">Amenities</p>
                    <div class="w-full">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="amenities[]" value="wifi" class="form-checkbox"> Wi-Fi
                        </label>
                        <label class="inline-flex items-center ml-4">
                            <input type="checkbox" name="amenities[]" value="air_conditioning" class="form-checkbox"> Air Conditioning
                        </label>
                        <label class="inline-flex items-center ml-4">
                            <input type="checkbox" name="amenities[]" value="swimming_pool" class="form-checkbox"> Swimming Pool
                        </label>
                        <label class="inline-flex items-center ml-4">
                            <input type="checkbox" name="amenities[]" value="parking" class="form-checkbox"> Parking
                        </label>
                        <!-- Add more amenities as needed -->
                    </div>
                </div>


            </div>


            <!-- Upload Photos Section -->
            <div class="flex flex-col gap-4 border-b border-gray-300 py-4 sm:flex-row">
                <p class="shrink-0 w-32 font-medium">Upload Photos</p>
                <input type="file" class="mb-2 w-full rounded-md border border-gray-300 bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" name="photos[]" multiple>
            </div>
            <div class="flex justify-end py-4 sm:hidden">
                <button type="submit" class="rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white focus:outline-none focus:ring hover:bg-blue-700">Save</button>
            </div>
        </form>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="./views/host/ph-address-selector.js"></script>
<script src="./js/main.js?<?php echo time()?>"></script>


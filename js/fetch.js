$(document).ready(function () {
  // Make AJAX call to fetch data from PHP file
  $.ajax({
    url: "./fetch/fetch_properties.php",
    type: "GET",
    success: function (data) {
      const res = JSON.parse(data);
      if (Array.isArray(res) && res.length === 0) {
        $("#properties-container").append(`<h1 class="text-center"> No avaible Properties </h1>`);
      }else{
        $.each(res, function (index, property) {
          var propertyHtml = `
                  <a href="./views/host/property_details.php?id=${property.property_id}">
                  <article class="mb-4 pb-5 overflow-hidden rounded-xl text-gray-700 shadow-md duration-500 ease-in-out hover:shadow-xl">
                      <div>
                          <img src="${property.front_photo}" alt="nooo" class="w-full h-auto" />
                      </div>
                      <div class="p-4 pb-0">
                          <div class="pb-2">
                              <h1 class="text-3xl font-semibold">${
                                property.name}</h1>

                              <small class="text-lg hover:text-blue-600 font-medium duration-500 ease-in-out">
                                  ${property.region} ${property.province} ${property.city} ${property.barangay}
                              </small>
                          </div>
                          <ul class="box-border flex list-none items-center border-t border-b border-solid border-gray-200 px-0 py-2">
                              <li class="mr-4 flex items-center text-left">
                                  <i class="fa-solid fa-bed mr-2 text-2xl text-blue-600"></i>
                                  <span class="text-sm">${property.num_bedrooms}</span>
                              </li>
                              <li class="mr-4 flex items-center text-left">
                                  <i class="fa-solid fa-shower mr-2 text-2xl text-blue-600"></i>
                                  <span class="text-sm">${property.num_bathrooms}</span>
                              </li>
                          </ul>
                          <ul class="m-0 flex list-none items-center justify-between px-0 pt-2 pb-0">
                              <li class="text-left">
                                  <span class="text-sm text-gray-400">Price</span>
                                  <p class="m-0 text-base font-medium">&#8369;${property.price}</p>
                              </li>
                          
                          </ul>
                      </div>
                  </article>
                  </a>
              `;
          $("#properties-container").append(propertyHtml);
        });
      }
    },
    error: function (xhr, status, error) {
      console.log("Error fetching data: " + error);
    },
  });

  //Fetch Property Details
  var propertyId = new URLSearchParams(window.location.search).get("id");

  $.ajax({
    url: "./fetch/fetch_property_details.php",
    type: "GET",
    data: { id: propertyId },
    success: function (data) {
      const property = JSON.parse(data);
      
    if (property.error) {
  
        $("#property-details").text(property.error);
    }
    else {
      const amenitiesArray = property.amentities.split(",");
      const amenitiesData = {
        wifi: {
          icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                        </svg>`,
          title: "Wifi",
          description: "High-speed internet access for your convenience.",
          data_amenity:"wifi"
        },
        air_conditioning: {
          icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>`,
          title: "Air Conditioning",
          description: "Stay cool with a fully functional AC system.",
          data_amenity:"air_conditioning"
        },
        swimming_pool: {
  icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 text-blue-500">
           <path stroke-linecap="round" stroke-linejoin="round" d="M3 18c1.5 0 1.5-1.5 3-1.5s1.5 1.5 3 1.5 1.5-1.5 3-1.5 1.5 1.5 3 1.5 1.5-1.5 3-1.5 1.5 1.5 3 1.5M7.5 12V6.75A2.25 2.25 0 0111.25 4.5v0A2.25 2.25 0 0113.5 6.75V12M10.5 9h3" />
         </svg>`,
          title: "Swimming Pool",
          description: "Enjoy access to a clean and refreshing swimming pool.",
          data_amenity: "swimming_pool"
        },

        parking: {
          icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 text-blue-500">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h3.75a3 3 0 100-6H6v12m3 0h3.75a3 3 0 000-6H9" />
                </svg>`,
          title: "Parking",
          description: "Convenient on-site parking available.",
          data_amenity: "parking"
        },
      };
        let propertyHtml = `
                <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
                    <div class="grid grid-cols-2 gap-2">
            `;

        // Loop through all the photos in the property.photos array
        property.photos.forEach(function (photo) {
          console.log(photo.photo_path);
          propertyHtml += `
                    <div>
                        <img class="object-cover object-center h-40 max-w-full rounded-lg md:h-60" src="${photo.photo_path}" alt="Property Photo" />
                    </div>
                `;
        });
        console.log(property.amentities);
        propertyHtml += ` </div>
                <div class="w-screen h-screen overflow-hidden">
                    <div class="mx-auto max-w-screen-lg px-3 py-10">
                    <div class="space-y-3">
                        <h5 class="text-sm font-medium uppercase text-gray-400">${
                          property.category_name
                        }</h5>
                        <h1 class="text-3xl font-semibold" id="name">${
                          property.property_name
                        }</h1>
                          <textarea id="description" class="w-full rounded mt-2">${property.description}</textarea>
                        
                        <li class="flex">
                            <div class="mx-4">
                              <i class="fa-solid fa-bed mr-2 text-2xl text-blue-600"></i>
                              <span class="text-sm" id="num_bedrooms">${
                                property.num_bedrooms
                              } </span><span>Beds</span>
                            </div>
                            <div class="mx-4">
                              <i class="fa-solid fa-shower mr-2 text-2xl text-blue-600"></i>
                               <span class="text-sm" id="num_bathrooms">${
                                 property.num_bathrooms
                               } </span><span>Baths</span>
                            </div>
                              <div class="mx-4">
                              <i class="fa-solid fa-user mr-2 text-2xl text-blue-600"></i>
                               <span class="text-sm" id="max_guests">${
                                 property.max_guests
                               } </span><span>Max Guest</span>
                            </div>
                        </li>
                        </ul>
                        <ul class="sm:flex items-center text-sm text-gray-500">
                            <li>Host by <a href="#" class="font-bold"> ${
                              property.host_name
                            } </a></li>
                            <span class="hidden sm:inline mx-3 text-2xl">·</span>
                            <li>Last updated 01/2022</li>
                        </ul>
                        <div class="max-w-2xl mt-5 lg:pr-24">
                            <p class="mb-2 text-blue-600"> Price</p>
                            <h3 class="mb-5 text-3xl font-semibold">₱<span id="price">${property.price}</span>
                            </h3>
                           <p class="mb-16 text-lg text-gray-600">
                                Address: 
                                <span id="region">${
                                    property.region ? property.region + "," : ""}
                                </span>
                                <span id="province"> 
                                 ${ property.province ? property.province + "," : "" } 
                                </span>
                                <span id="province"> 
                                 ${ property.province ? property.province + "," : "" } 
                                </span>
                                <span id="city">
                                  ${property.city ? property.city + "," : ""} 
                                </span>
                                 <span id="city">
                                  ${property.city ? property.city + "," : ""} 
                                </span>
                                <span id="barangay"> 
                                 ${ property.barangay ? property.barangay + "," : ""} 
                                </span>
                                <span id="street">
                                  ${ property.street ? property.street + "," : ""}
                                </span>             
                                Zone
                                <span id="zone">
                                  ${property.zone ? property.zone : ""}
                                </span>
                            </p>
                        </div>
                    </div>
            `;
        amenitiesArray.forEach((amenity) => {
          const amenityDataObject = amenitiesData[amenity];
          if (amenityDataObject) {
            // Create the HTML structure for each amenity
            propertyHtml += `
                        <div class="mb-5 flex font-medium amenity delete-amenity" data-amenity=${amenityDataObject.data_amenity} >
                            <div class="mr-4">
                                ${amenityDataObject.icon} <!-- Add the icon -->
                            </div>
                            <div class="">
                                <p class="mb-2">${amenityDataObject.title}</p> 
                                <span class="font-normal text-gray-600">${amenityDataObject.description}</span>
                            </div>
                           <div class="bg-red-600 mx-3 flex justify-center items-center p-4 cursor-pointer hover:bg-red-800 transition-colors">
                            <i class="fa-solid fa-trash text-white text-2xl"></i>
                           </div>

                        </div>
                    `;
          }
        });

        propertyHtml += `
                        <div class="bg-red-600 mx-3 flex justify-center items-center p-4 cursor-pointer hover:bg-red-800 transition-colors text-white" id="delete_property">
                          Delete this Property
                        </div>
                    </div>
                </div>
             `;
        
        $("#property-details").html(propertyHtml); 

        // Update property Data
        $("#name, #num_bedrooms, #num_bathrooms, #max_guests,#price,#region,#province,#city,#barangay,#street,#zone").on("click", function () {
          var currentText = $(this).text();
          if($(this).attr('id') == 'name'){
            $(this).html(`<input type="text" style="width:200px " value="${currentText}" />`);
          }else if($.inArray($(this).attr('id'), ['price', 'region', 'province', 'city', 'barangay,street,zone']) !== -1) {
            $(this).html(`<input type="text" style="width:150px " value="${currentText}" />`);
          }else{
            $(this).html(`<input type="text" style="width:40px" value="${currentText}" />`);
          }
          $(this).find("input").focus();
        });
  
        $("#name,#description, #num_bedrooms, #num_bathrooms, #max_guests, #price,#region,#province,#city,#barangay,#street,#zone").on("input", function () {
          var updatedValue = $(this).find('input').val();
          // if($(this).attr('id') == 'description'){
          //   updatedValue = $(this).val();
          // }
          var column = $(this).attr("id"); 
          console.log(updatedValue)
          $.ajax({
            url: "./controller/host/update_property.php",
            type: "POST",
            data: {
              id: propertyId,
              column: column,
              value: updatedValue
            },
            success: function (response) {
              const res = JSON.parse(response);

              console.log(res);
            },
            error: function () {
              console.log("Error updating property");
            }
          });
        });

        // delete amnetity
        $(document).on('click', '.delete-amenity', function() {
          var amenity = $(this).data('amenity');
  
          console.log(amenity + propertyId)
          // Confirm before deleting
          if (confirm("Are you sure you want to delete the " + amenity + " amenity?")) {

            $.ajax({
              url: './controller/host/delete_amenity.php',  
              type: 'POST',
              data: {
                property_id: propertyId,
                amenity: amenity
              },
              success: function(response) {
                const res = JSON.parse(response);
                console.log(res.message);
                if (res.success) {
                  $('.amenity[data-amenity="' + amenity + '"]').remove();
                  alert('Amenity deleted successfully');
                } else {
                  alert('Failed to delete the amenity.' + res.message);
                }
              },
              error: function(xhr, status, error) {
                console.log('Error deleting amenity: ' + error);
                alert('An error occurred while deleting the amenity.');
              }
            });
          }
        });

        // Delete Property
        $(document).on('click', '#delete_property',function(){
          if (confirm("Are you sure you want to delete the this Property?")) {
            $.ajax({
              url: './controller/host/delete_property.php',  
              type: 'POST',
              data: {
                property_id: propertyId,
              },
              success: function(response) {
                const res = JSON.parse(response);
                console.log(res.message);
                if (res.success) {
                  alert('Property deleted successfully');
                  window.location.href = res.redirect;
                } else {
                  alert('Failed to delete the property.' + res.message);
                }
              },
              error: function(xhr, status, error) {
                console.log('Error deleting property: ' + error);
                alert('An error occurred while deleting the property.');
              }
            });
          }
        });
      }
    },
    error: function (xhr, status, error) {
      console.log("Error fetching property details: " + error);
      $("#property-details").html("<p>Error fetching property details.</p>");
    }
  });
});

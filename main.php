<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main - Second-Hand Car Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
    /* CSS for the modal */
    #updateModal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    #updateModalContent {
        background-color: #fefefe;
        margin-top: 100px;
        margin-left: 170px;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    #updateModalContent input[type=text] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
    }

    #updateModalContent input[type=submit] {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    #updateModalContent input[type=submit]:hover {
        background-color: #45a049;
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    </style>
</head>
<body>
    <h2>Add a New Car</h2>
    <form id="addCarForm" action="add_car.php" method="post">
        <label for="model">Model:</label><br>
        <input type="text" id="model" name="model"><br>
        
        <label for="engine_power">Engine Power:</label><br>
        <input type="text" id="engine_power" name="engine_power"><br>
        
        <label for="fuel">Fuel:</label><br>
        <input type="text" id="fuel" name="fuel"><br>
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price"><br>
        
        <label for="color">Color:</label><br>
        <input type="text" id="color" name="color"><br>
        
        <label for="age">Age:</label><br>
        <input type="text" id="age" name="age"><br>
        
        <label for="history">History:</label><br>
        <input type="text" id="history" name="history"><br>
        
        <input type="submit" value="Submit">
    </form>

    <h2>Filter Cars By:</h2>
    <form id="filterForm1"> 
        <input type="radio" id="filterNone" name="filterType" value="none" checked>
        <label for="filterNone">None</label>
        <input type="radio" id="filterModel" name="filterType" value="model">
        <label for="filterModel">Model</label>
        <input type="radio" id="filterPrice" name="filterType" value="price">
        <label for="filterPrice">Price</label>
        
    </form>
    <form id="filterForm2">
        <input type="radio" id="filterAscending" name="filterOrder" value="asc" checked>
        <label for="filterAscending">Ascending</label>
        <input type="radio" id="filterDescending" name="filterOrder" value="desc">
        <label for="filterDescending">Descending</label>
    </form>

    <h2>Car Inventory</h2>
    <table id="carInventory" border="1">
        <thead>
            <tr>
                <th>Model</th>
                <th>Engine Power</th>
                <th>Fuel</th>
                <th>Price</th>
                <th>Color</th>
                <th>Age</th>
                <th>History</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated dynamically -->
        </tbody>
    </table>

    <!-- Update Modal -->
    <div id="updateModal">
        <div id="updateModalContent">
            <span class="close">&times;</span>
            <h2>Update Car Information</h2>
            <form id="updateForm" action="update_car.php" method="post">
                <input type="hidden" id="carId" name="carId">
                <label for="model">Model:</label><br>
                <input type="text" id="updateModel" name="model"><br>
                <label for="engine_power">Engine Power:</label><br>
                <input type="text" id="updateEnginePower" name="engine_power"><br>
                <label for="fuel">Fuel:</label><br>
                <input type="text" id="updateFuel" name="fuel"><br>
                <label for="price">Price:</label><br>
                <input type="text" id="updatePrice" name="price"><br>
                <label for="color">Color:</label><br>
                <input type="text" id="updateColor" name="color"><br>
                <label for="age">Age:</label><br>
                <input type="text" id="updateAge" name="age"><br>
                <label for="history">History:</label><br>
                <input type="text" id="updateHistory" name="history"><br>
                <input type="submit" value="Save">
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Function to fetch car data using AJAX with optional filter
    function fetchCarData(filterType, order) {
        // Check if filter type is "None"
        if (filterType === "none") {
            // Set filterType to empty string to indicate no filter
            filterType = "";
            // Set order to "ASC" and deselect ascending or descending filters
            order = "asc";
            $('input[name="filterOrder"]').prop('checked', false); // Deselect order filters
        }

        $.ajax({
            url: 'get_cars.php', // PHP file to fetch car data
            type: 'GET',
            dataType: 'json',
            data: { filter: filterType, order: order }, // Include filter type and order in request
            success: function(data) {
                // Clear existing table data
                $('#carInventory tbody').empty();
                // Populate table with fetched data
                $.each(data, function(index, car) {
                    // Create a row for each car
                    var row = $('<tr>');
                    row.append('<td>' + car.model + '</td>');
                    row.append('<td>' + car.engine_power + '</td>');
                    row.append('<td>' + car.fuel + '</td>');
                    row.append('<td>' + car.price + '</td>');
                    row.append('<td>' + car.color + '</td>');
                    row.append('<td>' + car.age + '</td>');
                    row.append('<td>' + car.history + '</td>');

                    // Create buttons for updating and deleting the entry
                    var updateBtn = $('<button>').text('Change');
                    var deleteBtn = $('<button>').text('Delete');

                    // Add click event handlers for update and delete buttons
                    updateBtn.click(function() {
                        // Fill the update form with car data
                        $('#carId').val(car.id);
                        $('#updateModel').val(car.model);
                        $('#updateEnginePower').val(car.engine_power);
                        $('#updateFuel').val(car.fuel);
                        $('#updatePrice').val(car.price);
                        $('#updateColor').val(car.color);
                        $('#updateAge').val(car.age);
                        $('#updateHistory').val(car.history);
                        // Show the update modal
                        $('#updateModal').show();
                    });
                    deleteBtn.click(function() {
                        // Handle button click event (for deleting entry)
                        deleteCar(car.id); // Call function to delete the car
                    });

                    // Append buttons to row
                    row.append($('<td>').append(updateBtn));
                    row.append($('<td>').append(deleteBtn));

                    // Append the row to the table
                    $('#carInventory tbody').append(row);
                });
            },
            error: function() {
                $('#carInventory tbody').html('<tr><td colspan="8">Error loading data.</td></tr>');
            }
        });
    }

    // Set default filter to "None" and order to "ASC" when the page loads
    var selectedFilter = "none";
    var selectedOrder = "asc";

    // Fetch car data with default filter and order
    fetchCarData(selectedFilter, selectedOrder);

    // Event listener for radio button changes (filter)
    $('input[name="filterType"]').change(function() {
        // Get the selected filter type
        selectedFilter = $(this).val();
        // If "None" is selected, cancel all other filters
        if (selectedFilter === "none") {
            $('input[name="filterType"]').prop('checked', false); // Uncheck all other filters
            $('input[name="filterOrder"]').prop('checked', false); // Deselect order filters
        }
        // Get the selected order type
        selectedOrder = $('input[name="filterOrder"]:checked').val();
        // Fetch car data with the selected filter type and order
        fetchCarData(selectedFilter, selectedOrder);
    });

    // Event listener for radio button changes (order)
    $('input[name="filterOrder"]').change(function() {
        // Get the selected filter type
        selectedFilter = $('input[name="filterType"]:checked').val();
        // Get the selected order type
        selectedOrder = $(this).val();
        // Fetch car data with the selected filter type and order
        fetchCarData(selectedFilter, selectedOrder);
    });


            // Event listener for filter form submission
            $('#filterForm1, #filterForm2').change(function() {
                // Get the selected filter type and order
                var filterType = $('input[name="filterType"]:checked').val();
                var filterOrder = $('input[name="filterOrder"]:checked').val();

                // Fetch car data with the selected filter type and order
                fetchCarData(filterType, filterOrder);
            });

            // Call fetchCarData function when the page loads, without filter initially
            fetchCarData();

            // Event listener for radio button changes
            $('#filterForm1 input[type="radio"]').change(function() {
                // Get the selected filter type
                selectedFilter = $(this).val();
                // Fetch car data with the selected filter type
                fetchCarData(selectedFilter);
            });

            // Function to handle form submission using AJAX
            $('#addCarForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = $(this).serialize();

                // Submit form data using AJAX
                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    type: $(this).attr('method'), // Form submission method
                    data: formData, // Form data
                    success: function(response) {
                        // Refresh car inventory table after successful form submission
                        fetchCarData();
                        alert(response); // Show success message

                        // Clear form fields after successful submission
                        $('#addCarForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error); // Show error message
                    }
                });
            });

            // Function to handle closing of the update modal
            $('.close').click(function() {
                $('#updateModal').hide();
            });

            // Function to handle update form submission using AJAX
            $('#updateForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = $(this).serialize();

                // Submit form data using AJAX
                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    type: $(this).attr('method'), // Form submission method
                    data: formData, // Form data
                    success: function(response) {
                        // Hide the update modal
                        $('#updateModal').hide();
                        // Refresh car inventory table after successful update
                        fetchCarData();
                        alert(response); // Show success message
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error); // Show error message
                    }
                });
            });

            // Function to delete car from the database and update table
            function deleteCar(carId) {
                if(confirm("Are you sure you want to delete this car?")) {
                    // Make AJAX request to delete_car.php
                    $.ajax({
                        url: 'delete_car.php',
                        type: 'POST',
                        data: { car_id: carId }, // Send car ID to delete_car.php
                        success: function(response) {
                            // Refresh car inventory table after successful deletion
                            fetchCarData();
                            alert(response); // Show success message
                        },
                        error: function(xhr, status, error) {
                            alert("Error: " + error); // Show error message
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>

<?php
// Include the database connection file
include_once 'dbh.inc.php';

// Set default filter type and order to empty strings
$filterType = '';
$order = '';

// Check if filter type is provided in the request
if (isset($_GET['filter'])) {
    // Sanitize and store the filter type
    $filterType = $_GET['filter'];

    // Define allowed filter types to prevent SQL injection
    $allowedFilters = array('model', 'engine_power', 'fuel', 'price', 'color', 'age', 'history');
    if (!in_array($filterType, $allowedFilters) && $filterType !== 'none') {
        // If an invalid filter type is provided, return an error message
        echo json_encode(array('error' => 'Invalid filter type'));
        exit(); // Terminate the script
    }
}

// Check if order is provided in the request
if (isset($_GET['order'])) {
    // Sanitize and store the order
    $order = $_GET['order'];

    // Validate the order value to prevent SQL injection
    if ($order !== 'asc' && $order !== 'desc') {
        // If an invalid order value is provided, return an error message
        echo json_encode(array('error' => 'Invalid order'));
        exit(); // Terminate the script
    }
}

// Fetch car records from the database based on filter type and order
try {
    if ($filterType === 'none') {
        // If filter type is "None", sort by id in ascending order
        $stmt = $pdo->prepare("SELECT * FROM cars ORDER BY id ASC");
    } elseif (!empty($filterType) && !empty($order)) {
        // If filter type and order are provided, construct SQL query accordingly
        $stmt = $pdo->prepare("SELECT * FROM cars ORDER BY $filterType $order");
    } else {
        // If no filter type or order is provided, fetch all car records
        $stmt = $pdo->query("SELECT * FROM cars");
    }
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the results as an associative array
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output car data as JSON
    echo json_encode($cars);
} catch (PDOException $e) {
    // Output error message as JSON
    echo json_encode(array('error' => 'Database error'));
}
?>

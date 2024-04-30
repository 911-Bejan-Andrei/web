<?php
// Include the database connection file
include_once 'dbh.inc.php';

// Check if search term is provided
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Prepare SQL statement to search for cars by model or price
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE model LIKE ? OR price = ?");
    // Execute the statement with the provided search term
    $stmt->execute(["%$search%", $search]);
    // Fetch all matching cars
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($cars);
} else {
    // If search term is not provided, return empty response
    echo json_encode([]);
}
?>
    
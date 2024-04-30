<?php
// Include the database connection file
include_once 'dbh.inc.php';

// Check if car ID is provided via POST request
if(isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];

    try {
        // Prepare SQL statement to delete car from the database
        $stmt = $pdo->prepare("DELETE FROM cars WHERE id = ?");
        // Execute the statement with the provided car ID
        $stmt->execute([$car_id]);

        // Output success message
        echo "Car deleted successfully!";
    } catch (PDOException $e) {
        // Output error message in case of failure
        echo "Error: " . $e->getMessage();
    }
} else {
    // Output error message if car ID is not provided
    echo "Car ID is missing!";
}
?>

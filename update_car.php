<?php
// Include the database connection file
include_once 'dbh.inc.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (!empty($_POST['model']) && !empty($_POST['engine_power']) && !empty($_POST['fuel']) && !empty($_POST['price']) && !empty($_POST['color']) && !empty($_POST['age']) && !empty($_POST['history']) && !empty($_POST['carId'])) {
        // Retrieve form data
        $car_id = $_POST['carId'];
        $model = $_POST['model'];
        $engine_power = $_POST['engine_power'];
        $fuel = $_POST['fuel'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        $age = $_POST['age'];
        $history = $_POST['history'];

        try {
            // Prepare SQL statement to update data in the database
            $stmt = $pdo->prepare("UPDATE cars SET model=?, engine_power=?, fuel=?, price=?, color=?, age=?, history=? WHERE id=?");
            // Execute the statement with the provided data
            $stmt->execute([$model, $engine_power, $fuel, $price, $color, $age, $history, $car_id]);

            // Provide feedback to the user
            echo "Car updated successfully!";
        } catch (PDOException $e) {
            // Provide feedback in case of an error
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Provide feedback if required fields are not filled
        echo "All fields are required!";
    }
}
?>

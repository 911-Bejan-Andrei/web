<?php
// Include the database connection file
include_once 'dbh.inc.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (!empty($_POST['model']) && !empty($_POST['engine_power']) && !empty($_POST['fuel']) && !empty($_POST['price']) && !empty($_POST['color']) && !empty($_POST['age']) && !empty($_POST['history'])) {
        // Retrieve form data
        $model = $_POST['model'];
        $engine_power = $_POST['engine_power'];
        $fuel = $_POST['fuel'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        $age = $_POST['age'];
        $history = $_POST['history'];

        try {
            // Prepare SQL statement to insert data into the database
            $stmt = $pdo->prepare("INSERT INTO cars (model, engine_power, fuel, price, color, age, history) VALUES (?, ?, ?, ?, ?, ?, ?)");
            // Execute the statement with the provided data
            $stmt->execute([$model, $engine_power, $fuel, $price, $color, $age, $history]);

            // Provide feedback to the user
            echo "New car added successfully!";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second-Hand Car Management</title>
</head>
<body>
    <h2>Add a New Car</h2>
    <form action="add_car.php" method="post">
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
</body>
</html>

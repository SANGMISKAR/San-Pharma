<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your database
    $conn = new mysqli('localhost', 'root', '', 'your_database_name');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_brand = $_POST['product_brand'];
    $product_availability = $_POST['product_availability'];
    $old_price = $_POST['old_price'];
    $new_price = $_POST['new_price'];
    $product_description = $_POST['product_description'];
    $product_ingredients = $_POST['product_ingredients'];
    $product_directions = $_POST['product_directions'];
    $product_warnings = $_POST['product_warnings'];
    $product_manufacturer = $_POST['product_manufacturer'];
    $expiry_date = $_POST['expiry_date'];
    $package_quantity = $_POST['package_quantity'];

    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        $product_image = $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }

    // Insert product data into the database
    $sql = "INSERT INTO products (id, name, brand, availability, old_price, new_price, description, ingredients, directions, warnings, manufacturer, expiry_date, package_quantity, image_url)
            VALUES ('$product_id', '$product_name', '$product_brand', '$product_availability', '$old_price', '$new_price', '$product_description', '$product_ingredients', '$product_directions', '$product_warnings', '$product_manufacturer', '$expiry_date', '$package_quantity', '$product_image')";

    if ($conn->query($sql) === TRUE) {
        echo "Product saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

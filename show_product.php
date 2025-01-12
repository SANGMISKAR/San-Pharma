<?php
// Connect to the database
$host = 'localhost';
$db = 'your_database_name';
$user = 'your_username';
$pass = 'your_password';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products
$sql = "SELECT code, name, image_url, new_price, package_quantity FROM products";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    // Fetch each product
    while($row = $result->fetch_assoc()) {
        $products[] = [
            'code' => $row['code'],
            'name' => $row['name'],
            'image_url' => $row['image_url'],
            'new_price' => $row['new_price'],
            'package_quantity' => $row['package_quantity']
        ];
    }
}

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
?>

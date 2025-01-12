<?php
// for the admin panel data admin 
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_pharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['brand'] . "</td>";
        echo "<td>" . $row['availability'] . "</td>";
        echo "<td>" . $row['old_price'] . "</td>";
        echo "<td>" . $row['new_price'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td><img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' width='100'></td>";
        echo "<td><a href='delete_product.php?id=" . $row['id'] . "' class='delete-link' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No products found</td></tr>";
}

$conn->close();
?>

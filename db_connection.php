<?php
// db_connection.php

$servername = "localhost"; // Typically 'localhost' for local development
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password (leave empty for XAMPP default)
$dbname = "online_pharmacy"; // Replace with your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Uncomment the following line to verify the connection during development
// echo "Connected successfully";
?>

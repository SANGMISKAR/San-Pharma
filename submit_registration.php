<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "pharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$password = $_POST['password']; 
$pincode = $_POST['pincode'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (name, email, contact, password, pincode) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $contact, $hashed_password, $pincode);

// Execute and redirect
if ($stmt->execute()) {
    // Redirect to the login page
    header("Location: login_page.html");
    exit(); // Ensure no further code is executed after the redirection
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>

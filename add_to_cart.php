
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Your existing code
?>

<?php
session_start();

// Connect to the MySQL database
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password
$dbname = "online_pharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

// Get the logged-in user's id
$user_id = $_SESSION['user_id'];

// Get product details from POST request
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_image = $_POST['product_image'];
$product_description = $_POST['product_description'];

// Check if the product is already in the cart
$sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Product already in cart, update the quantity
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
} else {
    // Product not in cart, insert a new record
    $sql = "INSERT INTO cart (user_id, product_id, quantity, product_name, product_image, product_description) VALUES (?, ?, 1, ?, ?, ?)";
}

$stmt = $conn->prepare($sql);
if ($result->num_rows > 0) {
    $stmt->bind_param("ii", $user_id, $product_id);
} else {
    $stmt->bind_param("iisss", $user_id, $product_id, $product_name, $product_image, $product_description);
}
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Product added to cart successfully.";
} else {
    echo "Failed to add product to cart.";
}

$stmt->close();
$conn->close();
?>

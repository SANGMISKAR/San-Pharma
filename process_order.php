<?php
session_start();

// Check if the cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='index.php'>Continue shopping</a>";
    exit();
}

// Check if user is logged in (you can redirect to the login page if not)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL; // Allow NULL for guest users

// Get form data from the customer
$name = $_POST['full_name'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$postal_code = $_POST['postal_code'];
$phone = $_POST['phone'];
$payment_method = $_POST['payment_method'];

// Calculate the total and discount again (for security)
$total = 0;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_pharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($_SESSION['cart'] as $product_id => $product) {
    $quantity = $product['quantity'];

    $sql = "SELECT new_price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product_data = $result->fetch_assoc();
    $stmt->close();

    $price = $product_data['new_price'];
    $subTotal = $price * $quantity;
    $total += $subTotal;
}

$discount = 0.15 * $total;
$final_total = $total - $discount;

// Insert order details into the orders table
$sql = "INSERT INTO orders (user_id, name, address, phone, email, payment_method, total_amount, discount, final_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$full_address = $address . ', ' . $city . ', ' . $state . ', ' . $postal_code;
$stmt->bind_param("isssssddd", $user_id, $name, $full_address, $phone, $email, $payment_method, $total, $discount, $final_total);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Insert each cart item into the order_items table
foreach ($_SESSION['cart'] as $product_id => $product) {
    $quantity = $product['quantity'];

    // Fetch product details again (if necessary)
    $sql = "SELECT name, new_price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product_data = $result->fetch_assoc();
    $stmt->close();

    $product_name = $product_data['name'];
    $price = $product_data['new_price'];
    $subtotal = $price * $quantity;

    // Insert into order_items table
    $sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisidd", $order_id, $product_id, $product_name, $quantity, $price, $subtotal);
    $stmt->execute();
    $stmt->close();
}

// Clear the cart after successful order
unset($_SESSION['cart']);

$conn->close();

// Redirect to a confirmation page
header("Location: order_confirmation.php?order_id=" . $order_id);
exit();
?>

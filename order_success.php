<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_pharmacy";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user id from session
$user_id = $_SESSION['user_id'];

// Fetch order details from the database
// Assuming you have an orders table and order_id is stored in the session or passed as a query parameter
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Assuming 'order_id' is the correct column name in the 'orders' table
// SQL query with updated column name
$sql = "SELECT o.order_id, o.order_date, o.total_amount, p.name, p.image_url, oi.quantity, p.price_value AS price
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.order_id = ? AND o.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order_items = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <!-- Include your header here -->
    </header>

    <main>
        <h1>Order Confirmation</h1>
        <p>Thank you for your order! Your order number is <strong><?php echo htmlspecialchars($order_id); ?></strong>.</p>
        <p>Order Date: <?php echo htmlspecialchars(date('F j, Y', strtotime($order_items[0]['order_date']))); ?></p>

        <h2>Order Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="50">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₹<?php echo htmlspecialchars($item['quantity'] * $item['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Total Amount: ₹<?php echo htmlspecialchars($order_items[0]['total_amount']); ?></p>

        <a href="index.php">Continue Shopping</a>
    </main>

    <footer>
        <!-- Include your footer here -->
    </footer>
</body>
</html>

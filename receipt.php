<?php
session_start();

// Assuming order_id is stored in session after successful checkout
if (!isset($_SESSION['order_id'])) {
    header('Location: checkout.php');
    exit();
}

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

// Get order details
$order_id = $_SESSION['order_id'];
unset($_SESSION['order_id']); // Clear order_id from session

$sql = "SELECT o.order_date, p.name, oi.quantity, oi.price
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Calculate totals
$total = 0;
$discount = 0.15; // 15% discount
while ($row = $result->fetch_assoc()) {
    $subTotal = $row['quantity'] * $row['price'];
    $total += $subTotal;
}
$final_total = $total - ($total * $discount);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link rel="stylesheet" href="cart_style.css">
    <style>
        /* Receipt Page Styling */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .receipt-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .receipt-container h1 {
            margin-bottom: 20px;
        }
        .receipt-container p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h1>Order Receipt</h1>
        <p><strong>Order Date:</strong> <?php echo date('d M Y'); ?></p>
        <h2>Order Details:</h2>
        <?php
        // Display order details
        $result->data_seek(0); // Reset result pointer
        while ($row = $result->fetch_assoc()) {
            $subTotal = $row['quantity'] * $row['price'];
            echo '<p>' . htmlspecialchars($row['name']) . ': ₹' . htmlspecialchars($row['price']) . ' x ' . htmlspecialchars($row['quantity']) . ' = ₹' . htmlspecialchars($subTotal) . '</p>';
        }
        ?>
        <p><strong>Subtotal:</strong> ₹<?php echo htmlspecialchars($total); ?></p>
        <p><strong>Discount (15%):</strong> -₹<?php echo htmlspecialchars($total * $discount); ?></p>
        <p><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($final_total); ?></p>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>

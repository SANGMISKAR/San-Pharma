<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_pharmacy";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart items for the user
$user_id = $_SESSION['user_id'];
$sql = "SELECT c.quantity, p.id AS product_id, p.name, p.new_price AS price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Calculate totals
$total = 0;
$discount = 0;
$final_total = 0;

foreach ($cart_items as $item) {
    $subTotal = $item['price'] * $item['quantity'];
    $total += $subTotal;
}

// Calculate discount and final total
$discount = 0.15 * $total;
$final_total = $total - $discount;

// Place order if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $payment_method = $_POST['payment_method'];

    $order_sql = "INSERT INTO orders (user_id, name, address, phone, email, payment_method, total_amount, discount, final_total) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("isssssdss", $user_id, $name, $address, $phone, $email, $payment_method, $total, $discount, $final_total);
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert items into the 'order_items' table
        $item_sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price, subtotal) 
                     VALUES (?, ?, ?, ?, ?, ?)";
        $item_stmt = $conn->prepare($item_sql);

        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['name'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $subtotal = $price * $quantity;

            $item_stmt->bind_param("iissds", $order_id, $product_id, $product_name, $quantity, $price, $subtotal);
            $item_stmt->execute();
        }

        // Clear the user's cart after placing the order
        $clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($clear_cart_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Redirect to a success page
        header("Location: order_success.php?order_id=" . $order_id);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout_style.css">
    <style>
        /* Checkout page styling */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .checkout-container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
        }
        .customer-details, .order-summary {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 48%;
        }
        .customer-details h2, .order-summary h2 {
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .order-summary p {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }
        .order-summary p strong {
            font-size: 18px;
        }
        .checkout-button {
            width: 100%;
            padding: 15px;
            background-color: #084B83;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        .checkout-button:hover {
            background-color: #066ba1;
        }
        .payment-details {
            display: none;
        }
        .credit-card-details, .paypal-details {
            display: none;
        }
    </style>
    <script>
        // Function to show or hide payment method details
        function showPaymentDetails() {
            var paymentMethod = document.getElementById('payment_method').value;
            var creditCardDetails = document.querySelector('.credit-card-details');
            var paypalDetails = document.querySelector('.paypal-details');
            
            creditCardDetails.style.display = 'none';
            paypalDetails.style.display = 'none';
            
            if (paymentMethod === 'credit_card' || paymentMethod === 'debit_card') {
                creditCardDetails.style.display = 'block';
            } else if (paymentMethod === 'paypal') {
                paypalDetails.style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <div class="checkout-container">
        <!-- Customer Details Section -->
        <div class="customer-details">
            <h2>Customer Details</h2>
            <form action="place_order.php" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="address">Shipping Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <!-- Payment Section -->
                <h2>Payment Method</h2>
                <div class="form-group">
                    <label for="payment_method">Select Payment Method</label>
                    <select id="payment_method" name="payment_method" onchange="showPaymentDetails()" required>
                        <option value="">Select Payment Method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                </div>

                <!-- Credit/Debit Card Details -->
                <div class="credit-card-details payment-details">
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX">
                    </div>
                    <div class="form-group">
                        <label for="card_name">Card Holder Name</label>
                        <input type="text" id="card_name" name="card_name" placeholder="Full Name on Card">
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date</label>
                        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="3-digit code">
                    </div>
                </div>

                <!-- PayPal Details -->
                <div class="paypal-details payment-details">
                    <p>Please log in to your PayPal account to complete the payment.</p>
                </div>

                <button type="submit" class="checkout-button">Place Order</button>
            </form>
        </div>

        <!-- Order Summary Section -->
        <div class="order-summary">
            <h2>Order Summary</h2>
            <?php if (!empty($cart_items)) { ?>
                <ul>
                    <?php foreach ($cart_items as $item) { ?>
                        <li>
                            <?php echo htmlspecialchars($item['name']); ?> x <?php echo htmlspecialchars($item['quantity']); ?> 
                            - $<?php echo number_format($item['price'], 2); ?>
                        </li>
                    <?php } ?>
                </ul>
                <p><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>
                <p><strong>Discount (15%):</strong> -$<?php echo number_format($discount, 2); ?></p>
                <p><strong>Final Total:</strong> $<?php echo number_format($final_total, 2); ?></p>
            <?php } else { ?>
                <p>No items in cart.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>

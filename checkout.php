<?php
session_start();
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='index.php'>Continue shopping</a></p>";
    exit();
}

// Calculate order totals
$total = 0;
foreach ($_SESSION['cart'] as $product_id => $product) {
    // Retrieve product details from the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online_pharmacy";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT new_price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product_data = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    $price = $product_data['new_price'];
    $quantity = $product['quantity'];
    $subTotal = $price * $quantity;
    $total += $subTotal;
}

$discount = 0.15 * $total;
$final_total = $total - $discount;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .checkout-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .form-section {
            flex: 2;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-section h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-section label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .form-section input[type="text"], .form-section input[type="email"], .form-section input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-section select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .checkout-summary {
            flex: 1;
            margin-left: 20px;
            position: sticky;
            top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .checkout-summary h3 {
            margin-bottom: 20px;
        }

        .checkout-summary p {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }

        .checkout-summary p strong {
            font-size: 18px;
            color: #000;
        }

        .checkout-summary .summary-line {
            border-top: 1px solid #ddd;
            margin: 10px 0;
            padding-top: 10px;
        }

        .submit-button {
            width: 100%;
            padding: 15px;
            background-color: #084B83;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            border: none;
        }

        .submit-button:hover {
            background-color: #066ba1;
        }
    </style>
</head>
<body>


<div class="checkout-container">
    <div class="form-section">
        <h2>Customer Information</h2>
        <form action="process_order.php" method="POST">
            <!-- Customer Details -->
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" pattern="[A-Za-z\s]+"   title="Full name should only contain letters and spaces" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>

            <label for="city">City</label>
            <input type="text" id="city" name="city" required>

            <label for="state">State</label>
            <input type="text" id="state" name="state" required>

            <label for="postal_code">Postal Code</label>
            <input type="text" id="postal_code" name="postal_code" pattern="\d{5}" title="Please enter a valid 5-digit postal code" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" pattern="\d{10}" title="Please enter a valid 10-digit phone number" required>

            <!-- Payment Information -->
            <h2>Payment Information</h2>

            <label for="card_number">Card Number</label>
            <input type="text" id="card_number" name="card_number" pattern="\d{16}" title="Please enter a valid 16-digit card number" required>

            <label for="exp_date">Expiration Date</label>
            <input type="month" id="exp_date" name="exp_date" required>

            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" pattern="\d{3}" title="Please enter a valid 3-digit CVV" required>

            <label for="payment_method">Payment Method</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">Select Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="paypal">PayPal</option>
            </select>

            <button type="submit" class="submit-button">Place Order</button>
        </form>
    </div>


    <div class="checkout-summary">
        <h3>Order Summary</h3>
        <p>Subtotal: <span>₹<?php echo htmlspecialchars($total); ?></span></p>
        <p>Discount (15%): <span>-₹<?php echo htmlspecialchars($discount); ?></span></p>
        <p><strong>Total: ₹<?php echo htmlspecialchars($final_total); ?></strong></p>
        <div class="summary-line"></div>
        <p><strong>Total Payable: ₹<?php echo htmlspecialchars($final_total); ?></strong></p>
    </div>
</div>

</body>
</html>

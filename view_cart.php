<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $product_name = htmlspecialchars($_POST['product_name']); // Encode the name
    $product_image = htmlspecialchars($_POST['product_image']); // Encode the image URL
    $quantity = intval($_POST['quantity']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'image' => $product_image,
            'quantity' => $quantity,
        ];
    }

    header('Location: view_cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart_style.css">
    <style>
        /* PharmEasy-like Cart Styling */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .cart-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 20px auto;
        }
        .cart-items {
            flex: 2;
            margin-right: 20px;
        }
        .cart-item {
            display: flex;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .cart-item img {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            margin-right: 20px;
        }
        .cart-item-details {
            flex: 1;
        }
        .cart-item-details h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .cart-item-details p {
            color: #888;
            margin: 5px 0;
        }
        .cart-item-actions {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .cart-item-actions .delete-icon {
            color: #ff4c4c;
            font-size: 1.5em;
            cursor: pointer;
        }
        .cart-item-actions .delete-icon:hover {
            color: #e60000;
        }
        .cart-summary {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
            flex: 1;
            margin-left: 20px;
        }
        .cart-summary h3 {
            margin: 0 0 20px;
            font-size: 1.5em;
            color: #333;
        }
        .cart-summary p {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }
        .cart-summary p strong {
            font-size: 18px;
            color: #000;
        }
        .cart-summary .summary-line {
            border-top: 1px solid #ddd;
            margin: 10px 0;
            padding-top: 10px;
        }
        .checkout-button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #084B83;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            border: none;
        }
        .checkout-button:hover {
            background-color: #066ba1;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <div class="cart-items">
            <h1>Your Cart</h1>

            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $total = 0;

                foreach ($_SESSION['cart'] as $product_id => $product) {
                    // Retrieve the price and image of the product from the database
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

// Retrieve the price, image, and name of the product from the database
$sql = "SELECT new_price, image_url, name FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Failed to prepare the statement: " . $conn->error);
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product_data = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Debugging
if (!$product_data) {
    echo "<p>Product data not found for ID: $product_id</p>";
    continue; // Ensure this is within a loop; otherwise, handle the case appropriately
}

$price = $product_data['new_price'];
$image_url = $product_data['image_url'];
$product_name = $product_data['name']; // Retrieve the product name
$subTotal = $price * $product['quantity'];
$total += $subTotal;

echo '<div class="cart-item">';
echo '<img src="' . htmlspecialchars($image_url) . '" alt="' . htmlspecialchars($product_name) . '">';
echo '<div class="cart-item-details">';
echo '<h2>' . htmlspecialchars($product_name) . '</h2>'; // Display the product name
echo '<p>Price: ₹' . htmlspecialchars($price) . '</p>';
echo '<p>Quantity: ' . htmlspecialchars($product['quantity']) . '</p>';
echo '<p>Subtotal: ₹' . htmlspecialchars($subTotal) . '</p>';
echo '</div>';
echo '<div class="cart-item-actions">';
echo '<span class="delete-icon" onclick="removeItem(' . htmlspecialchars($product_id) . ')">🗑</span>';
echo '</div>';
echo '</div>';

                    
                }

                // Calculate the discount (15%)
                $discount = 0.15 * $total;
                $final_total = $total - $discount;
                ?>

                <script>
                  function removeItem(productId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "remove_from_cart.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                // Reload the cart to reflect changes
                                location.reload();
                            } else {
                                console.error('Error removing item:', response.message);
                            }
                        }
                    };
                    xhr.send("product_id=" + encodeURIComponent(productId));
                }
                </script>

            <?php
            } else {
                echo "<p>Your cart is empty.</p>";
            }
            ?>
        </div>

        <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-summary">
            <h3>Order Summary</h3>
            <p>Subtotal: <span>₹<?php echo htmlspecialchars($total); ?></span></p>
            <p>Discount (15%): <span>-₹<?php echo htmlspecialchars($discount); ?></span></p>
            <p><strong>Total: <span>₹<?php echo htmlspecialchars($final_total); ?></span></strong></p>
            <button class="checkout-button" onclick="location.href='checkout.php'">Proceed to Checkout</button>
        </div>
        <?php endif; ?>
    </div>
    
</body>
</html>

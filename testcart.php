<?php
session_start();

// Handle adding product to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'] ?? 'Unknown Product';
    $product_image = $_POST['product_image'] ?? 'default.jpg';
    $product_description = $_POST['product_description'] ?? 'No description available';

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the product to the cart or update the quantity if it already exists
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'image' => $product_image,
            'description' => $product_description,
            'quantity' => 1,
        ];
    }

    // Display a success message (for example, you can also use JavaScript)
    echo "<script>alert('Product added to cart successfully!');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* Add CSS styles here */
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            margin-right: 15px;
            border-radius: 5px;
        }
        .cart-item h3 {
            margin: 0 0 5px;
        }
        .cart-item p {
            margin: 5px 0;
        }
        .cart-item .quantity {
            margin-left: auto;
            font-weight: bold;
        }
        .cart-container {
            margin-top: 40px;
        }
        .empty-cart {
            font-size: 18px;
            color: #666;
        }
        .cart-header {
            margin-bottom: 20px;
            font-size: 22px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Your page content (e.g., product listing, Add to Cart buttons, etc.) -->

    <div class="cart-container">
        <div class="cart-header">Your Cart</div>
        <?php
        // Display the cart items if any exist
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $product) {
                echo "<div class='cart-item'>";
                echo "<img src='" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "' />";
                echo "<div>";
                echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                echo "</div>";
                echo "<div class='quantity'>Qty: " . htmlspecialchars($product['quantity']) . "</div>";
                echo "</div>";
            }
        } else {
            // If the cart is empty
            echo "<p class='empty-cart'>Your cart is empty.</p>";
        }
        ?>
    </div>

</body>
</html>

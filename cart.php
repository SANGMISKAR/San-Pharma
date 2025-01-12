<?php
// Start the session
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
    header("Location: login_register.html"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's id
$user_id = $_SESSION['user_id'];

// Fetch all cart items for the logged-in user
$sql = "SELECT c.quantity, p.name, p.description, p.image_url, p.new_price AS price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart_style.css">
</head>
<body>
    <h2 class="cart-title">My Cart</h2>
    <div class="cart-container">
        <div class="cart-items" id="cart-items">
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="<?php echo $item['image_url']; ?>" alt="Product Image" class="product-image">
                        <div class="product-details">
                            <h3 class="product-name"><?php echo $item['name']; ?></h3>
                            <p class="product-description"><?php echo nl2br($item['description']); ?></p>
                            <div class="quantity-controls">
                                <button class="decrease-quantity">-</button>
                                <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1">
                                <button class="increase-quantity">+</button>
                            </div>
                            <p class="product-price">₹<?php echo number_format($item['price'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
        <div class="order-summary">
            <h3>Order Summary</h3>
            <p class="subtotal">Subtotal: ₹<span id="subtotal">0.00</span></p>
            <p class="discount">Discount (15%): -₹<span id="discount">0.00</span></p>
            <p class="total">Total: ₹<span id="total">0.00</span></p>
            <button class="checkout-button" onclick="location.href='checkout.php'">Checkout</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subtotalElement = document.getElementById('subtotal');
            const discountElement = document.getElementById('discount');
            const totalElement = document.getElementById('total');

            function updateOrderSummary() {
                let subtotal = 0;
                const cartItems = document.querySelectorAll('.cart-item');
                cartItems.forEach(item => {
                    const price = parseFloat(item.querySelector('.product-price').textContent.replace('₹', ''));
                    const quantity = parseInt(item.querySelector('.quantity-input').value);
                    subtotal += price * quantity;
                });
                
                const discount = subtotal * 0.15;  // 15% discount
                const total = subtotal - discount;

                subtotalElement.textContent = subtotal.toFixed(2);
                discountElement.textContent = discount.toFixed(2);
                totalElement.textContent = total.toFixed(2);
            }

            // Add event listeners for quantity controls
            document.querySelectorAll('.increase-quantity').forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.closest('.cart-item').querySelector('.quantity-input');
                    input.value = parseInt(input.value) + 1;
                    updateOrderSummary();
                });
            });

            document.querySelectorAll('.decrease-quantity').forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.closest('.cart-item').querySelector('.quantity-input');
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateOrderSummary();
                    }
                });
            });

            // Initial update of the order summary
            updateOrderSummary();
        });
    </script>
</body>
</html>

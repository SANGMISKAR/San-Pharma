<?php
session_start();
// Uncomment if you have admin authentication
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_pharmacy";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Orders</title>
    <link rel="stylesheet" href="admin_style.css">
    <style>
        
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4; /* Light Gray background for the entire page */
}

/* Navigation Bar Styles */
.navbar {
    background-color: #084B83; /* Dark Blue */
    color: #fff;
    overflow: hidden;
    position: fixed;
    top: 0;
    width: 100%;
    height: 2.8em;
    border-bottom: 1px solid #ddd;
}

.navbar .logo {
    float: left;
    display: flex;
    align-items: center;
    padding: 0 1rem;
}

.navbar .logo img {
    height: 1.5em;
    width: auto;
}

.navbar .nav-links {
    float: left;
    display: flex;
    align-items: center;
    margin-left: 2rem;
}

.navbar .nav-links a {
    color: #fff;
    padding: 0.5rem 1rem;
    text-decoration: none;
    display: block;
    font-size: 1rem;
    transition: background-color 0.3s, border-radius 0.3s;
}

.navbar .nav-links a:hover {
    background-color: #033b6e; /* Slightly darker blue */
    border-radius: 4px; /* Rounded corners for hover effect */
}

/* Content Section */
.content {
    width: 90%;
    margin: 80px auto 20px; /* Adjust margin to accommodate fixed navbar */
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for better definition */
    border-radius: 8px;
}

/* Table Styles */
table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for the table */
    border-radius: 8px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #084B83; /* Dark Blue */
    color: #fff;
    font-weight: bold;
}

td {
    background-color: #fff;
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Light Gray for even rows */
}

tr:hover {
    background-color: #f1f1f1; /* Slightly darker Gray for hover effect */
}

/* Order Items Styles */
.order-items {
    display: none;
}

.order-items table {
    margin: 0;
    border: none;
    background-color: #f9f9f9; /* Consistent with alternating row color */
    box-shadow: none;
    border-radius: 8px; /* Rounded corners for consistency */
}

.order-items th, .order-items td {
    border: 1px solid #ddd;
    padding: 8px;
}

.order-items th {
    background-color: #42BFDD; /* Light Blue */
    color: #fff;
}

.order-items td {
    background-color: #fff;
}

/* Button Styles */
.toggle-btn {
    cursor: pointer;
    color: #084B83; /* Dark Blue */
    background-color: #e0e0e0; /* Light Gray */
    padding: 8px 12px;
    border: none;
    border-radius: 4px; /* Rounded corners for buttons */
    font-size: 14px;
    transition: background-color 0.3s, color 0.3s;
}

.toggle-btn:hover {
    background-color: #d4d4d4; /* Slightly darker Gray */
    color: #033b6e; /* Darker Blue for text */
}

    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div class="logo">
        <img src="images/san-pharm-favicon-color.webp" alt="Logo"> <!-- Replace with your actual logo -->
    </div>
    <div class="nav-links">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="view_orders.php">View Orders</a>
        <a href="add_product.php">Add Product</a>
        <!-- <a href="add_product.php" onclick="toggleProducts(); return false;">Show Product</a> -->
        <a href="admin_prep.php">Prescription</a>
        <?php echo htmlspecialchars($_SESSION[  'username'  ]); ?>
        <a href="admin_logout.php">Logout</a>
    </div>
</div>

<!-- Main Content -->
<div class="content">
    <h2>Admin - View Orders</h2>
    <!-- <p>Welcome to the admin panel where you can view and manage all the orders placed on the site. Below is a list of all orders with details such as customer name, email, phone number, payment method, and order totals. You can also view the individual items in each order by clicking the "View Items" button.</p> -->
    <p>Use the buttons provided to toggle the visibility of the items in each order for a more detailed view. This feature helps in efficiently managing and reviewing order details.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Payment Method</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Final Total</th>
            <th>Order Date</th>
            <th>View Items</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($order = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
            <td><?php echo htmlspecialchars($order['name']); ?></td>
            <td><?php echo htmlspecialchars($order['email']); ?></td>
            <td><?php echo htmlspecialchars($order['phone']); ?></td>
            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
            <td>₹<?php echo htmlspecialchars($order['total_amount']); ?></td>
            <td>₹<?php echo htmlspecialchars($order['discount']); ?></td>
            <td>₹<?php echo htmlspecialchars($order['final_total']); ?></td>
            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
            <td>
                <button class="toggle-btn" onclick="toggleOrderItems(<?php echo $order['order_id']; ?>)">View Items</button>
            </td>
        </tr>

        <!-- Order items row -->
        <tr id="order-items-<?php echo $order['order_id']; ?>" class="order-items">
            <td colspan="10">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch the items for the current order
                        $order_id = $order['order_id'];
                        $item_sql = "SELECT * FROM order_items WHERE order_id = ?";
                        $item_stmt = $conn->prepare($item_sql);
                        $item_stmt->bind_param("i", $order_id);
                        $item_stmt->execute();
                        $items_result = $item_stmt->get_result();

                        while ($item = $items_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['subtotal']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
// Function to toggle visibility of order items
function toggleOrderItems(orderId) {
    var itemsRow = document.getElementById('order-items-' + orderId);
    if (itemsRow.style.display === 'none' || itemsRow.style.display === '') {
        itemsRow.style.display = 'table-row'; // Show items
    } else {
        itemsRow.style.display = 'none'; // Hide items
    }
}
</script>

</body>
</html>

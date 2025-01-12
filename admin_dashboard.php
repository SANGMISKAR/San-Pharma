<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: admin_login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="styles.css">   -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f6f6;
        }
        .navbar {
            background-color: #084B83;
            color: white;
            padding: 1em;
            text-align: center;
            position: sticky;
            top: 0;
            width: 100%;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 1em;
            font-weight: bold;
        }
        .container {
            padding: 2em;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            padding: 1em;
            margin: 1em 0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin-top: 0;
        }
        .card a {
            display: inline-block;
            padding: 0.5em 1em;
            margin-top: 1em;
            background-color: #42BFDD;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .card a:hover {
            background-color: #084B83;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Admin Dashboard</h1>
        <a href="admin_logout.php">Logout</a>
    </div>

    <div class="container">
        <div class="card">
            <h2>Product Management</h2>
            <a href="add_product.php">Add New Product</a>
            <!-- <a href="view_orders.php">View Products</a> -->
        </div>

        <div class="card">
            <h2>Order Management</h2>
            <a href="view_orders.php">View Orders</a>
        </div>
        <div class="card">
            <h2>uploaded Prescription </h2>
            <a href="admin_prep.php">Prescription uploaded</a>
        </div>
    </div>

</body>
</html>

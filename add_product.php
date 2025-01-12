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
    <title>Add New Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        /* Navigation Bar Styles */
.navbar {
    background-color: #084B83; /* Dark Blue */
    color: #fff;
    overflow: hidden;
    position: fixed;
    top: 0;
    width: 100%;
    height: 3.8em;
    border-bottom: 1px solid #ddd;
    margin-bottom: 20px;
}

.navbar .logo {
    float: left;
    display: flex;
    align-items: center;
    padding: 0 1rem;
    padding-left: 30px;
}

.navbar .logo img {
    height: 2.5em;
    width: auto;
}

.navbar .nav-links {
    float: left;
    display: flex;
    align-items: center;
    margin-left: 0.5rem;
    padding: 8px ;

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
    color: white;
    transform: scale(1.1);
    background-color:#084B83 ;/* Slightly darker blue */
    border-radius: 4px; /* Rounded corners for hover effect */
}

        /* nav {
            background-color: #084B83;
            padding: 15px;
            color: white;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-size: 16px;
        }
        nav a:hover {
            text-decoration: underline;
        } */
        h1 {
            text-align: center;
            margin: 20px ;
            margin-top: 100px;
            color: #084B83;
            z-index: 9000;
        }
        form {
            z-index: 9000;
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], textarea, select {
            width: calc(100% - 16px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="file"] {
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #084B83;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #042d54;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            display: none; /* Hidden by default */
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #084B83;
            color: white;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        
.delete-link {
    color: #FF0000;
    text-decoration: none;
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #FF0000;
    background-color: #FFFFFF;
    transition: background-color 0.3s, color 0.3s;
}

.delete-link:hover {
    background-color: #FF0000;
    color: #FFFFFF;
    text-decoration: none;
}

    </style>
    <script>
        function toggleProducts() {
            const table = document.getElementById('productsTable');
            if (table.style.display === "none" || table.style.display === "") {
                table.style.display = "table"; // Show the table
                fetchProducts(); // Fetch products when showing the table
            } else {
                table.style.display = "none"; // Hide the table
            }
        }

        function fetchProducts() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_products.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('productsTableBody').innerHTML = this.responseText;
                }
            }
            xhr.send();
        }

        function showAlert(message) {
            alert(message);
        }
    </script>
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
        <a href="admin_prep.php">Prescription</a>
        <a href="add_product.php" onclick="toggleProducts(); return false;">Show Product</a>
        <?php echo htmlspecialchars($_SESSION[  'username'  ]); ?> 
        <a href="admin_logout.php">Logout</a>
    </div>
</div>

<h1>Add New Product</h1>

<?php
// Database configuration
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Product details
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $availability = $_POST['availability'];
    $old_price = $_POST['old_price'];
    $new_price = $_POST['new_price'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $directions = $_POST['directions'];
    $warnings = $_POST['warnings'];
    $manufacturer = $_POST['manufacturer'];
    $expiry_date = $_POST['expiry_date'];
    $package_quantity = $_POST['package_quantity'];
    $sale_tag = $_POST['sale_tag'];
    $category_id = $_POST['category_id']; // Get the category ID

    // File upload handling
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $filePath = 'product_uploads/' . basename($fileName);

    // Move file to the directory
    if (move_uploaded_file($fileTmpName, $filePath)) {
        // Prepare the SQL statement to insert product details
        $stmt = $conn->prepare("INSERT INTO products (name, brand, availability, old_price, new_price, description, ingredients, directions, warnings, manufacturer, expiry_date, package_quantity, sale_tag, category_id, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters including the file path and category ID
        $stmt->bind_param("ssssssssssssiss", $name, $brand, $availability, $old_price, $new_price, $description, $ingredients, $directions, $warnings, $manufacturer, $expiry_date, $package_quantity, $sale_tag, $category_id, $filePath);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>showAlert('Product added successfully!');</script>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error uploading image!</p>";
    }
}

// Fetch categories for the dropdown
$categories_result = $conn->query("SELECT id, name FROM categories");
?>

<form action="add_product.php" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required minlength="2" maxlength="100" pattern="[A-Za-z0-9 ]+" title="Only letters, numbers, and spaces are allowed." placeholder="Enter product name">

    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" required minlength="2" maxlength="100" pattern="[A-Za-z0-9 ]+" title="Only letters, numbers, and spaces are allowed." placeholder="Enter brand name">

    <label for="availability">Availability:</label>
    <select id="availability" name="availability" required>
        <option value="">Select Availability</option>
        <option value="In Stock">In Stock</option>
        <option value="Out of Stock">Out of Stock</option>
    </select>

    <label for="old_price">Old Price:</label>
    <input type="text" id="old_price" name="old_price" pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price format. E.g., 19.99" placeholder="Enter old price (optional)">

    <label for="new_price">New Price:</label>
    <input type="text" id="new_price" name="new_price" required pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price format. E.g., 19.99" placeholder="Enter new price">

    <label for="description">Description:</label>
    <textarea id="description" name="description" required minlength="10" maxlength="1000" title="Description must be at least 10 characters long." placeholder="Enter product description"></textarea>

    <label for="ingredients">Ingredients:</label>
    <textarea id="ingredients" name="ingredients" maxlength="500" title="Maximum 500 characters allowed." placeholder="Enter ingredients (Comma Seprated)"></textarea>

    <label for="directions">Directions:</label>
    <textarea id="directions" name="directions" maxlength="500" title="Maximum 500 characters allowed." placeholder="Enter usage directions "></textarea>

    <label for="warnings">Warnings:</label>
    <textarea id="warnings" name="warnings" maxlength="500" title="Maximum 500 characters allowed." placeholder="Enter warnings (Comma Seprated)"></textarea>

    <label for="manufacturer">Manufacturer:</label>
    <input type="text" id="manufacturer" name="manufacturer" maxlength="100" title="Maximum 100 characters allowed." placeholder="Enter manufacturer name" required>

    <label for="expiry_date">Expiry Date:</label>
    <input type="date" id="expiry_date" name="expiry_date" required placeholder="Select expiry date" >

    <label for="package_quantity">Package Quantity:</label>
    <input type="text" id="package_quantity" name="package_quantity" required pattern="^[0-9]+$" title="Please enter a valid number for package quantity." placeholder="Enter package quantity">

    <label for="sale_tag">Sale Tag:</label>
    <input type="text" id="sale_tag" name="sale_tag" maxlength="100" title="Maximum 100 characters allowed." placeholder="Enter sale tag">

    <label for="category">Category:</label>
    <select id="category" name="category_id" required>
        <option value="">Select Category</option>
        <?php
        // Populate dropdown with categories
        if ($categories_result->num_rows > 0) {
            while ($row = $categories_result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
        }
        ?>
    </select>

    <label for="image">Upload Product Image (JPG, WEBP, PNG only):</label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.webp,.png" required>

    <input type="submit" value="Add Product">
</form>



<!-- Products Table -->
<table id="productsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Brand</th>
            <th>Availability</th>
            <th>Old Price</th>
            <th>New Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody id="productsTableBody">
        <!-- Product data will be injected here -->
    </tbody>
</table>

<?php
$conn->close();
?>

</body>
</html>
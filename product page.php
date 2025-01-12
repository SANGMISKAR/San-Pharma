<?php
// Database connection
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

// Fetch product by ID from the database
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Retrieve the product ID from the URL

    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "No product selected.";
    exit;
}

// Fetch random products for display
$random_products_sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
$random_products_result = $conn->query($random_products_sql);
$random_products = $random_products_result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Product Details</title>
    <link rel="stylesheet" href="product_style.css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // Add event listener to all "Add to Cart" buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            // Get product data from data attributes
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productImage = this.getAttribute('data-image');
            const productDescription = this.getAttribute('data-description');
            
            // Send data to the server
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'product_id': productId,
                    'product_name': productName,
                    'product_image': productImage,
                    'product_description': productDescription
                })
            })
            .then(response => response.text())
            .then(data => {
                // Handle response from the server
                console.log('Success:', data);
                alert('Product added to cart!');
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    });
});

    </script>
    <?php
session_start();

// Check if product data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $product_description = $_POST['product_description'];

    // Initialize the cart if it doesn't exist yet
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the product to the cart, or increase the quantity if it already exists
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

    echo "Product added to cart!";
} else {
    echo " ";
}
?>

    <style>
        .product-page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .product-details {
            display: flex;
            margin-bottom: 20px;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
        }

        .product-info {
            margin-left: 20px;
        }

        .price-section .old-price {
            text-decoration: line-through;
            color: #999;
        }

        .price-section .new-price {
            color: #084B83;
        }

        .add-to-cart-btn {
            background-color: #084B83;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: #42BFDD;
        }

        .description ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        /* OFFERS IMAGE */
.offers {
    width: 100%;
    height: 250px;
    background-color: #f4f4f4;  
    margin-bottom: 20px;  
    display: flex;  
    justify-content: center;  
    align-items: center;  
    overflow: hidden;  
    position: relative;  
}

.offers::before {
    content: ""; /* Empty content for overlay effect */
    position: absolute; /* Absolute positioning */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1); /* Semi-transparent overlay for effect */
    pointer-events: none; /* Allow clicks to pass through */
}

.offers img {
    max-width: 100%;
    height: auto; /* Ensures the image maintains its aspect ratio */
    object-fit: cover; /* Covers the entire container */
    border-radius: 8px; /* Optional: adds rounded corners */
    transition: transform 0.3s ease; /* Smooth hover effect */
}


.offers img:hover {
    transform: scale(1.05);  
}


/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

 
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}


.random-products {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding: 10px 0;
}

.product {
    border: 1px solid #ddd;
    border-radius: 12px; /* Increased radius for a more modern look */
    padding: 15px;
    width: 250px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s; /* Smooth transitions for hover effect */
}

.product:hover {
    transform: scale(1.05); /* Pop-up effect */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
    border-color: #42BFDD; /* Blue border color on hover */
}

.product img {
    max-width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 12px; /* Match the border radius of the container */
}

.product h3 {
    margin: 10px 0;
}

.product p {
    color: #42BFDD;
    font-weight: bold;
}

.buy-product {
    background-color: #084B83;
    color: #fff;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 8px; /* Rounded corners for a modern button look */
    border: none;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s; /* Smooth transitions for hover effect */
}

.buy-product:hover {
    background-color: #42BFDD;
    transform: scale(1.05); /* Slightly enlarge button on hover */
}

        .add-to-cart {
    background-color: #42BFDD;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}

.add-to-cart:hover {
    background-color: #3399cc;
}
.reviews {
            margin-top: 20px;
        }

        .review {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .review h4 {
            margin: 0 0 10px 0;
        }

        .review p {
            margin: 0;
        }

        .review .reviewer {
            font-weight: bold;
        }
        .stars {
            color: #FFD700;
        }

        .stars .star {
            display: inline-block;
            font-size: 1.2em;
        }

        .stars .star.filled {
            color: #FFD700;
        }

        .stars .star.empty {
            color: #ddd;
        }

    </style>
</head>
<body>
    <div class="product-page-container">
        <div class="product-details">
            <div class="product-image">
                <img src="<?php echo $product['image_url']; ?>" alt="Product Image">
                <span id="sale-tag" class="sale-tag"><?php echo $product['sale_tag'] ? "Sale" : ""; ?></span>
            </div>
            <div class="product-info">
                <h1><?php echo $product['name']; ?></h1>
                <p><strong>Brand:</strong> <?php echo $product['brand']; ?></p>
                <p><strong>Product Code:</strong> <?php echo $product['id']; ?></p>
                <p><strong>Availability:</strong> <?php echo $product['availability']; ?></p>
                <div class="price-section">
                    <p><strong>Price:</strong> <span class="old-price">₹<?php echo $product['old_price']; ?></span>
                    <span class="new-price" id="unit-price">₹<?php echo $product['new_price']; ?></span></p>
                    <p class="total-price">₹<?php echo $product['new_price']; ?></p>
                </div>

                <form action="view_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity">Qty:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                    <button class="add-to-cart" 
    data-id="<?php echo $random_product['id']; ?>" 
    data-name="<?php echo $random_product['name']; ?>"
    data-image="<?php echo $random_product['image_url']; ?>"
    data-description="<?php echo $random_product['description']; ?>">
    Add to Cart
    </button>


                </form>

                <section class="description">
                    <h2>Description</h2>
                    <p><?php echo $product['description']; ?></p>

                    <h3>Ingredients:</h3>
                    <ul>
                        <?php
                        $ingredients = explode(',', $product['ingredients']);
                        foreach ($ingredients as $ingredient) {
                            echo "<li>$ingredient</li>";
                        }
                        ?>
                    </ul>

                    <h3>Directions:</h3>
                    <p><?php echo $product['directions']; ?></p>

                    <h3>Warnings:</h3>
                    <ul>
                        <?php
                        $warnings = explode(',', $product['warnings']);
                        foreach ($warnings as $warning) {
                            echo "<li>$warning</li>";
                        }
                        ?>
                    </ul>

                    <p><strong>Manufacturer:</strong> <?php echo $product['manufacturer']; ?></p>
                    <p><strong>Expiry Date:</strong> <?php echo $product['expiry_date']; ?></p>
                </section>
            </div>
        </div>

        <!-- Offers Section -->
        <div class="offers">
            <img src="images/website1600.png" alt="Special Offers">
        </div>

        <!-- Random Products Section -->
        <div class="random-products">
            <?php foreach ($random_products as $random_product): ?>
            <div class="product">
                <img src="<?php echo $random_product['image_url']; ?>" alt="<?php echo $random_product['name']; ?>">
                <h3><?php echo $random_product['name']; ?></h3>
                <p>₹<?php echo $random_product['new_price']; ?></p>
                <button class="buy-product" data-id="<?php echo $random_product['id']; ?>">Buy</button>
            </div>
            <?php endforeach; ?>
        </div>
    <!-- Reviews Section -->
    <div class="reviews">
            <h2>Customer Reviews</h2>
            <div class="review">
                <h4 class="reviewer">Alice:</h4>
                <div class="stars">
                    <span class="star filled">&#9733;</span>
                    <span class="star filled">&#9733;</span>
                    <span class="star filled">&#9733;</span>
                    <span class="star filled">&#9733;</span>
                    <span class="star empty">&#9733;</span>
                </div>
                <p> Great product! It relieved my symptoms quickly and efficiently. Highly recommended for anyone in need of fast relief.</p>
            </div>
            <div class="review">
                <h4 class="reviewer">Bob:</h4>
                <div class="stars">
                    <span class="star filled">&#9733;</span>
                    <span class="star filled">&#9733;</span>
                    <span class="star filled">&#9733;</span>
                    <span class="star empty">&#9733;</span>
                    <span class="star empty">&#9733;</span>
                </div>
                <p>Not as effective as I hoped. The product didn’t match the description and didn’t provide the relief I needed</p>
            </div>
            <div class="review">
                <h4 class="reviewer">Charlie:</h4>
                <div class="stars">
                    <span class="star filled">&#9733;</span>
                    <span class="star filled">&#9733;</span>
                    <span class="star empty">&#9733;</span>
                    <span class="star empty">&#9733;</span>
                    <span class="star empty">&#9733;</span>
                </div>
                <p>Not satisfied with the purchase. The product did not match the description.</p>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity');
            const unitPriceElement = document.getElementById('unit-price');
            const totalPriceElement = document.querySelector('.total-price');
            const unitPrice = parseFloat(unitPriceElement.textContent.replace('₹', '').replace(',', ''));

            function updatePrice() {
                const quantity = parseInt(quantityInput.value);
                const totalPrice = unitPrice * quantity;
                totalPriceElement.textContent = `₹${totalPrice.toFixed(2)}`;
            }

            // Initial price update
            updatePrice();

            // Update price on quantity change
            quantityInput.addEventListener('input', updatePrice);

            // JavaScript to handle the "Buy" button click
            const buttons = document.querySelectorAll('.buy-product');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-id');
                    window.location.href = `product page.php?id=${productId}`;
                });
            });
        });
    </script>
</body>
</html>

<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";  // Default username for XAMPP
$password = "";      // Default password for XAMPP (usually empty)
$dbname = "online_pharmacy"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch products based on category
function fetch_products($conn, $category_id) {
    // SQL query to select products based on category
    $sql = "SELECT id, name, package_quantity, new_price, image_url FROM products WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
// Fetch categories with class
function fetch_categories($conn) {
    $sql = "SELECT id, name, class FROM categories";
    $result = $conn->query($sql);
    $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    return $categories;
}


// Example categories
$categories = [
    1 => "Allergy Relief",
    2 => "Health Care",
    3 => "Fitness",
    4 => "Baby Care",
    // 5 => "Wellness",
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Pharmacy</title>
    <link rel="stylesheet" href="Styles.css">
    <!-- <script>
        fetch(`fetch_product.php?id=${productId}`)
    </script> -->
           <script>
            document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.dropdown');
    const dropdownButton = dropdown.querySelector('a');

    dropdownButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor click behavior
        dropdown.classList.toggle('show');
    });

    // Optional: Close the dropdown if clicking outside of it
    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target) && !event.target.matches('#log-in')) {
            dropdown.classList.remove('show');
        }
    });
});

        </script>
    <style>
   footer {
    background-color: #084B83;
    color: #F0F6F6;
    padding: 40px 0; /* Added padding for more spacing */
    font-size: 0.9rem;
}

.footer-content {
    display: flex;
    justify-content: space-around;
    padding: 40px 0; /* Added padding to increase spacing between sections */
}

.footer-column h3 {
    color: #42BFDD;
    font-size: 1.2rem;
    margin-bottom: 15px; /* Added margin for spacing */
}

.footer-column ul {
    list-style: none;
    padding: 0;
}

.footer-column ul li {
    margin-bottom: 8px; /* Added space between list items */
}

.footer-column ul li a {
    color: #F0F6F6;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-column ul li a:hover {
    color: #42BFDD;
}

.footer-social {
    text-align: center;
    margin-top: 30px; /* Increased margin for more spacing */
}

.footer-social h3 {
    color: #42BFDD;
    margin-bottom: 15px; /* Added space under heading */
}

.social-icons img {
    width: 35px; /* Slightly larger icons */
    margin: 0 15px; /* Increased spacing between icons */
    transition: transform 0.3s;
}

.social-icons img:hover {
    transform: scale(1.1);
}

.footer-bottom {
    text-align: center;
    background-color: #042D56;
    padding: 15px 0; /* Increased padding for the copyright section */
    margin-top: 20px;
}

.footer-bottom p {
    margin: 0;
    color: #BBE6E4;
}


    </style>
</head>
<body>
<header>
        <nav id="navbar">
            <div class="nav-container">
                <div class="logo">
                    <img src="Images/san-pharm-logo-transparent.png" alt="PharmEasy Logo">
                </div>
                <div class="search-bar">
                    <form action="https://www.google.com/search" method="get">
                      <input type="text" name="q" id="search-bar" placeholder="search for the medicine on google" aria-label="Search for the medicine on google">
                      <button type="submit">Search</button>
                  </form>
                </div>
                
                <!-- <div class="nav-links">
                    <img src="Images/discount.png" alt="">
                    <a href="#" aria-label="View offers" id="offer">Offers </a>
                    <img src="Images/supplies.png" alt="">
                    <a href="cart.php" aria-label="View cart" id="cart"> Cart</a>
                    <img src="Images/user.png" alt="">
                    <a href="login_register.html" aria-label="Log in" id="log-in">Log in</a>
                    <script>
                        document.querySelector('.dropdown').addEventListener('click', function() {
                        this.classList.toggle('show');
                        });
                    </script>
                </div> -->
                <div class="nav-links">
    <img src="Images/discount.png" alt="">
    <a href="#offer" aria-label="View offers" >Offers</a>

    <img src="Images/supplies.png" alt="">
    <a href="view_cart.php" aria-label="View cart" id="cart">Cart</a>

    <div class="dropdown">
        <img src="Images/user.png" alt="">
        
        <?php
        if (isset($_SESSION['user_name'])) {
            // Display username with first letter capitalized
            echo '<a href="#" aria-label="Account options" id="log-in">' . ucfirst(htmlspecialchars($_SESSION['user_name'])) . '</a>';
        } else {
            // Direct login link without nesting
            echo '<a href="login_register.html" aria-label="Log In" id="log-in" onclick="window.location.href=\'login_register.html\'">Log In</a>';
        }
        ?>
        <script>
            document.getElementById('log-in').addEventListener('click', function(event) {
            console.log('Log In link clicked');
                });
        </script>
        <?php if (isset($_SESSION['user_name'])): ?>
        <!-- Dropdown content for logged-in user -->
        <div class="dropdown-content">
            <a href="user_logout.php" id="logout">Log Out</a>
        </div>
        <?php endif; ?>
    </div>
</div>


            </div>
         
            <div class="nav-items" id="navItems">
                <a href="#product">Medicine</a>
                <!-- <a href="#lab_test">Lab Test</a> -->
                <!-- <a href="#">Health Care</a> -->
                <a href="health_blog.html">Healthy Blog</a>
                <a href="#prescription-order">Prescription Order</a>
            </div>
        </nav>
    </header>

    <main>
    <section class="categories">
            <h2>Our Products</h2>
            <div class="category-items">
                <div class="category-item">
                    <a href="#product"><img src="Images/medicine.gif" alt="Category 1">
                    <p>Medicine</p></a>
                </div>
                
                <div class="category-item">
                    <a href="health_blog.html"><img src="Images/care.gif" alt="Category 2">
                    <p>Health Blogs</p></a>
                </div>
                
                <div class="category-item">
                    <a href="#product"><img src="Images/heart.gif" alt="Category 3">
                    <p>Wellness</p></a>
                </div>

                <div class="category-item">
                    <a href="#product"><img src="Images/muscle.gif" alt="Category 4">
                    <p>Fitness</p></a>
                </div>
                
                <div class="category-item">
                    <a href="#product"><img src="Images/motherhood.gif" alt="Category 5">
                    <p>Baby Care</p></a>
                </div>
            </div>
        </section>
        
        <section class="prescription-order" id="prescription-order">
            <div class="upload-section">
                <h2>Order with Prescription</h2>
                <img src="Images/prescription.gif" alt="Prescription Icon Gif">
                <p>Upload prescription and we will deliver your medicines</p>
                <button type="button" onclick="location.href='prescription.php'">Upload</button>
            </div>
            <div class="instructions">
                <h3>How does this work?</h3>
                <ol>
                    <li>Upload a photo of your prescription</li>
                    <li>Add delivery address and place the order</li>
                    <li>We will call you to confirm the medicines</li>
                    <li>Now, sit back! Your medicines will get delivered at your doorstep</li>
                </ol>
            </div>
        </section>
        <!-- Offers Section -->
            <div class="offers" id="offer">
                 <img src="images/website1600.png" alt="Special Offers">
            </div>
            <!-- Loop through each category and fetch products -->
            <?php foreach ($categories as $category_id => $category_name): ?>
                <section class="<?= strtolower(str_replace(' ', '-', $category_name)) ?>">
                    <h2><?= $category_name ?></h2>
                    <div class="product-items" id="product">
                        <?php
                    $result = fetch_products($conn, $category_id);
                    if ($result->num_rows > 0) {
                        // Output each product
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="product-item">';
                            echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '">';
                            // echo '<p>' . $row["name"] . ' (' . $row["package_quantity"] . ')</p>';
                            echo '<p>' . $row["name"];
                            if ($row["package_quantity"] > 0) {
                                echo ' (' . $row["package_quantity"] . ')';
                            }
                            echo '</p>';
                                                        
                            echo '<p>₹' . $row["new_price"] . '</p>';
                            echo '<button type="button" onclick="window.location.href=\'product page.php?id=' . $row["id"] . '\';">Buy</button>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No products found in this category.</p>";
                    }
                    ?>
                </div>
            </section>
            <?php endforeach; ?>
            <!-- Offers Section -->
                <div class="offers" id="offer" >
                     <img  src="images/website gig.gif" alt="Special Offers" id="offer">
                </div>
            
    </main>

    <footer>
    <!-- Main footer content -->
    <div class="footer-content">
        <!-- Footer column: About San Pharma -->
        <div class="footer-column">
            <h3>About San Pharma</h3>
            <ul>
                <li><a href="about_us.php">Who We Are</a></li>
                <li><a href="about_us.php">Our Mission & Values</a></li>
                <li><a href="about_us.php">Leadership Team</a></li>
                <li><a href="health_blog.html">Health & Wellness Blog</a></li>
                <li><a href="#">Corporate Social Responsibility</a></li>
                <li><a href="#">Investor Relations</a></li>
            </ul>
        </div>

        <!-- Footer column: Customer Services -->
        <div class="footer-column">
            <h3>Customer Services</h3>
            <ul>
                <li><a href="#product">Order Medicines</a></li>
                <li><a href="#uplaod prescription">Prescription Upload</a></li>
                <li><a href="health_blog.html">Health Consultation</a></li>
                <!-- <li><a href="#">Return & Refund Policy</a></li> -->
                <li><a href="index.php">Shipping Information</a></li>
            </ul>
        </div>

        <!-- Footer column: Our Products -->
        <div class="footer-column">
            <h3>Our Products</h3>
            <ul>
                <li><a href="#">Pharmaceuticals</a></li>
                <li><a href="#">Vitamins & Supplements</a></li>
                <li><a href="#">Health & Wellness</a></li>
            </ul>
        </div>

        <!-- Footer column: Contact Information -->
        <div class="footer-column">
            <h3>Contact Us</h3>
            <ul>
                <li>Email: support@sanpharma.com</li>
                <li>Phone: +1 234 567 890</li>
                <li>Address: 123 Pharma St, City, Country</li>
            </ul>
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="footer-social">
        <h3>Connect with Us</h3>
        <div class="social-icons">
        <a href="https://wa.me/your-number" target="_blank"><img src="links images/whatsapp.png" alt="WhatsApp"></a>
            <a href="https://www.facebook.com" target="_blank"><img src="links images/facebook.png" alt="Facebook"></a>
            <a href="https://www.twitter.com" target="_blank"><img src="links images/twitter.png" alt="Twitter"></a>
            <a href="https://www.instagram.com" target="_blank"><img src="links images/linkedin.png" alt="Instagram"></a>
        </div>
    </div>

    <!-- Copyright Section -->
    <div class="footer-bottom">
        <p>&copy; 2024 San Pharma. All Rights Reserved.</p>
        <p>Created by: Sanket Sahadev Sangmiskar</p>
    </div>
</footer>


    <script src="script.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

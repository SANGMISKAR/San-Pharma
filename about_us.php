<?php
// Database configuration
$host = 'localhost'; // Update with your database host
$user = 'root'; // Update with your database username
$pass = ''; // Update with your database password
$dbname = 'online_pharmacy'; // Update with your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$showPopup = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Execute the query
    if ($stmt->execute()) {
        $showPopup = true; // Show the side notification on successful submission
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - San Pharma</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background: #084B83;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            border-bottom: 3px solid #42BFDD;
            height: 30%;
        }
        header h1 {
            margin: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .about-us, .gallery, .contact {
            margin: 20px 0;
        }
        .about-us h2, .gallery h2, .contact h2 {
            color: #084B83;
        }
        .about-us p, .contact form {
            padding: 15px;
            background: #F0F6F6;
            border-radius: 5px;
        }
        .contact {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-start;
        }
        .contact .form-container {
            flex: 2;
            background: #F0F6F6;
            padding: 15px;
            border-radius: 5px;
        }
        .contact .form-container form {
            display: flex;
            flex-direction: column;
        }
        .contact .form-container form input, .contact .form-container form textarea {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .contact .form-container form button {
            background: #084B83;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .contact .form-container form button:hover {
            background: #42BFDD;
        }
        .contact .image-container {
            flex: 1;
        }
        .contact .image-container img {
            width: 98%;
            height: 400px;
            border-radius: 5px;
        }
        .map-container {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }
        .map-container .map {
            flex: 2;
        }
        .map-container .address {
            flex: 1;
            background: #F0F6F6;
            padding: 15px;
            border-radius: 5px;
        }
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
            border-radius: 5px;
        }
        .gallery {
            margin: 20px 0;
        }
        .gallery h2 {
            margin-bottom: 20px;
        }
        .gallery-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .gallery-item {
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
            display: block;
            transition: opacity 0.3s ease;
        }
        .gallery-item:hover {
            transform: scale(1.05);
        }
        .gallery-item:hover img {
            opacity: 0.8;
        }
        .gallery-item .caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 10px;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .gallery-item:hover .caption {
            opacity: 1;
        }
        /* Side Notification Styles */
        .notification-panel {
            position: fixed;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px 0 0 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            width: 400px; /* Adjust as needed */
        }
        .notification-panel.show {
            display: block;
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }
        .notification-content {
            position: relative;
        }
        .notification-content h2 {
            margin-top: 0;
            color: #084B83;
        }
        .notification-content p {
            font-size: 16px;
            color: #333;
        }
        .notification-content button {
            background: #084B83;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .notification-content button:hover {
            background: #42BFDD;
        }
        .notification-content::before {
            content: '';
            position: absolute;
            top: 20px;
            left: -10px;
            width: 0;
            height: 0;
            border-right: 10px solid #fff;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            transition: border-right 0.3s ease;
        }
        /* .notification-panel.show .notification-content::before {
            border-right-color: #084B83;
        } */
        /* General Footer Styles */
footer {
    background-color: #084B83;
    color: #fff;
    padding: 20px 0;
    font-size: 14px;
}

.footer-container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

.footer-top {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    border-bottom: 1px solid #42BFDD;
    padding-bottom: 20px;
}

.footer-section {
    flex: 1;
    min-width: 150px;
    margin: 0 10px;
}

.footer-section h3 {
    color: #42BFDD;
    margin-bottom: 10px;
    font-size: 16px;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 5px;
}

.footer-section ul li a {
    color: #fff;
    text-decoration: none;
}

.footer-section ul li a:hover {
    text-decoration: underline;
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
}

.footer-contact {
    flex: 1;
}

.footer-social {
    flex: 1;
    text-align: right;
}

.footer-social .social-icon {
    display: inline-block;
    margin-left: 10px;
}

.footer-social .social-icon img {
    width: 24px;
    height: 24px;
    font-size: 80px;
}
span{
    font-size:40px; 
    font-weight:bolder; 
    color:aquamarine;
}
    </style>
</head>
<body>
    <header>
        <h1> <Span>&plus;</Span> San Pharma <Span>&plus;</Span></h1>
    </header>

    <div class="container">
        <!-- Your content here (About Us, Gallery, Map, Contact) -->
        <div class="about-us">
            <h2>About Us</h2>
            <p>Welcome to San Pharma, your trusted online pharmacy committed to delivering high-quality medicines to your doorstep within just 2 hours. Based in Thane, we leverage the power of e-commerce to provide fast, reliable, and affordable healthcare solutions to our customers.</p>
            <p>Founded with the vision to revolutionize the way medicines are delivered, San Pharma combines cutting-edge technology with an efficient logistics network to ensure that you get your medications swiftly and safely. Our easy-to-use online platform allows you to order your medicines conveniently from the comfort of your home.</p>
            <p>Our team is dedicated to ensuring the highest standards of customer satisfaction. We continuously strive to improve our services and expand our product range to meet your needs. Thank you for choosing San Pharma – your health is our priority.</p>
        </div>

        <div class="gallery">
            <h2>Gallery</h2>
            <div class="gallery-grid">
                <!-- Gallery items -->
                <div class="gallery-item">
                    <img src="about us image/delivery1.jpg" alt="Image 1">
                    <div class="caption">Delivery1</div>
                </div>
                <div class="gallery-item">
                    <img src="about us image/delivery2.jpg" alt="Image 2">
                    <div class="caption">Delivery2</div>
                </div>
                <div class="gallery-item">
                    <img src="about us image/delivery3.jpg" alt="Image 3">
                    <div class="caption">Delivery4</div>
                </div>
                <div class="gallery-item">
                    <img src="about us image/warehouse.jpg" alt="Image 3">
                    <div class="caption">Warehouse</div>
                </div>
                <div class="gallery-item">
                    <img src="about us image/delivery3.jpg" alt="Image 3">
                    <div class="caption">Delivery</div>
                </div>
                <div class="gallery-item">
                    <img src="about us image/team.jpg" alt="Image 3">
                    <div class="caption">Team</div>
                </div>
            </div>
        </div>

        <div class="contact" id="contact">
            <div class="form-container" >
                <h2>Contact Us</h2>
                <form action="" method="post">
                    <input type="text" name="name" placeholder="Name" required minlength="2" maxlength="100" pattern="[A-Za-z\s]+" title="Please enter a valid name (letters and spaces only).">
                    <input type="email" name="email" placeholder="Email" required title="Please enter a valid email address.">
                    <input type="text" name="subject" placeholder="Subject" required minlength="2" maxlength="100" pattern="[A-Za-z0-9\s]+" title="Please enter a valid subject (letters, numbers, and spaces only).">
                    <textarea name="message" placeholder="Message" rows="5" required minlength="10" maxlength="1000" title="Message must be at least 10 characters long."></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
            <div class="image-container">
                <img src="about us image/contactus.png" alt="Contact Us Image">
            </div>
        </div>

        <div class="map-container">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d243647.16175858568!2d72.82025867335938!3d19.181469347319418!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b86b75e1c6f9%3A0x4e8288d4b1f8ef!2sThane%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1630565754483!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="address">
                <h3>Our Address</h3>
                <p>San Pharma</p>
                <p>123 Main Street</p>
                <p>Thane, Maharashtra, India</p>
                <p>Phone: +91-123-456-7890</p>
                <p>Email: info@sanphaPharma.com</p>
            </div>
        </div>
    </div>

    <!-- Side Notification Panel -->
    <div class="notification-panel <?php if ($showPopup) echo 'show'; ?>">
        <div class="notification-content">
            <h2>Message Sent!</h2>
            <p>Your message has been successfully sent. We will get back to you shortly.</p>
            <button onclick="hideNotification()">Close</button>
        </div>
    </div>


    <script>
        function hideNotification() {
            document.querySelector('.notification-panel').classList.remove('show');
        }
    </script>

<footer>
    <div class="footer-container">
        <!-- Footer Top Section -->
        <div class="footer-top">
            <div class="footer-section">
                <h3>Products</h3>
                <ul>
                    <li><a href="index.php">Pharmaceuticals</a></li>
                    <li><a href="index.php">Supplements</a></li>
                    <li><a href="index.php">Personal Care</a></li>
                    <!--   -->
                </ul>
            </div>
            <!-- <div class="footer-section">
                <h3>Pharmacist Support</h3>
                <ul>
                    <li><a href="#">Consult a Pharmacist</a></li>
                   <li><a href="#">FAQs</a></li>
                    <li><a href="#precription.php">Prescription Guidelines</a></li> 
                </ul>
            </div> -->
            <div class="footer-section">
            </div>
            <div class="footer-section">
                <h3>Customer Satisfaction</h3>
                <ul>
                    <li><a href="#index.php">Customer Reviews</a></li>
                    <li><a href="#contact">Feedback</a></li>
                    <!-- <li><a href="#">Loyalty Program</a></li> -->
                </ul>
            </div>
        </div>
        <!-- Footer Bottom Section -->
        <div class="footer-bottom">
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p style="color:antiquewhite">Email: <a style="color:antiquewhite;" href="mailto:sanpharma@gmail.com">sanpharma@gmail.com</a></p>
                <p>Phone: +91-123-456-7890</p>
                <p>Address: 123 Main Street, Thane, Maharashtra, India</p>
            </div>
            <div class="footer-social">
                <a href="#" class="social-icon"><img src="links images/whatsapp.png"WhatsApp"></a>
                <a href="#" class="social-icon"><img src="links images/facebook.png" alt="Facebook"></a>
                <a href="#" class="social-icon"><img src="links images/twitter.png" alt="Twitter"></a>
                <a href="#" class="social-icon"><img src="links images/instagram.png" alt="Instagram"></a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

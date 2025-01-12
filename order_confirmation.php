<?php
session_start();

// Check if order_id is set
if (!isset($_GET['order_id'])) {
    echo "No order found. <a href='index.php'>Continue Shopping</a>";
    exit();
}

$order_id = $_GET['order_id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_pharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order details from the orders table
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Order not found. <a href='index.php'>Continue Shopping</a>";
    exit();
}

// Fetch order items from the order_items table
$sql = "SELECT * FROM order_items WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #084B83;
        }
        .order-details, .order-items {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .order-summary {
            text-align: right;
            font-weight: bold;
        }
        .continue-shopping {
            text-align: center;
            margin-top: 20px;
        }
        .continue-shopping a {
            background-color: #42BFDD;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Your Order Is Placed</h1>

    <div class="order-details">
        <h2>Order Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
    </div>

    <div class="order-items">
        <h2>Items Purchased</h2>
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
                <?php while ($item = $order_items_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>&#8377;<?php echo number_format($item['price'], 2); ?></td>
                        <td>&#8377;<?php echo number_format($item['subtotal'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="order-summary">
        <p><strong>Total:</strong> &#8377;<?php echo number_format($order['total_amount'], 2); ?></p>
        <p><strong>Discount:</strong> &#8377;<?php echo number_format($order['discount'], 2); ?></p>
        <p><strong>Final Total:</strong> &#8377;<?php echo number_format($order['final_total'], 2); ?></p>
    </div>

    <div class="continue-shopping">
        <a href="index.php">Continue Shopping</a>
    </div>
</div>

</body>
</html>
<?php 

// Check if order_id is set
// if (!isset($_GET['order_id'])) {
//     echo "No order found. <a href='index.php'>Continue Shopping</a>";
//     exit();
// }

// $order_id = $_GET['order_id'];

// Database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "online_pharmacy";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Fetch order details from the orders table
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Order not found. <a href='index.php'>Continue Shopping</a>";
    exit();
}

// Fetch order items from the order_items table
$sql = "SELECT * FROM order_items WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items_result = $stmt->get_result();
// Generate PDF
require 'C:\xampp\htdocs\test online pharmnacy\fpdf\fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();

// Set margins for the entire content to prevent overlap with the border
$left_margin = 15;
$pdf->SetLeftMargin($left_margin);
$pdf->SetRightMargin($left_margin);

// Add a border with design around the page (decorative)
$pdf->SetLineWidth(0.8);
$pdf->SetDrawColor(66, 191, 221); // Light Blue for the border
$pdf->Rect(5, 5, 200, 287, 'D'); // Outer border
$pdf->SetLineWidth(0.2);
$pdf->Rect(10, 10, 190, 277, 'D'); // Inner decorative border
$pdf->Ln(10);

// Add Logo to the left side
$pdf->Image('C:\xampp\htdocs\test online pharmnacy\Images\san-pharm-logo-transparent.png', $left_margin, 15, 30); // Left-aligned logo
$pdf->Ln(25); // Move down after the logo

// Title
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(8, 75, 131); // Dark Blue color
$pdf->Cell(0, 10, 'Order Confirmation', 0, 1, 'C');
$pdf->Ln(5); // Remove extra spacing

// Order Details Section Title
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 0, 0); // Black color
$pdf->Cell(0, 10, 'Order Details:', 0, 1, 'L');
$pdf->Ln(5); // Adjust spacing

// Order Details
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0); // Black color
$pdf->Cell(0, 10, 'Order ID: ' . htmlspecialchars($order['order_id']), 0, 1);
$pdf->Cell(0, 10, 'Customer Name: ' . htmlspecialchars($order['name']), 0, 1);
$pdf->Cell(0, 10, 'Address: ' . htmlspecialchars($order['address']), 0, 1);
$pdf->Cell(0, 10, 'Phone: ' . htmlspecialchars($order['phone']), 0, 1);
$pdf->Cell(0, 10, 'Email: ' . htmlspecialchars($order['email']), 0, 1);
$pdf->Cell(0, 10, 'Payment Method: ' . htmlspecialchars($order['payment_method']), 0, 1);
$pdf->Ln(5); // Adjust spacing

// Items Purchased Section Title
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(66, 191, 221); // Light Blue color for the header
$pdf->Cell(90, 10, 'Product Name', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Quantity', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Price', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C', true); // Move to next line

// Items Data
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0); // Black color
while ($item = $order_items_result->fetch_assoc()) {
    $pdf->Cell(90, 10, htmlspecialchars($item['product_name']), 1);
    $pdf->Cell(30, 10, htmlspecialchars($item['quantity']), 1);
    $pdf->Cell(30, 10, 'Rs.' . number_format($item['price'], 2), 1);
    $pdf->Cell(30, 10, 'Rs.' . number_format($item['subtotal'], 2), 1);
    $pdf->Ln();
}
$pdf->Ln(5); // Adjust spacing

// Order Summary Section Title
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Order Summary:', 0, 1);

// Order Summary Details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(10, 10, 'Total: Rs.' . number_format($order['total_amount'], 2), 0, 1);
$pdf->Cell(10, 10, 'Discount: Rs.' . number_format($order['discount'], 2), 0, 1);
$pdf->Cell(10, 10, 'Final Total: Rs.' . number_format($order['final_total'], 2), 0, 1);
$pdf->Ln(10);

// Closing Note
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(125, 125, 125); // Grey color
$pdf->Cell(0, 10, 'Thank you for shopping with us! Your health is our priority.', 0, 1, 'C');

// Output PDF file
$pdf_file_path = 'order_confirmation_' . $order_id . '.pdf';
$pdf->Output('F', $pdf_file_path);



// Send Email
require 'C:\xampp\htdocs\test online pharmnacy\PHPMailer\PHPMailer-master\src\Exception.php';
require 'C:\xampp\htdocs\test online pharmnacy\PHPMailer\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\test online pharmnacy\PHPMailer\PHPMailer-master\src\SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();



try {
    // SMTP server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'sanketsangmiskar2003@gmail.com'; 
    $mail->Password = 'wtutmedpaavsmmis'; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587; 

    // Sender and recipient settings
    $mail->setFrom('sanpharma_email@gmail.com', 'San Pharma'); 
    $mail->addAddress($order['email']); 

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Thank You for Your Order!';

    // Building the email body with enhanced professional styling and customer's name
    $mail->Body = '
        <div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; padding: 20px; background-color: #F0F6F6; border-radius: 8px; border: 1px solid #ddd;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h1 style="color: #084B83;">'. htmlspecialchars($order['name'], ENT_QUOTES, 'UTF-8') . '!</h1>
                <p style="font-size: 16px; margin: 0;">Your order has been successfully processed.</p>
            </div>
            <hr style="border: 1px solid #42BFDD;">
            <h2 style="color: #084B83; font-size: 20px;">Order Details</h2>
            <p><strong>Order ID:</strong> ' . htmlspecialchars($order['order_id'], ENT_QUOTES, 'UTF-8') . '</p>
            <h2 style="color: #084B83; font-size: 20px;">Order Summary</h2>
            <table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                <tr style="background-color: #42BFDD; color: white;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Total Amount</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Discount</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Final Total</th>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">₹' . number_format($order['total_amount'], 2) . '</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">₹' . number_format($order['discount'], 2) . '</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">₹' . number_format($order['final_total'], 2) . '</td>
                </tr>
            </table>
            <p>Your detailed receipt has been attached as a PDF file.</p>
            <p>If you have any questions or need further assistance, feel free to contact us.</p>
            <footer style="margin-top: 20px; text-align: center; font-size: 14px; color: #777;">
                Best regards,<br>
                <strong>San Pharmacy Team</strong><br>
                <span style="color: #084B83;">San Pharma</span>
            </footer>
        </div>
    ';


    // Adding PDF attachment
    $mail->addAttachment($pdf_file_path); 

    // Sending the email
    $mail->send();
    echo '<div style="
        font-family: Arial, sans-serif;
        color: #084B83;
        background-color: #BBE6E4;
        border: 1px solid #42BFDD;
        padding: 15px;
        border-radius: 8px;
        width: max-content; 
        margin: 20px 0;
        text-align: left;
        font-size: 12px;">
        Order details have been sent to your email.
    </div>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

// Optional: Enable verbose debug output
$mail->SMTPDebug = 2; 

// Cleanup
unlink($pdf_file_path); // Delete the PDF file after sending
$stmt->close();
$conn->close();
?>


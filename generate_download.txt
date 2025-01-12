<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_pharmacy"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientName = $_POST['patcient_name'];
    $date = $_POST['date'];
    $doctorName = $_POST['doctor_Name'];
    $hospitalName = $_POST['hospital_name'];

    // File upload handling
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $filePath = 'user_prep_uploads/' . basename($fileName);

    // Move file to the directory
    if (move_uploaded_file($fileTmpName, $filePath)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO prescriptions (patient_name, date, doctor_name, hospital_name, file_name, file_path) VALUES (?, ?, ?, ?, ?, ?)");

        // Bind parameters including the file path
        $stmt->bind_param("ssssss", $patientName, $date, $doctorName, $hospitalName, $fileName, $filePath);

        // Execute the query
        if ($stmt->execute()) {
            $success = true;
            
            // Generate a receipt
            $receiptText = "Prescription Receipt\n";
            $receiptText .= "------------------------\n";
            $receiptText .= "Patient Name: $patientName\n";
            $receiptText .= "Date: $date\n";
            $receiptText .= "Doctor Name: $doctorName\n";
            $receiptText .= "Hospital Name: $hospitalName\n";
            $receiptText .= "Prescription File: $fileName\n";
            $receiptText .= "------------------------\n";
            $receiptText .= "Thank you for uploading your prescription.";

            // Create receipt file
            $receiptFile = 'receipts/' . $patientName . '_receipt.txt';
            file_put_contents($receiptFile, $receiptText);
            
            // Redirect to prescription.php with success and receipt link
            header("Location: prescription.php?status=success&receipt=" . urlencode($receiptFile));
            exit();
        } else {
            $error = $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Error uploading file!";
    }

    $conn->close();

    // Redirect with error message
    if (isset($error)) {
        header("Location: prescription.php?status=error&message=" . urlencode($error));
        exit();
    }
}
?>

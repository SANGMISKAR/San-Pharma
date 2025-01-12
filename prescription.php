<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="prescription.css">
    <title>Upload Prescription</title>
    <style>
        /* Popup notification styles */
        .popup {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .popup.show {
            display: block;
        }
        
    </style>
</head>
<body>
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
        } else {
            $error = $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Error uploading file!";
    }

    $conn->close();

    // Redirect with success or error parameter
    if (isset($success)) {
        header("Location: prescription.php?status=success");
        exit();
    } else {
        header("Location: prescription.php?status=error&message=" . urlencode($error));
        exit();
    }
}
?>

    <form action="prescription.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="header-section">
                <div class="left_logo">
                    <img src="Images/san-pharm-favicon-color.webp" alt="Medicine logo">
                </div>
                <h3>Upload Prescription</h3>
            </div>
            <div class="content">
                <label for="patcient_name">Patient Name</label>
                <input type="text" name="patcient_name" id="patcient_name" required>
            </div>
            <div class="content">
                <label for="date">Date of prescription</label>
                <input type="date" name="date" id="date" required>
            </div>
            <div class="content">
                <label for="doctor_Name">Doctor Name</label>
                <input type="text" name="doctor_Name" id="doctor_Name" required>
            </div>
            <div class="content">
                <label for="hospital_name">Hospital Name</label>
                <input type="text" name="hospital_name" id="hospital_name" required>
            </div>
            <div class="content file-upload">
                <label for="file">Upload Prescription</label>
                <label class="custom-file-upload">
                    <input type="file" id="file" name="file" onchange="displayFileName()" required>
                    Choose File
                </label>
                <div class="file-name" id="file-name">No file chosen</div>
            </div>
            <div class="content">
                <button type="submit">Upload</button>
            </div>
        </div>
    </form>

   <!-- Popup Notification -->
<div class="popup" id="popup-notification"></div>

<!--   -->


    <script>
        function displayFileName() {
            var input = document.getElementById('file');
            var fileName = input.files[0].name;
            document.getElementById('file-name').textContent = fileName;
        }

        // Show popup based on URL parameter
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            var status = urlParams.get('status');
            var message = urlParams.get('message');
            var popup = document.getElementById('popup-notification');

            if (status === 'success') {
                popup.textContent = 'Prescription uploaded successfully!';
                popup.classList.add('show');
            } else if (status === 'error') {
                popup.textContent = 'Error: ' + decodeURIComponent(message);
                popup.classList.add('show');
            }

            // Hide popup after 5 seconds
            setTimeout(function() {
                popup.classList.remove('show');
            }, 5000);
        };
    </script>
</body>
</html>

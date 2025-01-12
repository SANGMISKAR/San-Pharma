<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Prescription Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            /* margin-top: 150px; */
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #084B83;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #084B83;
            color: #fff;
        }

        td img {
            max-width: 150px; /* Adjust size as needed */
            height: auto;
            display: block;
            margin: 0 auto;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .delete-button {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }
        /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.8); /* Black w/ opacity */
    justify-content: centers;
    align-items: center;
}

/* Modal Content (image) */
.modal-content {
    max-width: 80%;
    max-height: 80%; /* Ensure the image doesn't exceed the viewport size */
    display: block;
    margin: auto;
    animation-name: zoomIn;
    animation-duration: 0.6s;
    transition: transform 0.3s ease; /* Smooth zoom */
}
/* Caption text */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content {
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}
/* Zoom Controls */
.zoom-controls {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
}

.zoom-button {
    background-color: #fff;
    border: 2px solid #084B83;
    border-radius: 50%;
    padding: 10px;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s, transform 0.2s;
}

.zoom-button:hover {
    background-color: #084B83;
    color: white;
    transform: scale(1.1);
}


    </style>
</head>
<body>
 
    <div class="container">
        <h1>Prescription Records</h1>
      <!-- Image Modal Structure -->
<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="imgModal">

    <!-- Zoom Controls -->
    <div class="zoom-controls">
        <button id="zoomIn" class="zoom-button">🔍+</button> <!-- Zoom in icon -->
        <button id="zoomOut" class="zoom-button">🔍-</button> <!-- Zoom out icon -->
    </div>
</div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Doctor Name</th>
                    <th>Hospital Name</th>
                    <th>Prescription Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
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

                // Delete record
                if (isset($_GET['delete_id'])) {
                    $delete_id = $_GET['delete_id'];
                    
                    // Retrieve the file name for deletion
                    $delete_sql = "SELECT file_name FROM prescriptions WHERE id=?";
                    $delete_stmt = $conn->prepare($delete_sql);
                    $delete_stmt->bind_param("i", $delete_id);
                    $delete_stmt->execute();
                    $delete_stmt->bind_result($file_name);
                    $delete_stmt->fetch();
                    $delete_stmt->close();

                    // Delete record from the database
                    $delete_sql = "DELETE FROM prescriptions WHERE id=?";
                    $delete_stmt = $conn->prepare($delete_sql);
                    $delete_stmt->bind_param("i", $delete_id);

                    if ($delete_stmt->execute()) {
                        // Optionally, delete the file from the server if you have it stored there
                        // unlink("user_prep_uploads/" . $file_name);

                        echo "<p>Record deleted successfully!</p>";
                    } else {
                        echo "<p>Error deleting record: " . $conn->error . "</p>";
                    }
                    $delete_stmt->close();
                }

                // Fetch data from the prescriptions table
                $sql = "SELECT id, patient_name, date, doctor_name, hospital_name, file_name FROM prescriptions";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['patient_name'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['doctor_name'] . "</td>";
                        echo "<td>" . $row['hospital_name'] . "</td>";

                        // Display the image
                        $filePath = 'user_prep_uploads/' . htmlspecialchars($row['file_name'], ENT_QUOTES, 'UTF-8');
                        if (file_exists($filePath)) {
                            echo "<td><img src='$filePath' alt='Prescription Image' style='cursor: pointer;' onclick='openModal(\"$filePath\")'></td>";
                        } else {
                            echo "<td>No Image</td>";
                        }

                        echo "<td><a href='?delete_id=" . $row['id'] . "' class='delete-button'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script>
// Get the modal
var modal = document.getElementById("imageModal");

// Get the image inside the modal
var modalImg = document.getElementById("imgModal");

// Variables to store the zoom scale and limit the zoom range
var zoomScale = 1;
var zoomStep = 0.1; // Increment for zooming in/out
var maxZoom = 3;    // Max zoom level (300%)
var minZoom = 1;    // Min zoom level (100%)

// Open modal and set the image
function openModal(imageSrc) {
    modal.style.display = "flex";
    modalImg.src = imageSrc;
    zoomScale = 1; // Reset zoom scale when opening
    modalImg.style.transform = `scale(${zoomScale})`; // Reset zoom
}

// Zoom In function
document.getElementById('zoomIn').onclick = function() {
    if (zoomScale < maxZoom) {
        zoomScale += zoomStep;
        modalImg.style.transform = `scale(${zoomScale})`;
    }
};

// Zoom Out function
document.getElementById('zoomOut').onclick = function() {
    if (zoomScale > minZoom) {
        zoomScale -= zoomStep;
        modalImg.style.transform = `scale(${zoomScale})`;
    }
};

// Close the modal when the user clicks the 'x' button
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    modal.style.display = "none";
    zoomScale = 1; // Reset zoom scale when closing
    modalImg.style.transform = `scale(${zoomScale})`;
}

// Close the modal if the user clicks anywhere outside the image
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        zoomScale = 1; // Reset zoom scale when closing
        modalImg.style.transform = `scale(${zoomScale})`;
    }
}
</script>


</body>
</html>

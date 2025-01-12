<?php
// admin_register.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connection.php'; // Include your database connection file

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $hashed_password);

        if ($stmt->execute()) {
            $success = "Registration successful!";
            echo "<script>popFunSuccess();</script>"; // Trigger the pop-up success message
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        /* admin_style.css */
        body {
            font-family: Arial, sans-serif;
            background-color: #F0F6F6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #084B83;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #084B83;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #BBE6E4;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            background-color: #F0F6F6;
        }

        button {
            padding: 10px;
            background-color: #42BFDD;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #084B83;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }

        /* Login link */
        .login-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .login-link a {
            color: #42BFDD;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Popup Message Styling */
        .popmsg {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #42BFDD;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .popmsg.success {
            background-color: #42BFDD;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .register-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Admin Registration</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
        <form action="admin_register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="admin_login.php">Log in here</a>
        </div>
    </div>

    <!-- Popup Message -->
    <div id="popupSuccess" class="popmsg success">
        Registration successful!
    </div>

    <script>
        function popFunSuccess() {
            var popup = document.getElementById('popupSuccess');
            popup.style.display = 'block';  // Show the popup
            setTimeout(function() {
                popup.style.display = 'none';  // Hide the popup after 3 seconds
            }, 3000);
        }

        // Show the success message if registration was successful
        <?php if (isset($success)) { echo "popFunSuccess();"; } ?>
    </script>
</body>
</html>

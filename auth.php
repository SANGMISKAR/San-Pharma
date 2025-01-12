<?php
include 'db_connection.php';
session_start();

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'login') {
            // Login logic
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            // Check if the user is an admin
            $sql_admin = "SELECT * FROM admin_info WHERE email = '$email'";
            $result_admin = mysqli_query($conn, $sql_admin);

            if (mysqli_num_rows($result_admin) == 1) {
                $admin = mysqli_fetch_assoc($result_admin);

                // Verify password
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['name'];
                    $response['success'] = 'Login successful';
                    $response['isAdmin'] = true;
                    echo json_encode($response);
                    exit();
                } else {
                    $response['error'] = 'Invalid password.';
                }
            } else {
                // Check if the user is a regular user
                $sql_user = "SELECT * FROM user_info WHERE email = '$email'";
                $result_user = mysqli_query($conn, $sql_user);

                if (mysqli_num_rows($result_user) == 1) {
                    $user = mysqli_fetch_assoc($result_user);

                    // Verify password
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['name'];
                        $response['success'] = 'Login successful';
                        $response['isAdmin'] = false;
                        echo json_encode($response);
                        exit();
                    } else {
                        $response['error'] = 'Invalid password.';
                    }
                } else {
                    $response['error'] = 'No user found with this email.';
                }
            }

            // Send response as JSON
            echo json_encode($response);
            exit();
        } elseif ($_POST['action'] == 'register') {
            // Registration logic
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $contact = mysqli_real_escape_string($conn, $_POST['contact']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

            // Check if passwords match
            if ($password !== $confirm_password) {
                $response['error'] = "Passwords do not match.";
                echo json_encode($response);
                exit();
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO user_info (name, email, contact, password) VALUES ('$name', '$email', '$contact', '$hashed_password')";

            if (mysqli_query($conn, $sql)) {
                $response['success'] = "Registration successful!";
                echo json_encode($response);
                exit();
            } else {
                $response['error'] = "Error: " . mysqli_error($conn);
                echo json_encode($response);
                exit();
            }
        }
    }
}

mysqli_close($conn);
?>

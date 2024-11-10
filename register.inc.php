<?php
// register.php
require_once 'datacon.inc.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];
    $role_id = 1; // Default role (adjust as needed)

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $message = "Email is already registered.";
        $message_type = "error";
    } else {
        $query = "INSERT INTO users (email, password_hash, full_name, role_id) VALUES ('$email', '$password', '$full_name', $role_id)";
        if (mysqli_query($conn, $query)) {
            $message = "Registration successful.";
            $message_type = "success";
            header("Location: index.php");
        } else {
            $message = "Error during registration: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
}

// Load the registration form with message data
include 'register.php';


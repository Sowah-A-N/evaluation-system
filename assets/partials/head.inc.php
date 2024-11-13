<?php
 session_start();  // Start the session

// // Include the role redirects from a separate file
// include_once '../role_redirects.inc.php'; // Make sure the path is correct

// //Include the database connection file
// include_once '../datacon.inc.php';

// // Define a function to check if the user is logged in
// function is_logged_in() {
//     return isset($_SESSION['user_id']) && isset($_SESSION['role']);
// }

// // Check if the user is logged in
// // if (!is_logged_in()) {
// //     // User is not logged in, redirect to login page
// //     header("Location: ./index.php");
// //     exit();
// // }

// // Get the current user's role from the session
// $user_role = $_SESSION['role_id'];

// // Check if the user's role exists in the redirects array
// if (array_key_exists($user_role, $role_redirects)) {
//     // Redirect to the appropriate page based on the role
//     header("Location: " . $role_redirects[$user_role]);
//     exit();
// } else {
//     // If no valid role is found, redirect to an error or login page
//     header("Location: ../index.php ");
//}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <title><?php echo $pageTitle?></title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- FontAwesome JS-->
    <script defer src="assets/plugins/fontawesome/js/all.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (including Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JQuery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/portal.css">

</head> 
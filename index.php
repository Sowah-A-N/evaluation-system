<?php
// login.php
session_start();
require_once 'datacon.inc.php';
require_once 'role_redirects.inc.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user by email
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role_id'] = $user['role_id'];
        $role_id = $user['role_id'];
        
        if (array_key_exists($role_id, $role_redirects)) {
            $redirect_url = $role_redirects[$role_id];
            header("Location: $redirect_url");
        }
    } else {
        $message = "Invalid email or password.";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom Styling */
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: url("img/login-pg-bg.jpg") no-repeat center center fixed;
      background-size: cover;
      font-family: "Open Sans", sans-serif;
    }
    .wrapper {
      width: 400px;
      padding: 30px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      backdrop-filter: blur(8px);
      text-align: center;
    }
    h2 {
      color: #fff;
      font-size: 2rem;
    }
    .input-field {
      margin-bottom: 15px;
    }
    .input-field label {
      color: #aaa;
    }
    .form-control {
      background: transparent;
      color: #fff;
      border: 1px solid #ddd;
    }
    .form-control::placeholder {
      color: #ccc;
    }
    .btn-primary {
      background: #fff;
      color: #000;
      border: none;
      transition: 0.3s;
    }
    .btn-primary:hover {
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
    }
    .message {
      margin-bottom: 15px;
    }
    .register p, .forget a {
      color: #ddd;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <form action="index.php" method="POST">
      <h2>Login</h2>

      <!-- Display Message Area for Success or Error Alerts -->
      <?php if (!empty($message)) { ?>
        <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?> message">
          <?php echo $message; ?>
        </div><br />
      <?php } ?>

      <!-- Email Field -->
      <div class="input-field">
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>

      <!-- Password Field -->
      <div class="input-field">
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>

      <!-- Forgot Password Link -->
      <div class="forget text-right">
        <a href="#">Forgot password?</a>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary btn-block">Log In</button>

      <!-- Register Redirect -->
      <div class="register mt-3">
        <p>Don't have an account? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h2>Register</h2>
          </div>
          <div class="card-body">
            <!-- Display message area for success or error messages -->
            <?php if (isset($message)) { ?>
              <div class="alert <?php echo $message_type == 'success' ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
              </div>
            <?php } ?>

            <!-- Registration Form -->
            <form action="register.inc.php" method="POST">
              <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <!-- Login Redirect -->
            <div class="text-center mt-3">
              <p>Already have an account? <a href="index.php">Log in</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional Bootstrap JavaScript and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

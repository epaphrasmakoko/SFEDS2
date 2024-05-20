<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="./bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/login.css">
  <link rel="stylesheet" href="./css/general.css">
</head>
<body>
  <div class="login-page">
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-5">
          <figure>
            <figcaption><h5><strong>SECURE FILE ENCRYPTION AND DECRYPTION SYSTEM</strong></h5></figcaption>
            <img src="./images/secure-icon-png-4981.png" alt="Logo" class="logo">
          </figure>
          <div class="card form1">
            <div class="card-body">
              <?php
              // Start session
              session_start();
              
              // Display login error if exists
              if (isset($_SESSION['login_error'])) {
                  echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
                  unset($_SESSION['login_error']);
              }
              ?>
              <form action="./php/login.php" method="POST" class="login-form">
                <h2 class="card-title">Login</h2>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" required placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control" required placeholder="Password">
                </div>
                <div class="form-group form-check">
                  <input type="checkbox" id="rememberMe" name="rememberMe" class="form-check-input">
                  <label for="rememberMe" class="form-check-label">Remember Me</label>
                </div>
                <button type="submit" class="btn btn-dark btn-block">Login</button>
                <div class="mt-3">
                  <a href="#" class="forgot-password link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Forgot Password?</a>
                </div>
              </form>
              <div class="mt-3">
                <p>Don't have an account? <a href="registration.php" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Sign Up</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Modal for Registration Success -->
  <div class="modal fade" id="registrationCompleteModal" tabindex="-1" aria-labelledby="registrationCompleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registrationCompleteModalLabel">Registration Complete!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Your registration was successful. You can now log in to your account.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
  <script src="./jquery/jquery.js"></script>

  <?php
  // Check if registration was successful and display modal
  if (isset($_SESSION['registration_successful']) && $_SESSION['registration_successful']) {
    // Unset session variable
    unset($_SESSION['registration_successful']);
  ?>
  <script>
    // JavaScript to show the modal
    $(document).ready(function() {
      $('#registrationCompleteModal').modal('show');
    });
  </script>
  <?php
  }
  ?>
</body>
</html>

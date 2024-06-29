<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="./bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/login.css">
  <link rel="stylesheet" href="./css/general.css">
  <style>
    .input-group-text {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="login-page">
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-5">
          <figure>
            <figcaption>
              <h5><strong>SECURE FILE ENCRYPTION AND DECRYPTION SYSTEM</strong></h5>
            </figcaption>
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
              <form action="./php/login.php" method="POST" class="login-form needs-validation" novalidate>
                <h2 class="card-title">Login</h2>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" required placeholder="Email">
                  <div class="invalid-feedback">Please provide a valid email address</div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                    <span class="input-group-text" id="toggle-password">
                      <i class="bi bi-eye-slash" id="toggle-password-icon"> <img src="./eye-slash.svg" alt="Show password" width="16" height="16"></i>
                    </span>
                  </div>
                  <div class="invalid-feedback">Please provide a password</div>
                </div>
                <div class="form-group form-check">
                  <!-- <input type="checkbox" id="rememberMe" name="rememberMe" class="form-check-input"> -->
                  <!-- <label for="rememberMe" class="form-check-label">Remember Me</label> -->
                </div>
                <button type="submit" class="btn btn-dark btn-block">Login</button>
                <div class="mt-3">
                  <!-- <a href="#" class="forgot-password link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Forgot Password?</a> -->
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
  <script>
    function togglePassword() {
      const password = document.getElementById('password');
      const icon = document.getElementById('toggle-password-icon');
      if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      } else {
        password.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      }
    }

    document.getElementById('toggle-password').addEventListener('click', togglePassword);
  </script>

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
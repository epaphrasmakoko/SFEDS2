<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link href="./bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/general.css">
  <link rel="stylesheet" href="./css/register.css">
</head>
<body>
  <div class="registration-page vh-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <img src="./images/secure-icon-png-4981.png" alt="Logo" class="logo">
          <div class="card form1">
            <h2 class="card-title">Register to use SFEDS</h2><br>
            <div class="card-body scrollable-card-body">
              <form action="./php/register.php" method="POST" class="registration-form" id="registrationForm">
                <div class="form-group">
                  <input type="text" name="firstName" class="form-control" required placeholder="First Name">
                </div>
                <div class="form-group">
                  <input type="text" name="lastName" class="form-control" required placeholder="Last Name">
                </div>
                <div class="form-group">
                  <input type="tel" name="phoneNumber" class="form-control" required placeholder="Phone Number">
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" required placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control" required placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="password" name="confirmPassword" class="form-control" required placeholder="Confirm Password">
                </div>
                <div class="form-group form-check">
                  <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
                  <label for="terms" class="form-check-label">I agree to the <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="/terms">Terms of Service</a> and <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="/privacy">Privacy Policy</a></label>
                </div>
                <button type="submit" class="btn btn-dark btn-block">Register</button>
              </form>
            </div>
            <div class="mt-3">
              <p>Already have an account? <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="index.php">Back to Login</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Basic client-side validation (example)
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
      var password = document.querySelector('input[name="password"]').value;
      var confirmPassword = document.querySelector('input[name="confirmPassword"]').value;
      if (password !== confirmPassword) {
        event.preventDefault();
        alert("Passwords do not match.");
      }
    });
  </script>
</body>
</html>

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
              <form action="./php/register.php" method="POST" class="registration-form needs-validation" id="registrationForm" novalidate>
                <div class="form-group mb-3">
                  <input type="text" name="firstName" class="form-control" required placeholder="First Name">
                  <div class="invalid-feedback">Please provide your first name</div>
                </div>
                <div class="form-group mb-3">
                  <input type="text" name="lastName" class="form-control" required placeholder="Last Name">
                  <div class="invalid-feedback">Please provide your last name</div>
                </div>
                <div class="form-group mb-3">
                  <input type="tel" name="phoneNumber" class="form-control" required pattern="255\d{9}" placeholder="Phone Number">
                  <div class="invalid-feedback">Please provide a valid phone number in the format 255XXXXXXXXX</div>
                </div>
                <div class="form-group mb-3">
                  <input type="email" name="email" class="form-control" required placeholder="Email">
                  <div class="invalid-feedback">Please provide a valid email address</div>
                </div>
                <div class="form-group mb-3">
                  <input type="password" name="password" class="form-control" required placeholder="Password">
                  <div class="invalid-feedback">Password should be at least 8 characters long and contain uppercase and lowercase letters, numbers, and special characters</div>
                </div>
                <div class="form-group mb-3">
                  <input type="password" name="confirmPassword" class="form-control" required placeholder="Confirm Password">
                  <div class="invalid-feedback">Passwords do not match</div>
                </div>
                <div class="form-group form-check mb-3">
                  <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
                  <label for="terms" class="form-check-label">I agree to the <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="./terms.html">Terms of Service</a> and <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="./privacy.html">Privacy Policy</a></label>
                  <div class="invalid-feedback">You must agree to the terms before submitting</div>
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
  <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // JavaScript validation for the registration form
    document.getElementById('registrationForm').addEventListener('submit', function (event) {
      // Fetch form and input elements
      var form = event.target;
      var password = form.querySelector('input[name="password"]');
      var confirmPassword = form.querySelector('input[name="confirmPassword"]');
      var passwordValue = password.value;
      var confirmPasswordValue = confirmPassword.value;

      // Validate password strength
      var passwordStrengthRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
      var passwordValid = passwordStrengthRegex.test(passwordValue);

      if (!passwordValid) {
        password.classList.add('is-invalid');
      } else {
        password.classList.remove('is-invalid');
        password.classList.add('is-valid');
      }

      // Validate password confirmation
      if (passwordValue !== confirmPasswordValue) {
        confirmPassword.classList.add('is-invalid');
      } else {
        confirmPassword.classList.remove('is-invalid');
        confirmPassword.classList.add('is-valid');
      }

      // Perform Bootstrap validation
      if (!form.checkValidity() || !passwordValid || passwordValue !== confirmPasswordValue) {
        event.preventDefault();
        event.stopPropagation();
      }

      form.classList.add('was-validated');
    });
  </script>
</body>
</html>

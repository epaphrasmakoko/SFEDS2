<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ./index.php");
  exit();
}

// Check for upload errors from session
if (isset($_SESSION['upload_error'])) {
  $uploadError = $_SESSION['upload_error'];
  unset($_SESSION['upload_error']); // Clear the session error
} else {
  $uploadError = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Files</title>
  <link href="./bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/general.css">
  <link rel="stylesheet" href="./css/dashboard.css">
  <link rel="stylesheet" href="./css/userupload.css">
</head>

<body>
  <div class="dashboard">
    <header class="header">
      <div class="logo">
        <figure>
          <img src="./images/secure-icon-png-4981.png" alt="Secure Logo" class="logo-img">
          <figcaption><strong>SFEDS</strong></figcaption>
        </figure>
      </div>
      <div>
        <h3><strong>SECURE FILE ENCRYPTION AND DECRYPTION SYSTEM</strong></h3>
      </div>
      <div>
        <nav class="nav">
          <a href="/dashboard/profile" class="link-light">Profile</a>
          <a href="./php/logout.php" class="link-danger">Logout</a>
        </nav>
      </div>
    </header>
    <div class="main">
      <aside class="sidebar">
        <ul>
          <hr>
          <li><a class="link-light" href="./dashboard.php">Dashboard</a></li>
          <hr>
          <li><a class="link-light" href="./upload.php">Upload</a></li>
          <hr>
          <li><a class="link-light" href="./profile.php">Profile</a></li>
          <hr>
        </ul>
      </aside>
      <div class="content">
        <div class="enrolled-courses">
          <h2><strong><u>Upload File</u></strong></h2>

          <!-- Display upload error if present -->
          <?php if (!empty($uploadError)) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo htmlspecialchars($uploadError); ?>
            </div>
          <?php endif; ?>

          <?php
          if (isset($_SESSION['upload_success'])) {
            echo '<div class="alert alert-success">The file has been uploaded and encrypted.</div>';
            unset($_SESSION['upload_success']);
          }
          ?>


          <form action="./php/upload_handler.php" method="post" enctype="multipart/form-data" class="upload-form">
            <div class="form-group upload">
              <input type="file" name="file" id="file" accept="application/pdf, image/png, image/jpeg, image/jpg, audio/mpeg" class="form-control" required>
            </div>

            <div class="form-group upload">
              <textarea id="description" name="description" class="form-control" required placeholder="Describe the File"></textarea>
            </div>
            <hr>
            <div class="form-group" id="passphraseDiv">
              <label for="passphrase"><strong><u>You must Never forget this Passphrase we cannot recover it...</u></strong></label><br><br>
              <div class="input-group">
                <input type="password" id="passphraseInput" name="passphrase" class="form-control" placeholder="Enter your passphrase" required>
                <span class="input-group-text" id="toggle-passphrase">
                  <i class="bi bi-eye-slash" id="toggle-passphrase-icon"> <img src="./eye-slash.svg" alt="Show passphrase" width="16" height="16"></i>
                </span>
              </div>
            </div>

            <button type="submit" class="btn btn-secondary upload">Submit</button>
          </form>
        </div>
        <div>
          <h1>Welcome <?php echo htmlspecialchars($_SESSION['first_name']); ?></h1>
          <video autoplay loop muted class="video">
            <source src="./images/Lock_video.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
      </div>
    </div>
    <footer class="footer">
      <p>&copy; 2024 CSDFE3 Group. All rights reserved.</p>
    </footer>
  </div>

  <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function togglePassphrase() {
      const passphrase = document.getElementById('passphraseInput');
      const icon = document.getElementById('toggle-passphrase-icon');
      if (passphrase.type === 'password') {
        passphrase.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      } else {
        passphrase.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      }
    }

    document.getElementById('toggle-passphrase').addEventListener('click', togglePassphrase);
  </script>
</body>

</html>
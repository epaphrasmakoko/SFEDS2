<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: ./index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="./bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/general.css">
  <link rel="stylesheet" href="./css/dashboard.css">
  <link rel="stylesheet" href="./css/userupload.css">
</head>
<body>
  <div class="dashboard">
    <!-- Header Component -->
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
    <!-- Main Component -->
    <div class="main">
      <!-- Sidebar Component -->
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
      <!-- Main content area -->
      <div class="content">

  <div class="enrolled-courses">
    <h2><strong><u>Upload File</u></strong></h2>
    <!-- File upload form -->
    <form action="./php/upload_handler.php" method="post" enctype="multipart/form-data" class="upload-form">
  <div class="form-group upload">
    <input type="file" name="file" id="file" accept="image/*, video/*, audio/*, .pdf, .doc, .docx, .txt, .zip, .rar, .csv, .xls, .xlsx, .ppt, .pptx, .mp3, .wav, .ogg, .mp4, .mov, .avi" class="form-control" required>
  </div>

  <div class="form-group upload">
    <textarea id="description" name="description" class="form-control" required placeholder="Describe the File"></textarea>
  </div>

  <label class="radioTitle"><u><strong>Choose Encryption Method:</strong></u></label>
  <div class="form-group methods">
    <div>
      <input id="generatedKey" type="radio" name="uploadType" value="generatedKey" onclick="handleEncryptionMethodChange('generatedKey')" required>
      <label for="generatedKey">Encrypt using auto-generated Key</label><br>
      <input id="passphraseOption" type="radio" name="uploadType" value="passphrase" onclick="handleEncryptionMethodChange('passphrase')" required>
      <label for="passphraseOption">Encrypt using passphrase</label>
    </div>
  </div>
  <hr>

  <div class="form-group" id="passphraseDiv">
    <label for="passphrase">Passphrase:</label>
    <input type="password" id="passphraseInput" name="passphrase" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-secondary upload">Submit</button>
</form>

  </div>
        <div>
          <h1>Welcome <?php echo htmlspecialchars($_SESSION['first_name']); ?></h1>
            <!-- Embedding the video -->
          <video autoplay loop muted class="video">
            <source src="./images/Lock_video.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
      </div>
    </div>
    <!-- Footer Component -->
    <footer class="footer">
      <p>&copy; 2024 CSDFE3 Group. All rights reserved.</p>
    </footer>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function generateRandomString(length) {
      const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
      let result = '';
      const charactersLength = characters.length;
      for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
    }

    function handleEncryptionMethodChange(method) {
      const passphraseInput = document.getElementById('passphraseInput');
      if (method === 'generatedKey') {
        const randomPassphrase = generateRandomString(16);
        passphraseInput.value = randomPassphrase;
        passphraseInput.disabled = true;
      } else if (method === 'passphrase') {
        passphraseInput.value = '';
        passphraseInput.disabled = false;
      }
    }
  </script>
</body>
</html>

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
        <div>
        <div class="personal-information">
    <h2><u>Personal Files</u></h2>
    <!-- Add six folders, split into top and bottom groups -->
    <div class="folders">
      <div class="top-folders">
        <a href="./dashboard/user-documents.php" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
          <div class="folder-item">
            <img src="./images/documents-512.png" alt="folder" class="folder">
            <span class="folder-name">Documents</span>
          </div>
        </a>
        <a href="./dashboard/user-pictures.php" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
          <div class="folder-item">
            <img src="./images/pictures-512.png" alt="folder" class="folder">
            <span class="folder-name">Pictures</span>
          </div>
        </a>
        <a href="./dashboard/user-others.php" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
          <div class="folder-item">
            <img src="./images/folder-3-512.png" alt="folder" class="folder">
            <span class="folder-name">Others</span>
          </div>
        </a>
      </div>
      <div class="bottom-folders">
        <a href="./dashboard/user-videos.php" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
            <div class="folder-item">
              <img src="./images/movies-512.png" alt="folder" class="folder">
              <span class="folder-name">Videos</span>
            </div>
        </a>
        <a href="./dashboard/user-musics.php" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
          <div class="folder-item">
            <img src="./images/music-512.png" alt="folder" class="folder">
            <span class="folder-name">Music</span>
          </div>
        </a>
        <a href="#" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
          <div class="folder-item">
            <img src="./images/full-folder-512.png" alt="folder" class="folder">
            <span class="folder-name">Shared</span>
          </div>
        </a>
      </div>
    </div>
  </div>
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
</body>
</html>

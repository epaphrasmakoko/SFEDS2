<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include the database connection file
require_once '../php/connect_db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['email'] !== 'admin@gmail.com') {
  // Redirect to login page if not logged in or not an admin
  header("Location: ../index.php");
  exit();
}

// Check database connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Fetch total number of users from the database
$sqlUsers = "SELECT COUNT(*) AS total_users FROM users";
$resultUsers = $conn->query($sqlUsers);
if (!$resultUsers) {
  die("Query failed: " . $conn->error);
}

$totalUsers = 0;
if ($resultUsers && $rowUsers = $resultUsers->fetch_assoc()) {
  $totalUsers = $rowUsers['total_users'];
}

// Fetch total number of uploads from the database
$sqlUploads = "SELECT COUNT(*) AS total_uploads FROM files";
$resultUploads = $conn->query($sqlUploads);
if (!$resultUploads) {
  die("Query failed: " . $conn->error);
}

$totalUploads = 0;
if ($resultUploads && $rowUploads = $resultUploads->fetch_assoc()) {
  $totalUploads = $rowUploads['total_uploads'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/general.css">
  <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
  <div class="dashboard">
    <!-- Header Component -->
    <header class="header">
      <div class="logo">
        <figure>
          <img src="../images/secure-icon-png-4981.png" alt="Secure Logo" class="logo-img">
          <figcaption><strong>SFEDS</strong></figcaption>
        </figure>
      </div>
      <div>
        <h3><strong>SECURE FILE ENCRYPTION AND DECRYPTION SYSTEM</strong></h3>
      </div>
      <div>
        <nav class="nav">
          <a href="#" class="link-light">Profile</a>
          <a href="../php/logout.php" class="link-danger">Logout</a>
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
          <li><a class="link-light" href="./user-management.php">All Users</a></li>
          <hr>
          <li><a class="link-light" href="./admin_uploads.php">All Uploads</a></li>
          <hr>
          <li><a class="link-light" href="./admin_profile.php">Profile</a></li>
          <hr>
          <!-- <li><a class="link-light" href="#">Logs</a></li> -->
        </ul>
      </aside>
      <!-- Main content area -->
      <div class="content">
        <div>
          <h1><strong>Dashboard</h1>
          <hr><br><br>
          <h2>Total Users: <strong><?php echo $totalUsers; ?></strong></h2> <!-- Dynamic total users count -->
          <hr>
          <h2>Total Uploads: <strong><?php echo $totalUploads; ?></strong></h2> <!-- Dynamic total uploads count -->
        </div>
        <div>
          <h1>Welcome Admin</h1>
          <!-- Embedding the video -->
          <video autoplay loop muted class="video">
            <source src="../images/Lock_video.mp4" type="video/mp4">
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
  <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

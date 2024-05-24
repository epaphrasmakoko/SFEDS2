<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: ./index.php");
    exit();
}

// Include the database connection file
require_once './php/connect_db.php';

// Retrieve user details from the database
$email = $_SESSION['email'];
$sql = "SELECT first_name, last_name, email, phone_number FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $fullName = $user['first_name'] . ' ' . $user['last_name'];
    $email = $user['email'];
    $phoneNumber = $user['phone_number'];
} else {
    // User not found, handle error (optional)
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <!-- Bootstrap CSS -->
  <link href="./bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/general.css">
  <link rel="stylesheet" href="./css/dashboard.css">
  <link rel="stylesheet" href="./css/profile.css">
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
        <div class="profile-settings">
          <h2><u><strong>Profile Settings</strong></u></h2>
          <div class=info>
            <p>Full Name: <strong><?php echo htmlspecialchars($fullName); ?></strong></p>
            <p>Email: <strong><?php echo htmlspecialchars($email); ?></strong></p>
            <p>Phone Number: <strong><?php echo htmlspecialchars($phoneNumber); ?></strong></p>
          </div>

          <form method="POST" action="./php/update_profile.php" class="needs-validation" novalidate>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" class="form-control" required>
              <div class="invalid-feedback">Password should be at least 8 characters long and contain uppercase and lowercase letters, numbers, and special characters</div>
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
              <div class="invalid-feedback">Passwords do not match</div>
            </div>
            <button type="submit" class="btn btn-dark">Save Changes</button>
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
</body>
</html>

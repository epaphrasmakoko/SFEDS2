<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

// Include database connection
include '../php/connect_db.php';

// Get the logged-in user's email
$userEmail = $_SESSION['email'];

// Fetch the user's files from the database
$sql = "SELECT id, file_name FROM files WHERE user_email = ? AND file_type IN ('png', 'jpg', 'jpeg', 'pdf')";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}
$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/general.css">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/uploads.css">
</head>
<body>
  <div class="dashboard">
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
    <div class="main">
      <aside class="sidebar">
        <ul>
          <hr>
          <li><a class="link-light" href="../dashboard.php">Dashboard</a></li>
          <hr>
          <li><a class="link-light" href="../upload.php">Upload</a></li>
          <hr>
          <li><a class="link-light" href="../profile.php">Profile</a></li>
          <hr>
        </ul>
      </aside>
      <div class="content">
        <div class="document-folder">
          <div class="arrow">
            <a href="../dashboard.php" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
              <img src="../images/arrow-92-256.png" alt="Back" class="back-icon"> Back
            </a>
          </div>
          <div>
            <h2>Files</h2>
          </div>
          <div class="items">
            <ul>
              <?php foreach ($files as $file): ?>
                <li>
                  <a href="#" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" data-id="<?php echo $file['id']; ?>" data-name="<?php echo htmlspecialchars($file['file_name']); ?>" onclick="openModal(this)"><?php echo htmlspecialchars($file['file_name']); ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div>
          <h1>Welcome <?php echo htmlspecialchars($_SESSION['first_name']); ?></h1>
          <video autoplay loop muted class="video">
            <source src="../images/Lock_video.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
      </div>
    </div>
    <footer class="footer">
      <p>&copy; 2024 CSDFE3 Group . All rights reserved.</p>
    </footer>
  </div>

  <div class="modal" id="passphraseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter Passphrase for <span id="fileName"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="fileActionForm" action="../download.php" method="post">
            <div class="mb-3">
              <label for="passphrase" class="form-label">Passphrase</label>
              <input type="password" class="form-control" id="passphrase" name="passphrase" required>
              <input type="hidden" id="file_id" name="file_id">
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Download</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function openModal(element) {
      document.getElementById('file_id').value = element.getAttribute('data-id');
      document.getElementById('fileName').textContent = element.getAttribute('data-name');
      const passphraseModal = new bootstrap.Modal(document.getElementById('passphraseModal'));
      passphraseModal.show();
    }
  </script>
</body>
</html>

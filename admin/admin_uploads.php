<?php
// Start session
session_start();

// Enable error reporting (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once '../php/connect_db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['email'] !== 'admin@gmail.com') {
    // Redirect to login page if not logged in or not an admin
    header("Location: ../index.php");
    exit();
}

// Fetch all uploads from the database
$sql = "SELECT id, user_email, file_name, file_path, description, upload_time FROM files";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Uploads Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css">
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
                    <a href="./admin_profile.php" class="link-light">Profile</a>
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
                    <h2><strong>Uploads Management</strong></h2>
                    <hr>
                    <table class="table table-bordered table-dark table-hover">
                        <thead>
                            <tr>
                                <th>User Email</th>
                                <th>File Name</th>
                                <th>Description</th>
                                <th>Upload Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['upload_time']); ?></td>
                                        <td>
                                            <!-- Download Button -->
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file-id="<?php echo $row['id']; ?>">Download</button>
                                            <!-- Delete Form -->
                                            <form action="./upload_actions.php" method="post" style="display:inline;">
                                                <input type="hidden" name="file_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo "<tr><td colspan='5'>No uploads found</td></tr>";
                            } ?>
                        </tbody>
                    </table>
                    <div class="content">
                        <?php if (isset($_SESSION['action_message'])) : ?>
                            <div class="alert alert-info">
                                <?php
                                echo $_SESSION['action_message'];
                                unset($_SESSION['action_message']); // Clear the message after displaying
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Component -->
        <footer class="footer">
            <p>&copy; 2024 CSDFE3 Group. All rights reserved.</p>
        </footer>
    </div>

    <!-- Download Modal -->
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadModalLabel">Download File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./upload_actions.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="passphrase" class="form-label">Passphrase</label>
                            <input type="password" class="form-control" id="passphrase" name="passphrase" required>
                        </div>
                        <input type="hidden" name="file_id" id="file-id" value="">
                        <input type="hidden" name="action" value="download">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var downloadModal = document.getElementById('downloadModal');
        downloadModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var fileId = button.getAttribute('data-file-id');
            var fileIdInput = downloadModal.querySelector('#file-id');
            console.log('File ID:', fileId); // Check if fileId is correctly fetched
            fileIdInput.value = fileId; // Set the value of file-id input
            console.log('File ID Input:', fileIdInput.value); // Check if fileIdInput.value is correctly set
        });
    </script>

</body>

</html>

<?php $conn->close(); ?>
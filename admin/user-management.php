<?php
// Start session
session_start();

// Enable error reporting
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

// Fetch all users from the database
$sql = "SELECT id, first_name, last_name, email, is_active FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                    <li><a class="link-light" href="./user-management.php">Users</a></li>
                    <hr>
                    <li><a class="link-light" href="#">Uploads</a></li>
                    <hr>
                    <li><a class="link-light" href="#">Profile</a></li>
                    <hr>
                </ul>
            </aside>
            <!-- Main content area -->
            <div class="content">
                <div>
                    <h2>User Management</h2>
                    <table class="table table-bordered table-dark table-hover">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td>
                                            <form action="../php/user_actions.php" method="post" style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="action" value="reset_password" class="btn btn-warning btn-sm">Reset</button>
                                                <?php if ($row['is_active']) { ?>
                                                    <button type="submit" name="action" value="disable_user" class="btn btn-secondary btn-sm">Disable</button>
                                                <?php } else { ?>
                                                    <button type="submit" name="action" value="enable_user" class="btn btn-success btn-sm">Enable</button>
                                                <?php } ?>
                                                <button type="submit" name="action" value="delete_user" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo "<tr><td colspan='5'>No users found</td></tr>";
                            } ?>
                        </tbody>
                    </table>
                    <div class="content">
                        <?php if (isset($_SESSION['action_message'])): ?>
                            <div class="alert alert-info">
                                <?php
                                echo $_SESSION['action_message'];
                                unset($_SESSION['action_message']); // Clear the message after displaying
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
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

<?php $conn->close(); ?>


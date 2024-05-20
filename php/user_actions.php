<?php
// Start session
session_start();

// Include the database connection file
require_once 'connect_db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['email'] !== 'admin@gmail.com') {
    // Redirect to login page if not logged in or not an admin
    header("Location: ../index.php");
    exit();
}

// Retrieve the action and user ID from the form submission
$action = $_POST['action'];
$user_id = $_POST['user_id'];

if ($action === 'reset_password') {
    // Generate a new random password
    $new_password = bin2hex(random_bytes(4)); // Generates a random 8-character password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);
    $stmt->execute();
    
    // Notify the admin of the new password
    $_SESSION['action_message'] = "Password reset successful. New password: $new_password";
} elseif ($action === 'disable_user') {
    // Update the user's status to disabled in the database
    $stmt = $conn->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Notify the admin
    $_SESSION['action_message'] = "User disabled successfully.";
} elseif ($action === 'enable_user') {
    // Update the user's status to enabled in the database
    $stmt = $conn->prepare("UPDATE users SET is_active = 1 WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Notify the admin
    $_SESSION['action_message'] = "User enabled successfully.";
} elseif ($action === 'delete_user') {
    // Delete the user from the database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Notify the admin
    $_SESSION['action_message'] = "User deleted successfully.";
} else {
    $_SESSION['action_message'] = "Invalid action.";
}

// Redirect back to the admin dashboard
header("Location: ../admin/user-management.php");
exit();
?>

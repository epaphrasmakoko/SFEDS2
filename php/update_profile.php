<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: ../index.php");
    exit();
}

// Include the database connection file
require_once 'connect_db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_SESSION['email'];
    $currentPassword = $conn->real_escape_string($_POST['currentPassword']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

    // Retrieve the current hashed password from the database
    $sql = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashedPasswordFromDb);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (!password_verify($currentPassword, $hashedPasswordFromDb)) {
        $_SESSION['update_error'] = "Current password is incorrect.";
        header("Location: ../profile.php");
        exit();
    }

    // Validate passwords
    if ($password !== $confirmPassword) {
        $_SESSION['update_error'] = "Passwords do not match.";
        header("Location: ../profile.php");
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update user details in the database
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        // Update successful, set session variable
        $_SESSION['update_successful'] = true;
        header("Location: ../profile.php");
        exit();
    } else {
        // Update failed, show error message
        $_SESSION['update_error'] = "An error occurred. Please try again.";
        header("Location: ../profile.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect back to profile.php if accessed directly
    header("Location: ../profile.php");
    exit();
}

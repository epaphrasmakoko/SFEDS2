<?php
// Start session
session_start();

// Include the database connection file
require_once 'connect_db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows == 1) {
        // User exists, fetch the user data
        $user = $result->fetch_assoc();

        // Check if the user is active
        if ($user['is_active'] == 0) {
            // User is disabled
            $_SESSION['login_error'] = "Your account has been disabled. Please contact the administrator.";
            header("Location: ../index.php");
            exit();
        }

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $user['first_name']; // Store first name in session

            // Redirect based on user role
            if ($email === 'admin@gmail.com') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../dashboard.php");
            }
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid email or password. Please try again.";
            header("Location: ../index.php");
            exit();
        }
    } else {
        // User does not exist
        $_SESSION['login_error'] = "Invalid email or password. Please try again.";
        header("Location: ../index.php");
        exit();
    }
} else {
    // Redirect back to index.php if accessed directly
    header("Location: ../index.php");
    exit();
}
?>

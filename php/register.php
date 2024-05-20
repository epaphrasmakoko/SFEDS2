<?php
// Start session
session_start();

// Include the database connection file
require_once 'connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    // Basic validation
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user into database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone_number, email, password) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    // Bind parameters
    $stmt->bind_param("sssss", $firstName, $lastName, $phoneNumber, $email, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful, set session variable
        $_SESSION['registration_successful'] = true;
        
        // Close statement and connection
        $stmt->close();
        $conn->close();
        
        // Redirect to login page
        echo "<script>window.location.href = '../index.php';</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection in case of error
    $stmt->close();
    $conn->close();
}
?>

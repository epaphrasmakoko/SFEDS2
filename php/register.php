<?php
// Start session
session_start();

// Include the database connection file
require_once 'connect_db.php';

// Function to validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate phone number (example: validating a specific format)
function validatePhoneNumber($phoneNumber) {
    return preg_match('/^255\d{9}$/', $phoneNumber);
}

// Function to validate password strength
function validatePassword($password) {
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/';
    return preg_match($pattern, $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    // Basic validation
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    if (!validateEmail($email)) {
        echo "Invalid email address.";
        exit;
    }

    if (!validatePhoneNumber($phoneNumber)) {
        echo "Invalid phone number. Format should be 255XXXXXXXXX.";
        exit;
    }

    if (!validatePassword($password)) {
        echo "Password should be at least 8 characters long and contain uppercase and lowercase letters, numbers, and special characters.";
        exit;
    }

    // Check if email or phone number already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email already registered.";
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

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

        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);

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

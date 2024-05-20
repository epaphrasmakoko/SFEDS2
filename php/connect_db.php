<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Your XAMPP MySQL password, usually empty by default
$dbname = "sfeds"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

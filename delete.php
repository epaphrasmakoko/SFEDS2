<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

// Include database connection
include './php/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileId = $_POST['file_id'];
    $passphrase = $_POST['passphrase'];

    // Fetch file details from the database
    $sql = "SELECT file_path, passphrase FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error_message'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        $_SESSION['error_message'] = 'Execute failed: ' . htmlspecialchars($stmt->error);
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }
    if ($result->num_rows == 0) {
        $_SESSION['error_message'] = 'File not found.';
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }

    $file = $result->fetch_assoc();
    $stmt->close();

    // Check if the provided passphrase matches the one in the database
    if ($file['passphrase'] !== $passphrase) {
        $_SESSION['error_message'] = 'Incorrect passphrase.';
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }

    // Delete the file
    $filePath = realpath($file['file_path']);
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Delete file record from the database
    $sql = "DELETE FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error_message'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = 'File deleted successfully.';
    header("Location: ./dashboard/user-pictures.php");
    exit();
} else {
    $_SESSION['error_message'] = 'Invalid request.';
    header("Location: ./dashboard/user-pictures.php");
    exit();
}
?>

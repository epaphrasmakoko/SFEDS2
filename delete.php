<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include './php/connect_db.php';

    $fileId = $_POST['file_id'];
    $passphrase = $_POST['passphrase'];

    // Fetch file details from database
    $sql = "SELECT file_name, file_path, passphrase FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($conn->error)]));
    }
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        die(json_encode(['success' => false, 'message' => 'Execute failed: ' . htmlspecialchars($stmt->error)]));
    }
    if ($result->num_rows == 0) {
        die(json_encode(['success' => false, 'message' => 'File not found.']));
    }

    $file = $result->fetch_assoc();
    $stmt->close();

    // Check if the provided passphrase matches the one in the database
    if ($file['passphrase'] !== $passphrase) {
        echo json_encode(['success' => false, 'message' => 'Incorrect passphrase.']);
        exit();
    }

    // Delete the file from the filesystem
    if (file_exists($file['file_path'])) {
        unlink($file['file_path']);
    }

    // Delete the file record from the database
    $sql = "DELETE FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($conn->error)]));
    }
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true]);
} else {
    header("Location: ../dashboard.php");
    exit();
}
?>

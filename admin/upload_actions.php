<?php
// Start session
session_start();

// Include the database connection file
require_once '../php/connect_db.php';

// Debug: Log the incoming POST data
error_log("POST data: " . print_r($_POST, true));

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['email'] !== 'admin@gmail.com') {
    // Redirect to login page if not logged in or not an admin
    header("Location: ../index.php");
    exit();
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileId = $_POST['file_id'];
    $action = $_POST['action'];
    $passphrase = $_POST['passphrase'] ?? '';

    // Check if file_id is set
    if (empty($fileId)) {
        $_SESSION['action_message'] = 'File ID is missing.';
        header("Location: ./admin_uploads.php");
        exit();
    }

    // Fetch file details from the database
    $sql = "SELECT file_name, file_path FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['action_message'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
        header("Location: ./admin_uploads.php");
        exit();
    }
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        $_SESSION['action_message'] = 'Execute failed: ' . htmlspecialchars($stmt->error);
        header("Location: ./admin_uploads.php");
        exit();
    }
    if ($result->num_rows == 0) {
        $_SESSION['action_message'] = 'File not found.';
        header("Location: ./admin_uploads.php");
        exit();
    }

    $file = $result->fetch_assoc();
    $stmt->close();

    $filePath = $file['file_path'];
    $fileName = $file['file_name'];

    // Debug: Log file details
    error_log("File path from database: $filePath");
    error_log("File name from database: $fileName");

    if ($action === 'download') {
        // Decrypt and download the file
        try {
            $decryptedFilePath = decryptFile($filePath, $passphrase);

            // Debug: Check if decrypted file path is correct
            error_log("Decrypted file path: $decryptedFilePath");

            if (file_exists($decryptedFilePath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($decryptedFilePath));
                readfile($decryptedFilePath);

                // Clean up: delete the decrypted file after sending it to the user
                unlink($decryptedFilePath);
                exit();
            } else {
                // Debug: Log the missing file path
                error_log("Error: Decrypted file does not exist. Path: $decryptedFilePath");
                $_SESSION['action_message'] = 'Error: Decrypted file does not exist. Path: ' . $decryptedFilePath;
                header("Location: ./admin_uploads.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['action_message'] = 'Error decrypting file: ' . $e->getMessage();
            header("Location: ./admin_uploads.php");
            exit();
        }
    } elseif ($action === 'delete') {
        // Delete the file from the filesystem and database
        if (unlink($filePath)) {
            $sql = "DELETE FROM files WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $_SESSION['action_message'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
                header("Location: ./admin_uploads.php");
                exit();
            }
            $stmt->bind_param("i", $fileId);
            if ($stmt->execute()) {
                $_SESSION['action_message'] = 'File deleted successfully.';
            } else {
                $_SESSION['action_message'] = 'Error deleting file from database.';
            }
            $stmt->close();
        } else {
            $_SESSION['action_message'] = 'Error deleting file from filesystem. Path: ' . $filePath;
        }
        header("Location: ./admin_uploads.php");
        exit();
    }
} else {
    header("Location: ./admin_uploads.php");
    exit();
}

function decryptFile($encryptedFilePath, $passphrase) {
    $decryptedFilePath = str_replace('.enc', '', $encryptedFilePath);
    $absoluteEncryptedFilePath = escapeshellarg($encryptedFilePath);
    $absoluteDecryptedFilePath = escapeshellarg($decryptedFilePath);
    $passphrase = escapeshellarg($passphrase);
    $command = "openssl enc -d -aes-256-cbc -in $absoluteEncryptedFilePath -out $absoluteDecryptedFilePath -k $passphrase 2>&1";
    
    // Debug: Log the command being executed
    error_log("Executing command: $command");
    
    exec($command, $output, $returnVar);
    if ($returnVar !== 0) {
        throw new Exception("Error decrypting file: " . implode("\n", $output) . ". Command: " . $command);
    }
    return $decryptedFilePath;
}
?>

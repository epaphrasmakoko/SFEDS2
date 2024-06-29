<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

// Include database connection
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userEmail = $_SESSION['email'];
    $description = $_POST['description'] ?? ''; // Default to an empty string if not set
    $passphrase = $_POST['passphrase'];

    $targetDir = "../uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Valid file types for encryption
    $validTypes = ["pdf", "png", "jpg", "jpeg", "mp3", "mp4"];

    // Check if file type is valid
    if (!in_array($fileType, $validTypes)) {
        $_SESSION['upload_error'] = "Sorry, only PDF, PNG, JPEG, MP3 and MP4 files are allowed for now.";
        header("Location: ../upload.php");
        exit();
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        try {
            // Encrypt the file
            $encryptedFilePath = encryptFile($targetFile, $passphrase);

            // Delete the original file after successful encryption
            if (file_exists($encryptedFilePath)) {
                unlink($targetFile);
            } else {
                throw new Exception("Error encrypting file.");
            }

            // Save file metadata to the database
            $sql = "INSERT INTO files (user_email, file_name, file_path, description, passphrase, file_type) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssss", $userEmail, $fileName, $encryptedFilePath, $description, $passphrase, $fileType);
                if ($stmt->execute()) {
                    $_SESSION['upload_success'] = "The file has been uploaded and encrypted.";
                    header("Location: ../upload.php");
                    exit();
                } else {
                    throw new Exception("Error uploading file metadata.");
                }
                $stmt->close();
            } else {
                throw new Exception("Database error.");
            }
        } catch (Exception $e) {
            $_SESSION['upload_error'] = $e->getMessage();
            header("Location: ../upload.php");
            exit();
        }
    } else {
        $_SESSION['upload_error'] = "Error uploading file.";
        header("Location: ../upload.php");
        exit();
    }
} else {
    header("Location: ../upload.php");
    exit();
}

function encryptFile($filePath, $passphrase) {
    $encryptedFilePath = $filePath . '.enc';
    $absoluteFilePath = realpath($filePath);
    $command = "openssl enc -aes-256-cbc -salt -in \"" . $absoluteFilePath . "\" -out \"" . $encryptedFilePath . "\" -pass pass:" . escapeshellarg($passphrase) . " 2>&1";
    exec($command, $output, $returnVar);
    if ($returnVar !== 0) {
        throw new Exception("Error encrypting file: " . implode("\n", $output));
    }
    return realpath($encryptedFilePath);
}
?>

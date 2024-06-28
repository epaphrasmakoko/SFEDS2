<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    include './php/connect_db.php';

    $fileId = $_POST['file_id'];
    $passphrase = $_POST['passphrase'];

    // Fetch file details from the database
    $sql = "SELECT file_name, file_path, passphrase FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
    if ($result->num_rows == 0) {
        die('File not found.');
    }

    $file = $result->fetch_assoc();
    $stmt->close();

    $encryptedFilePath = $file['file_path'];
    $originalFileName = $file['file_name'];

    // Check if the provided passphrase matches the one in the database
    if ($file['passphrase'] !== $passphrase) {
        die('Incorrect passphrase.');
    }

    // Decrypt the file
    try {
        $decryptedFilePath = decryptFile($encryptedFilePath, $passphrase);
    } catch (Exception $e) {
        die('Error decrypting file: ' . $e->getMessage());
    }

    // Check if the decrypted file exists and its size
    if (file_exists($decryptedFilePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($originalFileName) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($decryptedFilePath));
        readfile($decryptedFilePath);

        // Clean up: delete the decrypted file after sending it to the user
        unlink($decryptedFilePath);
        exit();
    } else {
        die('Decrypted file not found.');
    }
} else {
    header("Location: ../index.php");
    exit();
}

function decryptFile($encryptedFilePath, $passphrase) {
    $decryptedFilePath = str_replace('.enc', '', $encryptedFilePath);
    $command = "openssl enc -d -aes-256-cbc -in $encryptedFilePath -out $decryptedFilePath -k $passphrase 2>&1";
    exec($command, $output, $returnVar);
    if ($returnVar !== 0) {
        throw new Exception("Error decrypting file: " . implode("\n", $output));
    }
    return $decryptedFilePath;
}
?>

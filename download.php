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

    $encryptedFilePath = $file['file_path'];
    $originalFileName = $file['file_name'];

    // Debug: Check if the encrypted file path is correct
    $absoluteEncryptedFilePath = realpath($encryptedFilePath);
    if ($absoluteEncryptedFilePath === false) {
        $_SESSION['error_message'] = 'Error: Encrypted file does not exist at path: ' . $encryptedFilePath;
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }

    // Check if the provided passphrase matches the one in the database
    if ($file['passphrase'] !== $passphrase) {
        $_SESSION['error_message'] = 'Incorrect passphrase.';
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }

    // Decrypt the file
    try {
        $decryptedFilePath = decryptFile($absoluteEncryptedFilePath, $passphrase);
    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Error decrypting file: ' . $e->getMessage();
        header("Location: ./dashboard/user-pictures.php");
        exit();
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
        $_SESSION['error_message'] = 'Error: Decrypted file does not exist.';
        header("Location: ./dashboard/user-pictures.php");
        exit();
    }
} else {
    header("Location: ../dashboard.php");
    exit();
}

function decryptFile($encryptedFilePath, $passphrase) {
    $decryptedFilePath = str_replace('.enc', '', $encryptedFilePath);
    $absoluteEncryptedFilePath = escapeshellarg($encryptedFilePath);
    $absoluteDecryptedFilePath = escapeshellarg($decryptedFilePath);
    $passphrase = escapeshellarg($passphrase);
    $command = "openssl enc -d -aes-256-cbc -in $absoluteEncryptedFilePath -out $absoluteDecryptedFilePath -k $passphrase 2>&1";
    exec($command, $output, $returnVar);
    if ($returnVar !== 0) {
        throw new Exception("Error decrypting file: " . implode("\n", $output));
    }
    return $decryptedFilePath;
}
?>

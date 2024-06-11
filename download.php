<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'User not authenticated']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect_db.php';

    $fileId = $_POST['file_id'];
    $passphrase = $_POST['passphrase'];

    // Fetch the file metadata from the database
    $sql = "SELECT file_name, file_path, passphrase FROM files WHERE id = ? AND user_email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log('Prepare failed: ' . htmlspecialchars($conn->error), 3, '/var/log/myapp/error.log');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Prepare failed']);
        exit();
    }
    $stmt->bind_param("is", $fileId, $_SESSION['email']);
    $stmt->execute();
    $stmt->bind_result($fileName, $filePath, $storedPassphrase);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if (empty($fileName) || empty($filePath) || empty($storedPassphrase)) {
        error_log('File metadata fetch failed or empty.', 3, '/var/log/myapp/error.log');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'File metadata fetch failed']);
        exit();
    }

    if ($passphrase === $storedPassphrase) {
        // Decrypt the file
        $decryptedFilePath = decryptFile($filePath, $passphrase);

        if ($decryptedFilePath) {
            if (file_exists($decryptedFilePath) && filesize($decryptedFilePath) > 0) {
                // Force download the file
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($decryptedFilePath));
                readfile($decryptedFilePath);

                // Optionally delete the decrypted file after download
                unlink($decryptedFilePath);
                exit();
            } else {
                error_log('Decrypted file does not exist or is empty.', 3, '/var/log/myapp/error.log');
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Decrypted file does not exist or is empty']);
                exit();
            }
        } else {
            error_log('File decryption failed.', 3, '/var/log/myapp/error.log');
            header('Content-Type: application/json');
            echo json_encode(['message' => 'File decryption failed']);
            exit();
        }
    } else {
        error_log('Invalid passphrase.', 3, '/var/log/myapp/error.log');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Invalid passphrase']);
        exit();
    }
}

function decryptFile($filePath, $key) {
    $encryptedDataWithIv = file_get_contents($filePath);
    if ($encryptedDataWithIv === false) {
        error_log('Failed to read encrypted file.', 3, '/var/log/myapp/error.log');
        return false;
    }

    $ivLength = openssl_cipher_iv_length('AES-128-CBC');
    $iv = substr($encryptedDataWithIv, 0, $ivLength);
    $encryptedData = substr($encryptedDataWithIv, $ivLength);

    $decryptedData = openssl_decrypt($encryptedData, 'AES-128-CBC', $key, 0, $iv);
    if ($decryptedData === false) {
        error_log('Decryption failed.', 3, '/var/log/myapp/error.log');
        return false;
    }

    $decryptedFilePath = $filePath . '.decrypted';
    if (file_put_contents($decryptedFilePath, $decryptedData) === false) {
        error_log('Failed to write decrypted file.', 3, '/var/log/myapp/error.log');
        return false;
    }
    return $decryptedFilePath;
}
?>

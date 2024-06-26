<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

// Include database connection
include 'connect_db.php';

// Get file ID and passphrase from POST request
$fileId = $_POST['file_id'];
$passphrase = $_POST['passphrase'];

// Fetch the file info from the database
$sql = "SELECT file_path, file_name FROM files WHERE id = ? AND user_email = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("is", $fileId, $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

if ($row = $result->fetch_assoc()) {
    $encryptedFilePath = $row['file_path'];
    $fileName = $row['file_name'];
    $stmt->close();

    // Decrypt the file
    $decryptedFile = decryptFile($encryptedFilePath, $passphrase);
    if ($decryptedFile === false) {
        echo json_encode(["message" => "Incorrect passphrase."]);
        exit();
    }

    // Serve the decrypted file for download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($decryptedFile));
    echo $decryptedFile;
} else {
    echo json_encode(["message" => "File not found."]);
}
$stmt->close();

function decryptFile($filePath, $passphrase) {
    $data = file_get_contents($filePath);
    $ivLength = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $ivLength);
    $encryptedData = substr($data, $ivLength);
    $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $passphrase, 0, $iv);
    return $decryptedData;
}
?>

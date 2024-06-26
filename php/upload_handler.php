<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    include 'connect_db.php';

    $userEmail = $_SESSION['email'];
    $description = $_POST['description'];
    $passphrase = $_POST['passphrase'];

    $targetDir = "../uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFile = $targetDir . $fileName;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Valid file types for encryption
    $validTypes = ["pdf", "png", "jpg", "jpeg"];

    // Check if file type is valid
    if (!in_array($fileType, $validTypes)) {
        $_SESSION['upload_error'] = "Sorry, only PDF, PNG, JPEG files are allowed for now.";
        header("Location: ../upload.php");
        exit();
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Encrypt the file
        $encryptedFilePath = encryptFile($targetFile, $passphrase);

        // Delete the original file after encryption
        if ($encryptedFilePath) {
            unlink($targetFile);
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
                $_SESSION['upload_error'] = "Error1 uploading file.";
                header("Location: ../upload.php");
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['upload_error'] = "Database error.";
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
    $data = file_get_contents($filePath);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $passphrase, 0, $iv);
    $encryptedFilePath = $filePath . '.enc';
    file_put_contents($encryptedFilePath, $iv . $encryptedData);
    return $encryptedFilePath;
}
?>

<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect_db.php';

    $userEmail = $_SESSION['email'];
    $description = $_POST['description'];
    $encryptionMethod = $_POST['uploadType'];
    $passphrase = $_POST['passphrase'];

    $targetDir = "../uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFile = $targetDir . $fileName;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Debugging: print file type
    echo "File type: " . $fileType;

    // Check if file type is valid
    $validTypes = ["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx", "txt", "zip", "rar", "csv", "xls", "xlsx", "ppt", "pptx", "mp3", "wav", "ogg", "mp4", "mov", "avi"];
    if (!in_array($fileType, $validTypes)) {
        echo "Sorry, only certain file types are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            // Encrypt the file
            $encryptedFilePath = encryptFile($targetFile, $passphrase);

            // Save file metadata to the database
            $sql = "INSERT INTO files (user_email, file_name, file_path, encryption_method, passphrase, file_type) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssss", $userEmail, $fileName, $encryptedFilePath, $encryptionMethod, $passphrase, $fileType);
                if ($stmt->execute()) {
                    echo "The file has been uploaded and encrypted.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $conn->close();
}

function encryptFile($filePath, $key) {
    $data = file_get_contents($filePath);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CBC'));
    $encryptedData = openssl_encrypt($data, 'AES-128-CBC', $key, 0, $iv);
    $encryptedDataWithIv = $iv . $encryptedData;
    file_put_contents($filePath, $encryptedDataWithIv);
    return $filePath;
}
?>

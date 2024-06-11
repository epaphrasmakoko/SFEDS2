<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./index.php");
    exit();
}

// Include database connection
include './php/connect_db.php';

// Get the logged-in user's email
$userEmail = $_SESSION['email'];

// Fetch the user's files from the database
$sql = "SELECT id, file_name FROM files WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download File</title>
    <link href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/uploads.css">
</head>
<body>
    <div class="container">
        <h2>Download File</h2>
        <form action="download.php" method="post">
            <div class="mb-3">
                <label for="file_id" class="form-label">Select File</label>
                <select class="form-control" id="file_id" name="file_id" required>
                    <?php foreach ($files as $file): ?>
                        <option value="<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['file_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="passphrase" class="form-label">Passphrase</label>
                <input type="password" class="form-control" id="passphrase" name="passphrase" required>
            </div>
            <button type="submit" class="btn btn-primary">Download</button>
        </form>
    </div>
    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

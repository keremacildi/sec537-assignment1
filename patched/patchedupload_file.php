<?php
// Set the default timezone
date_default_timezone_set('Europe/Moscow');

// Directory to store uploaded files
$uploadDir = "uploads/";

// Allowed MIME types and file extensions
$allowedMimeTypes = ["image/jpeg", "image/png", "text/plain"];     // using whitelist approach not blacklist approach
$allowedExtensions = ["jpg", "jpeg", "png", "txt"];

// Create the upload directory if it does not exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Function to validate the file upload
function validateFileUpload($file, $allowedMimeTypes, $allowedExtensions) {     //validating the files content type and extension
    // Use finfo to determine the MIME type of the file
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Check MIME type and file extension
    if (!in_array($fileType, $allowedMimeTypes) || !in_array($fileExtension, $allowedExtensions)) {
        return false;
    }

    return true;
}

// Check if the form is submitted
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];

        // Validate the uploaded file
        if (validateFileUpload($file, $allowedMimeTypes, $allowedExtensions)) {
            // Generate a unique file name to prevent overwriting
            $uniqueFileName = uniqid() . "-" . basename($file['name']);
            $targetFilePath = $uploadDir . $uniqueFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $message = "File uploaded successfully: " . htmlspecialchars($uniqueFileName);
            } else {
                $message = "Failed to upload file.";
            }
        } else {
            $message = "Invalid file type or extension.";
        }
    } else {
        $message = "No file selected for upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Secure File Upload</h1>
        <p>Upload files securely to the server</p>
    </div>
    <div class="container">
        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, 'Invalid') !== false || strpos($message, 'Failed') !== false ? 'error' : ''; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="file">Select a file to upload:</label><br><br>
            <input type="file" name="file" id="file" required><br><br>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>

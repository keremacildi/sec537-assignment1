<?php
// Set the default timezone
date_default_timezone_set('Europe/Moscow');

// Directory to store uploaded files
$uploadDir = "uploads/";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];

        // Get the original file name
        $fileName = $file['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Flawed validation 
        if (1) {
            // Create the target file path
            $targetFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $message = "File uploaded successfully: " . htmlspecialchars($fileName);
            } else {
                $message = "Failed to upload file.";
            }
        } 
    } else {
        $message = "No file selected for upload.";
    }
}

// Create the upload directory if it does not exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
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
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>File Upload</h1>
        <p>Upload files to the server (intentionally vulnerable to CWE-434)</p>
    </div>
    <div class="container">
        <?php if (!empty($message)): ?>
            <div class="message">
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

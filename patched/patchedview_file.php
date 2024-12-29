<?php
// Set the default timezone
date_default_timezone_set('Europe/Moscow');

// Function to safely read a file based on user input
function readFileContents($filePath) {
    // Dynamically set the base directory relative to the script location
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'files';

    // Ensure the base directory exists
    if (!is_dir($baseDir)) {
        die("Base directory does not exist.");
    }

    // Get the real path of the base directory
    $realBaseDir = realpath($baseDir);
    $realFilePath = realpath($realBaseDir . DIRECTORY_SEPARATOR . $filePath);

    // Validate the file path to ensure it stays within the base directory
    if ($realFilePath === false || strpos($realFilePath, $realBaseDir) !== 0) {
        die("Access denied. Invalid file path.");
    }

    // Check if the file exists
    if (!file_exists($realFilePath)) {
        die("File does not exist.");
    }

    // Read and return the file contents
    return file_get_contents($realFilePath);
}

$fileContent = "";
if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // Restrict input to file name only
    $fileContent = readFileContents($file);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Viewer</title>
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
        pre {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: 10px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>File Viewer</h1>
        <p>Safely view file contents</p>
    </div>
    <div class="container">
        <form method="GET" action="">
            <label for="file">File Name:</label>
            <input type="text" id="file" name="file" placeholder="Enter file name (e.g., test.txt)" required>
            <button type="submit">View File</button>
        </form>
        <?php if (!empty($fileContent)): ?>
            <h3>File Contents:</h3>
            <pre><?= htmlspecialchars($fileContent) ?></pre>
        <?php endif; ?>
    </div>
</body>
</html>

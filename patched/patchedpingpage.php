<?php
// Set the default timezone
date_default_timezone_set('Europe/Moscow');

// Function to execute a ping command securely
function executePing($host) {
    // Sanitize the user input to prevent command injection
    $sanitizedHost = escapeshellarg($host);
    
    // Construct the ping command with sanitized input
    $command = "ping -n 3 " . $sanitizedHost;
    
    // Execute the sanitized command
    return shell_exec($command);
}

// Check if the user has submitted a host to ping
$pingResult = "";
if (isset($_POST['host'])) {
    $host = $_POST['host'];

    // Validate the input to ensure it is a valid hostname or IP address
    if (filter_var($host, FILTER_VALIDATE_IP) || preg_match('/^[a-zA-Z0-9.-]+$/', $host)) {
        $pingResult = executePing($host);
    } else {
        $pingResult = "Invalid host provided. Please enter a valid IP address or hostname.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ping Utility</title>
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
        .header h1 {
            margin: 0;
            font-size: 2em;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
            font-size: 0.8em;
        }
        .form-group {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 1em;
            width: 70%;
        }
        button {
            padding: 10px;
            font-size: 1em;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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
        <h1>Ping Utility</h1>
        <p>Check the connectivity to a host</p>
    </div>
    <div class="container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="host">Host:</label>
                <input type="text" id="host" name="host" placeholder="Enter host or IP address" required>
            </div>
            <button type="submit">Ping</button>
        </form>

        <?php if (!empty($pingResult)): ?>
            <h3>Ping Results:</h3>
            <pre><?= htmlspecialchars($pingResult); ?></pre>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; <?= date('Y'); ?> Network Tools | Powered by PHP
    </div>
</body>
</html>

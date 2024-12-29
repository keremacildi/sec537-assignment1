<?php
// Set the default timezone
date_default_timezone_set('Europe/Moscow');

// Function to fetch RSS feed (vulnerable to SSRF with blacklist-based filtering)
function fetchRSS($url) {
    // Blacklist certain domains (vulnerable to bypass) since blacklist based filtering can be bypassed by using alternative domain names
    $blacklist = [
        "127.0.0.1",
        "localhost",
        "0.0.0.0"
    ];

    // Parse the hostname from the URL
    $parsedUrl = parse_url($url);
    $host = $parsedUrl['host'] ?? '';

    // Check if the hostname is blacklisted
    foreach ($blacklist as $blocked) {
        if (strpos($host, $blocked) !== false) {
            die("Access to this URL is restricted.");
        }
    }

    // Fetch the RSS feed
    $rssContent = @file_get_contents($url);
    if ($rssContent === false) {
        die("Failed to fetch RSS feed. Check the URL.");
    }

    return $rssContent;
}

$rssContent = "";
if (isset($_POST['rss_url'])) {
    $rssUrl = $_POST['rss_url'];
    $rssContent = fetchRSS($rssUrl);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch RSS</title>
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
        <h1>Fetch RSS</h1>
        <p>Provide an RSS feed URL to fetch its contents</p>
    </div>
    <div class="container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="rss_url">RSS Feed URL:</label>
                <input type="text" id="rss_url" name="rss_url" placeholder="Enter RSS feed URL" required>
            </div>
            <button type="submit">Fetch RSS</button>
        </form>

        <?php if (!empty($rssContent)): ?>
            <h3>RSS Feed Contents:</h3>
            <pre><?= htmlspecialchars($rssContent) ?></pre>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; <?= date('Y'); ?> RSS Fetcher | Powered by PHP
    </div>
</body>
</html>

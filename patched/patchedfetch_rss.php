<?php
// Patched version of fetch_rss.php to securely fetch and parse RSS feeds

define('ALLOWED_DOMAINS', [ //whitelist based approach to prevent SSRF
    'tass.com',
    'rt.com',
    'sputniknews.com'
]);

/**
 * Validate the RSS feed URL to ensure it belongs to allowed domains.
 *
 * @param string $url
 * @return bool
 */
function validateUrl($url) {
    $parsedUrl = parse_url($url);
    if (!$parsedUrl || !isset($parsedUrl['host'])) {
        return false;
    }

    $host = $parsedUrl['host'];
    foreach (ALLOWED_DOMAINS as $allowedDomain) {
        if (strpos($host, $allowedDomain) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Securely fetch and parse the RSS feed.
 *
 * @param string $url
 * @return SimpleXMLElement|false
 */
function fetchRSS($url) {
    if (!validateUrl($url)) {
        return false;
    }

    // Fetch RSS feed using file_get_contents
    $data = @file_get_contents($url);
    if ($data === false) {
        return false;
    }

    // Parse XML content safely
    libxml_use_internal_errors(true);
    $rss = simplexml_load_string($data);
    if (!$rss) {
        return false;
    }

    return $rss;
}

$rss = false;
$errorMessage = "";

// Handle user input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rss_url'])) {
    $rssFeedUrl = trim($_POST['rss_url']);
    $rss = fetchRSS($rssFeedUrl);

    if (!$rss) {
        $errorMessage = "Failed to load RSS feed. Please ensure the URL is valid and from an allowed domain.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS Feed Viewer</title>
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
        .news-item {
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .news-item:last-child {
            border-bottom: none;
        }
        .news-title {
            font-size: 1.2em;
            margin: 0;
            color: #007bff;
            text-decoration: none;
        }
        .news-title:hover {
            text-decoration: underline;
        }
        .news-description {
            font-size: 0.9em;
            color: #555;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
            font-size: 0.8em;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-container input[type="text"] {
            padding: 10px;
            font-size: 1em;
            width: 70%;
        }
        .form-container button {
            padding: 10px;
            font-size: 1em;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RSS Feed Viewer</h1>
        <p>Stay updated with the latest news</p>
    </div>
    <div class="container">
        <div class="form-container">
            <form method="POST" action="">
                <input type="text" name="rss_url" placeholder="Enter RSS Feed URL" required>
                <button type="submit">Fetch RSS</button>
            </form>
        </div>
        <?php if ($errorMessage): ?>
            <p class="error"><?= htmlspecialchars($errorMessage); ?></p>
        <?php elseif ($rss): ?>
            <h2><?= htmlspecialchars($rss->channel->title) ?></h2>
            <p><?= htmlspecialchars($rss->channel->description) ?></p>
            <?php foreach ($rss->channel->item as $item): ?>
                <div class="news-item">
                    <h3 class="news-title">
                        <a href="<?= htmlspecialchars($item->link) ?>" target="_blank">
                            <?= htmlspecialchars($item->title) ?>
                        </a>
                    </h3>
                    <p class="news-description"> <?= htmlspecialchars($item->description) ?></p>
                    <small>Published on: <?= htmlspecialchars($item->pubDate) ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; <?= date('Y'); ?> RSS Feed Viewer | Powered by PHP
    </div>
</body>
</html>

<?php
// Fetch RSS feed using file_get_contents or cURL
function fetchRSS($url) {
    // Using file_get_contents as a fallback
    $data = file_get_contents($url);

    if ($data === false) {
        return false;
    }
    return simplexml_load_string($data);
}

// RSS Feed URL
$rssFeedUrl = "https://www.themoscowtimes.com/rss/news"; // Replace with your chosen RSS feed

// Fetch and parse the RSS feed
$rss = fetchRSS($rssFeedUrl);

if (!$rss) {
    $newsItems = [];
    $errorMessage = "Failed to load RSS feed. Please try again later.";
} else {
    $newsItems = $rss->channel->item;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Russian News</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Russian News</h1>
        <p>Stay updated with the latest news</p>
    </div>
    <div class="container">
        <?php if (!empty($errorMessage)): ?>
            <p style="color: red; text-align: center;"><?= htmlspecialchars($errorMessage); ?></p>
        <?php else: ?>
            <?php foreach ($newsItems as $item): ?>
                <div class="news-item">
                    <h3 class="news-title">
                        <a href="<?= htmlspecialchars($item->link); ?>" target="_blank">
                            <?= htmlspecialchars($item->title); ?>
                        </a>
                    </h3>
                    <p class="news-description"><?= htmlspecialchars($item->description); ?></p>
                    <small>Published on: <?= date("Y-m-d H:i", strtotime($item->pubDate)); ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; <?= date('Y'); ?> Russian News Website | Powered by PHP
    </div>
</body>
</html>

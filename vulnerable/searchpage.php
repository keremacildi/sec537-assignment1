<?php
// Fetch RSS feed using file_get_contents
function fetchRSS($url) {
    $data = file_get_contents($url);
    if ($data === false) {
        return false;
    }
    return simplexml_load_string($data);
}

// RSS Feed URL
$rssFeedUrl = "https://www.themoscowtimes.com/rss/news";

// Fetch and parse the RSS feed
$rss = fetchRSS($rssFeedUrl);

if (!$rss) {
    $newsItems = [];
    $errorMessage = "Failed to load RSS feed. Please try again later.";
} else {
    $newsItems = $rss->channel->item;
}

// Process search query
$searchResults = [];
if (isset($_GET['query']) && $rss) {
    $query = strtolower(trim($_GET['query'])); // user input is taken directly without sanitizing it 
    foreach ($newsItems as $item) {                            // which makes this page vulnerable
        $title = strtolower((string) $item->title);
        $description = strtolower((string) $item->description);

        if (strpos($title, $query) !== false || strpos($description, $query) !== false) {
            $searchResults[] = $item;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search News</title>
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
        .search-box {
            margin-bottom: 20px;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Search News</h1>
        <p>Find articles from the latest news feed</p>
    </div>
    <div class="container">
        <div class="search-box">
            <form method="GET" action="">
                <input type="text" name="query" placeholder="Search news..." value="<?= $_GET['query'] ?? '' ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <?php if (isset($errorMessage)): ?>
            <p style="color: red; text-align: center;"> <?= $errorMessage; ?></p>
        <?php elseif (!empty($searchResults)): ?>
            <h2>Search Results:</h2>
            <?php foreach ($searchResults as $item): ?>
                <div class="news-item">
                    <h3 class="news-title">
                        <a href="<?= $item->link; ?>" target="_blank">
                            <?= $item->title; ?>
                        </a>
                    </h3>
                    <p class="news-description"> <?= $item->description; ?></p>
                    <small>Published on: <?= date("Y-m-d H:i", strtotime($item->pubDate)); ?></small>
                </div>
            <?php endforeach; ?>
        <?php elseif (isset($_GET['query'])): ?>
            <p>No results found for "<?= $_GET['query']; ?>".</p>
        <?php else: ?>
            <p>Enter a search term to find news articles.</p>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; <?= date('Y'); ?> Search News | Powered by PHP
    </div>
</body>
</html>

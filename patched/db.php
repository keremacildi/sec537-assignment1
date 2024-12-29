<?php
// Retrieve database connection parameters from environment variables with default values
$servername = getenv('DB_HOST') ?: '127.0.0.1'; // Use 'mysql' if running MySQL in Docker
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'pass';
$dbname = getenv('DB_NAME') ?: 'cs437project';

try {
    // Create a new PDO instance for database connection
    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Uncomment the line below for debugging successful connections
    // echo "Connected successfully";
} catch (PDOException $e) {
    // Output a detailed error message and terminate the script
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>

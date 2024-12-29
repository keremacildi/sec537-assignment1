<?php 
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patched Login</title>
</head>
<body>
    <h2>Secure Login</h2>
    <form method="GET" action="patched_login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>

    <?php
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['username']) && isset($_GET['password'])) {
            $user = $_GET['username'];
            $pass = $_GET['password'];
            //blind sql injection
            // Using prepared statements ensures the query structure is precompiled, preventing SQL injection.
            // Parameters are bound securely with bindParam(), treating user input as data, not executable code.
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password', $pass);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<h2>Login successful! Welcome, " . htmlspecialchars($user) . "</h2>";
            } else {
                echo "<h2>Invalid username or password.</h2>";
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
    ?>
</body>
</html>

<?php 
include 'db.php';
?>

// SQL Injection (Bypass Login):
// Username: admin' #
// Password: anything

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable Login</title>
</head>
<body>
    
    <h2>Vulnerable Login</h2>
    <p>
        We used GET request and username and password as parameters to 
        show what passwords and usernames are entered easily in demonstration.
    </p>
    <form method="GET" action="vulnerable_login.php">
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

        // Directly embedding user input into the query allows attackers to inject malicious SQL code.
        // Lack of parameterized queries means special characters in input can alter the SQL logic.
            $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
            $stmt = $conn->query($query);

            if ($stmt->rowCount() > 0) {
                echo "<h2>Login successful! Welcome, " . htmlspecialchars($user) . "</h2>";
            } else {
                echo "<h2>Invalid username or password.</h2>";
            }
        }
    } catch (PDOException $e) {
        echo "<h3>SQL Error: " . $e->getMessage() . "</h3>";
        exit();
    }
    ?>
</body>
</html>
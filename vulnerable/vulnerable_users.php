<?php 
include 'db.php';
?>

// SQL Injection (Extract Data from dummy_data Table):
// ' UNION SELECT id, name, email FROM dummy_data#
//We used GET request and as parameters to 
//show what table has the data read are entered easily in demonstration.

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable Search Users by Role</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .search-container {
            text-align: center;
            margin: 20px;
        }
        .search-container input[type="text"] {
            padding: 5px;
            font-size: 14px;
        }
        .search-container button {
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Vulnerable Search Users by Role</h2>
    <div class="search-container">
        <form method="GET" action="vulnerable_users.php">
            <label for="role">Enter Role:</label>
            <input type="text" id="role" name="role" placeholder="user or admin" required>
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_GET['role']) && !empty($_GET['role'])) {
                    $role = $_GET['role'];
                    //union sql injection
                    // Directly embedding user input in the query allows attackers to inject malicious SQL code.
                    // Lack of prepared statements or parameterized queries leaves the database exposed to manipulation.
                    $query = "SELECT id, username, role FROM users WHERE role = '$role'";
                    $stmt = $conn->query($query);

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No users found for the role: " . htmlspecialchars($role) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Please enter a role to search.</td></tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='3'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

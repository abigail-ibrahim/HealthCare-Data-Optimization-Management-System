<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'healthcare_system');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$users_sql = "SELECT * FROM users";
$users_result = $conn->query($users_sql);

// Fetch messages
$messages_sql = "
    SELECT 
        m.id, 
        m.message, 
        m.timestamp, 
        sender.username AS sender, 
        receiver.username AS receiver 
    FROM 
        messages m
    JOIN 
        users sender ON m.sender_id = sender.id
    JOIN 
        users receiver ON m.receiver_id = receiver.id
";
$messages_result = $conn->query($messages_sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .welcome {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <p class="welcome">Welcome, <?php echo $_SESSION['username']; ?>!</p>

        <h2>All Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php
            if ($users_result->num_rows > 0) {
                while ($row = $users_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found.</td></tr>";
            }
            ?>
        </table>

        <h2>Message Flow</h2>
        <table>
            <tr>
                <th>Message ID</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Message</th>
                <th>Timestamp</th>
            </tr>
            <?php
            if ($messages_result->num_rows > 0) {
                while ($row = $messages_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['sender'] . "</td>";
                    echo "<td>" . $row['receiver'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>"; // Prevent XSS
                    echo "<td>" . $row['timestamp'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No messages found.</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="footer">
        <p>&copy; 2024 Healthcare System. All rights reserved.</p>
    </div>
</body>
</html>
<?php
$conn->close();
?>

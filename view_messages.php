<?php
$receiver = $_GET['receiver'];

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthcare_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sender, message, timestamp FROM messages WHERE receiver='$receiver' ORDER BY timestamp DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $command = escapeshellcmd("python3 rle.py decompress " . escapeshellarg($row['message']));
        $decompressed_message = shell_exec($command);

        echo "From: " . $row['sender'] . "<br>";
        echo "Message: " . $decompressed_message . "<br>";
        echo "Sent at: " . $row['timestamp'] . "<br><hr>";
    }
} else {
    echo "No messages found.";
}

$conn->close();
?>

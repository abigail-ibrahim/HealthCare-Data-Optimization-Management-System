<?php
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];

// Call Python script for compression
$command = escapeshellcmd("python3 rle.py compress " . escapeshellarg($message));
$compressed_message = shell_exec($command);

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthcare_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$compressed_message')";

if ($conn->query($sql) === TRUE) {
    echo "Message sent successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

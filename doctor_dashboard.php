<?php
session_start();

if ($_SESSION['role'] != 'doctor') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'healthcare_system');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor_id = $_SESSION['id'];
$sql = "SELECT * FROM patients WHERE assigned_doctor_id='$doctor_id'";
$result = $conn->query($sql);

echo "<h1>Doctor Dashboard</h1>";
echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";

if ($result->num_rows > 0) {
    echo "<h2>Assigned Patients</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "Patient ID: " . $row['id'] . "<br>";
        echo "Name: " . $row['name'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Phone: " . $row['phone'] . "<br><hr>";
    }
} else {
    echo "No patients assigned.";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Doctor Dashboard</h1>
</body>
</html>

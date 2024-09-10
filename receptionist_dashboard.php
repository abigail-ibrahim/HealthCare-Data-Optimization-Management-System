<?php
session_start();

if ($_SESSION['role'] != 'receptionist') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $assigned_doctor_id = $_POST['assigned_doctor_id'];

    $conn = new mysqli('localhost', 'root', '', 'healthcare_system');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO patients (name, email, phone, assigned_doctor_id) VALUES ('$name', '$email', '$phone', '$assigned_doctor_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Patient added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receptionist Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Receptionist Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <h2>Add Patient</h2>
    <form method="post" action="receptionist_dashboard.php">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Phone: <input type="text" name="phone" required><br>
        Assigned Doctor ID: <input type="text" name="assigned_doctor_id" required><br>
        <input type="submit" value="Add Patient">
    </form>
</body>
</html>

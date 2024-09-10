<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

switch ($role) {
    case 'admin':
        header("Location: admin_dashboard.php");
        break;
    case 'patient':
        header("Location: patient_dashboard.php");
        break;
    case 'nurse':
        header("Location: nurse_dashboard.php");
        break;
    case 'receptionist':
        header("Location: receptionist_dashboard.php");
        break;
    case 'doctor':
        header("Location: doctor_dashboard.php");
        break;
    case 'pharmacist':
        header("Location: pharmacist_dashboard.php");
        break;
    case 'lab_technician':
        header("Location: lab_technician_dashboard.php");
        break;
    default:
        echo "Invalid role";
        session_destroy();
        header("Location: login.php");
}
?>

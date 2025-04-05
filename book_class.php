<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Your database connection

// Get form data
$user_id = $_SESSION['user_id']; // Assuming user_id is saved in session
$class_id = $_POST['class_id'];
$date = $_POST['date'];
$time = $_POST['time'];

// Insert the booking into the database with status "Pending"
$query = "INSERT INTO bookings (user_id, class_id, date, time, status) 
          VALUES ('$user_id', '$class_id', '$date', '$time', 'Pending')";

if (mysqli_query($conn, $query)) {
    header("Location: dashboard.php?message=Booking submitted, awaiting approval.");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include database configuration
include 'config.php';

// Get the booking_id from the URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Update the personal training booking status to 'Confirmed'
    $query = "UPDATE personal_training SET status = 'Confirmed' WHERE booking_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $booking_id);
        if ($stmt->execute()) {
            header("Location: admin_personal_training.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error updating booking status.</p>";
        }
    } else {
        echo "<p style='color:red;'>Failed to prepare SQL query.</p>";
    }
} else {
    echo "<p style='color:red;'>Booking ID not specified.</p>";
}

$conn->close();
?>

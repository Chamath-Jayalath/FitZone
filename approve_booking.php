<?php
session_start();

// Only allow if the user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include DB connection
include('config.php');

// Check if booking_id is set
if (isset($_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']); // Prevent SQL injection

    // Update the booking status to 'Approved'
    $stmt = $conn->prepare("UPDATE bookings SET status = 'Approved' WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        // Redirect back to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Failed to approve booking: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request. Booking ID missing.";
}

$conn->close();
?>

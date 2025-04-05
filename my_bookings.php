<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the user's current bookings and their statuses
include 'config.php'; // Include your database connection

// Prepare the SQL query to fetch bookings for the logged-in user
$user_query = "SELECT b.booking_id, b.date, b.time, b.status
               FROM bookings b
               WHERE b.user_id = ?"; // Use the user_id from the session

$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("i", $_SESSION['user_id']); // Bind user_id from session
$user_stmt->execute();
$user_result = $user_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Current Bookings</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.html"><img src="logo.png" alt="FitZone Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="booking.php">Book a Class</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="booking-section">
    <h1>Your Current Bookings</h1>
    
    <?php if ($user_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $user_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['booking_id'] ?></td>
                        <td><?= $row['date'] ?></td>
                        <td><?= $row['time'] ?></td>
                        <td><?= $row['status'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bookings found for this user.</p>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
</footer>

</body>  
</html>

<?php
// Close the database connection
$conn->close();
?>

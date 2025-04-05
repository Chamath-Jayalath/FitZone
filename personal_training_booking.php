<?php
session_start();

// Check if the user is logged in by checking for user_id in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database configuration file
include 'config.php'; // Make sure the database connection is set up correctly

// Prepare the SQL query to fetch personal training bookings for the logged-in user
$user_query = "SELECT pt.booking_id, pt.trainer, pt.date, pt.time, pt.status
               FROM personal_training pt
               WHERE pt.user_id = ?"; // Use the user_id from the session

$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("i", $_SESSION['user_id']); // Bind user_id from session
$user_stmt->execute();
$user_result = $user_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Personal Training Bookings</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Add the correct path to your CSS file -->
</head>
<body>

<header>
    <div class="logo">
        <a href="index.html"><img src="logo.png" alt="FitZone Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="book_training.php">Book Personal Training</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="booking-section">
    <h1>Your Personal Training Bookings</h1>
    
    <?php if ($user_result->num_rows > 0): ?>
        <!-- Display personal training bookings in a table -->
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Trainer</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $user_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['booking_id'] ?></td>
                        <td><?= $row['trainer'] ?></td>
                        <td><?= $row['date'] ?></td>
                        <td><?= $row['time'] ?></td>
                        <td><?= $row['status'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No personal training bookings found for this user.</p>
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

<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include the database configuration
include 'config.php'; 

// Prepare the SQL query to fetch all personal training bookings
$query = "SELECT pt.booking_id, u.username, pt.trainer, pt.date, pt.time, pt.status
          FROM personal_training pt
          JOIN users u ON pt.user_id = u.user_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Personal Training Bookings</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Add the correct path to your CSS file -->
</head>
<body>

<header>
    <div class="logo">
        <a href="index.html"><img src="logo.png" alt="FitZone Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_personal_training.php" class="active">Manage Personal Training Bookings</a></li>
            <li><a href="admin_inquiries.php">Manage Inquiries</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="booking-section">
    <h1>Manage Personal Training Bookings</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Display personal training bookings in a table -->
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User</th>
                    <th>Trainer</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['booking_id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['trainer']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['time']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="approve_personal_training.php?booking_id=<?= $row['booking_id'] ?>" class="cta">Approve</a>
                                <a href="reject_personal_training.php?booking_id=<?= $row['booking_id'] ?>" class="cta reject">Reject</a>
                            <?php else: ?>
                                <span style="color:gray;">No Action</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No personal training bookings found.</p>
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

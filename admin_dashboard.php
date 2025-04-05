<?php
// Start the session
session_start();

// Check if admin is logged in and role is 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include the database configuration
include('config.php');

// Fetch all bookings with user and class info
$query = "SELECT b.booking_id, u.username, c.class_name, b.date, b.time, b.status 
          FROM bookings b
          JOIN users u ON b.user_id = u.user_id
          JOIN classes c ON b.class_id = c.class_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Bookings</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }
        .cta {
            padding: 6px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 5px;
        }
        .cta:hover {
            background-color: #218838;
        }
        .reject {
            background-color: #dc3545;
        }
        .reject:hover {
            background-color: #c82333;
        }
        .success-message {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <a href="index.html"><img src="logo.png" alt="FitZone Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php" class="active">Manage Bookings</a></li>
            <li><a href="admin_inquiries.php" class="active">Manage Inquiries</a></li>
            <li><a href="admin_personal_training.php" class="active">Manage Personal Training Bookings</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="admin-booking-section">
        <h1 style="text-align:center;">Manage Bookings</h1>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'booking_updated'): ?>
            <p class="success-message">Booking status updated successfully!</p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['class_name']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['time']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <a href="approve_booking.php?booking_id=<?= $row['booking_id'] ?>" class="cta">Approve</a>
                                    <a href="reject_booking.php?booking_id=<?= $row['booking_id'] ?>" class="cta reject">Reject</a>
                                <?php } else { ?>
                                    <span style="color:gray;">No Action</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<footer>
    <p style="text-align:center;">&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
</footer>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

// Fetch available classes from the database
include 'config.php'; // Make sure you have a database connection
$query = "SELECT * FROM classes"; // Adjust the query based on your class table
$result = mysqli_query($conn, $query);

// Fetch the user's current bookings and their statuses
$user_query = "SELECT b.booking_id, c.class_name, b.date, b.time, b.status
               FROM bookings b
               JOIN classes c ON b.class_id = c.class_id
               WHERE b.user_id = (SELECT user_id FROM users WHERE username = ?)";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Class</title>
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
            <li><a href="booking.php" class="active">Book a Class</a></li>
            <li><a href="my_bookings.php" class="active">Your Bookings</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="booking-section">
    <h1>Book Your Class</h1>
    <form action="book_class.php" method="POST">
        <label for="class">Select Class:</label>
        <select name="class_id" id="class" required>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?= $row['class_id'] ?>"><?= $row['class_name'] ?></option>
            <?php } ?>
        </select>

        <label for="date">Select Date:</label>
        <input type="date" name="date" required>

        <label for="time">Select Time:</label>
        <input type="time" name="time" required>

        <button type="submit" class="cta">Book Now</button>
    </form>
</section>

<footer>
    <p>&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
</footer>

</body>
</html>

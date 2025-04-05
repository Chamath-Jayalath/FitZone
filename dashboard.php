<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard - FitZone</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.html">
            <img src="logo.png" alt="FitZone Logo">
        </a>
    </div>
    <nav>
        <ul>
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="booking.php">Book a Class</a></li>
            <li><a href="personal_training.php">Personal Training</a></li>
            <li><a href="services.php">View Services</a></li>
            <li><a href="submit_query.php">Submit Inquiry</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="dashboard-hero">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?> 👋</h1>
    <p>Your FitZone journey starts here!</p>
</section>

<section class="dashboard-content">

    <div class="dash-card">
        <h2>Book a Class</h2>
        <p>Choose your class and book a spot.</p>
        <a href="booking.php" class="cta">Book Now</a>
    </div>

    <div class="dash-card">
        <h2>Personal Training</h2>
        <p>Schedule one-on-one training sessions.</p>
        <a href="personal_training.php" class="cta">Schedule</a>
    </div>

    <div class="dash-card">
        <h2>View Services</h2>
        <p>Explore classes, trainers, and membership plans.</p>
        <a href="services.php" class="cta">Explore</a>
    </div>

    <div class="dash-card">
        <h2>Submit Inquiry</h2>
        <p>Have a question or concern? Let us know.</p>
        <a href="submit_query.php" class="cta">Submit</a>
    </div>
    

</section>

<footer>
    <p>&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
    <div class="social-media">
        <a href="https://facebook.com" target="_blank">
            <img src="facebook-icon.png" alt="Facebook">
        </a>
        <a href="https://instagram.com" target="_blank">
            <img src="instagram-icon.jpg" alt="Instagram">
        </a>
    </div>
</footer>

</body>
</html>

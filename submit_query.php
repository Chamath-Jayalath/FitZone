<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Inquiry - FitZone</title>
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
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="submit_query.php" class="active">Submit Inquiry</a></li>
            <li><a href="view_inquiry_response.php" class="active">view inquiry response</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<main class="content-section">
    <h2>Submit Your Inquiry</h2>
    <form action="process_inquiry.php" method="post" class="form-box">
        <label for="subject">Subject:</label>
        <input type="text" name="subject" required>

        <label for="message">Message:</label>
        <textarea name="message" required></textarea>

        <button type="submit" class="cta">Submit Inquiry</button>
    </form>
</main>

</body>
</html>

<?php
session_start();

// Check if the user is logged in by checking for user_id in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database configuration file
include 'config.php';

// Prepare the SQL query to fetch the latest inquiry for the logged-in user
$inquiry_query = "SELECT id, subject, message, response, submitted_at, status, response_at
                  FROM inquiries 
                  WHERE user_id = ? 
                  ORDER BY submitted_at DESC LIMIT 1";

// Prepare and execute the query
$inquiry_stmt = $conn->prepare($inquiry_query);
$inquiry_stmt->bind_param("i", $_SESSION['user_id']);
$inquiry_stmt->execute();
$inquiry_result = $inquiry_stmt->get_result();

// Fetch the inquiry data if it exists
if ($inquiry_result->num_rows > 0) {
    $inquiry = $inquiry_result->fetch_assoc();
} else {
    $inquiry = null; // No inquiries found
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Inquiry Response - FitZone</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Ensure the path to your CSS file is correct -->
</head>
<body>

<header>
    <div class="logo">
        <a href="index.html"><img src="logo.png" alt="FitZone Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="submit_query.php">Submit Inquiry</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="inquiry-section">
    <h1>Your Latest Inquiry</h1>

    <?php if ($inquiry): ?>
        <!-- Display inquiry details -->
        <div class="inquiry-details">
            <h2>Subject: <?= htmlspecialchars($inquiry['subject']) ?></h2>
            <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($inquiry['message'])) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($inquiry['status']) ?></p>
            <p><strong>Submitted At:</strong> <?= htmlspecialchars($inquiry['submitted_at']) ?></p>

            <?php if ($inquiry['response']): ?>
                <!-- Display admin response if available -->
                <div class="response">
                    <h3>Admin Response:</h3>
                    <p><?= nl2br(htmlspecialchars($inquiry['response'])) ?></p>
                    <p><strong>Response At:</strong> <?= htmlspecialchars($inquiry['response_at']) ?></p>
                </div>
            <?php else: ?>
                <p><strong>Response:</strong> No response yet from the admin.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>You don't have any inquiries submitted yet.</p>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
</footer>

</body>
</html>

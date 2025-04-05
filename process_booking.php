<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);

// Include the database configuration file
include 'config.php';

// Check if the class_id is set in the POST request
if (isset($_POST['class_id'])) {
    $class_id = intval($_POST['class_id']);

    // Begin a transaction
    $pdo->beginTransaction();

    // Fetch the class details to check available spots
    $query = "SELECT available_spots FROM classes WHERE id = :class_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['class_id' => $class_id]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($class) {
        if ($class['available_spots'] > 0) {
            // Update the available spots
            $new_spots = $class['available_spots'] - 1;
            $updateQuery = "UPDATE classes SET available_spots = :new_spots WHERE id = :class_id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute(['new_spots' => $new_spots, 'class_id' => $class_id]);

            // Commit the transaction
            $pdo->commit();

            // Confirmation message
            echo "<h1>Booking Confirmed!</h1>";
            echo "<p>Thank you, " . $username . "! You have successfully booked a spot in the class.</p>";
            echo "<a href='dashboard.php'>Return to Dashboard</a>";
        } else {
            // Rollback the transaction if no spots are available
            $pdo->rollBack();
            echo "<h1>Booking Failed</h1>";
            echo "<p>Sorry, there are no available spots for this class.</p>";
            echo "<a href='book_class.php'>Back to Booking</a>";
        }
    } else {
        // Rollback the transaction if the class does not exist
        $pdo->rollBack();
        echo "<h1>Error</h1>";
        echo "<p>Class not found. Please try again.</p>";
        echo "<a href='book_class.php'>Back to Booking</a>";
    }
} else {
    // If class_id is not set, redirect to booking page
    header("Location: book_class.php");
    exit();
}
?>
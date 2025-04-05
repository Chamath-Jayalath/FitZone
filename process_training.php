<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is logged in
    if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
        // Get the form inputs
        $trainer = $_POST['trainer'];
        $date = $_POST['date'];
        $time = $_POST['time']; // Added time field
        $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

        // Connect to the database
        include 'config.php'; // Include database connection

        // Prepare the SQL query to insert the personal training booking
        $query = "INSERT INTO personal_training (user_id, trainer, date, time, status) VALUES (?, ?, ?, ?, 'Pending')";
        if ($stmt = $conn->prepare($query)) {
            // Bind the parameters to the SQL query
            $stmt->bind_param("isss", $user_id, $trainer, $date, $time);
            
            // Execute the query
            if ($stmt->execute()) {
                // Booking successful, show success message and redirect
                echo "<p style='color:green;'>Your personal training session has been booked successfully!</p>";

                // Redirect to the dashboard after 2 seconds
                header("Location: dashboard.php");
                exit(); // Make sure no further code is executed after the redirection
            } else {
                echo "<p style='color:red;'>Error: Could not book the session. Please try again.</p>";
            }
            $stmt->close(); // Close the statement
        } else {
            echo "<p style='color:red;'>Failed to prepare the SQL query. Please check your database connection.</p>";
        }
        
        // Close the database connection
        $conn->close();
    } else {
        // If the user is not logged in
        echo "<p style='color:red;'>You must be logged in to book a personal training session.</p>";
    }
}
?>

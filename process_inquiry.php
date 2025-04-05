<?php
session_start();

// Check if the user is logged in by checking the session for the username
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include database connection file
include('config.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Get user_id from session
    $user_id = $_SESSION['user_id'];  // Assuming you have stored user_id in the session when the user logs in

    // Check if fields are not empty
    if (!empty($subject) && !empty($message)) {
        // Insert inquiry into the database along with the user_id
        $query = "INSERT INTO inquiries (subject, message, user_id, submitted_at, status) 
                  VALUES ('$subject', '$message', '$user_id', NOW(), 'Pending')";

        if (mysqli_query($conn, $query)) {
            // Redirect to a confirmation page or back to dashboard
            header("Location: dashboard.php?status=inquiry_submitted");
            exit();
        } else {
            // Handle any errors
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>

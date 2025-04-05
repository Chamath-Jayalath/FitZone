<?php
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
include('config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inquiry_id']) && isset($_POST['response'])) {
    $inquiry_id = $_POST['inquiry_id'];
    $response = mysqli_real_escape_string($conn, $_POST['response']);
    $response_at = date("Y-m-d H:i:s");  // Timestamp for when the response was added

    // Update the inquiry with the admin's response
    $query = "UPDATE inquiries SET response = ?, response_at = ?, status = 'Responded' WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ssi", $response, $response_at, $inquiry_id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the admin inquiries page
            header("Location: admin_inquiries.php?status=response_updated");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<?php
session_start();  // Start the session to store submission status

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted already in the current session
    if (isset($_SESSION['submitted']) && $_SESSION['submitted'] === true) {
        echo "<p>You have already submitted the form. Please wait for a response.</p>";
        exit(); // Prevent further execution
    }

    // Get form values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate input data
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contact_form_submissions (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the query
        if ($stmt->execute()) {
            // Set the session variable to prevent further submissions
            $_SESSION['submitted'] = true;

            // Redirect to the contact page with a success parameter
            header("Location: contact.html?success=true");
            exit(); // Ensure no further script execution
        } else {
            // Error message if insertion fails
            echo "<p>Sorry, there was an error processing your request. Please try again later.</p>";
        }

        $stmt->close();
    } else {
        // Validation error message
        echo "<p>Please fill in all the fields correctly.</p>";
    }
}

$conn->close();
?>

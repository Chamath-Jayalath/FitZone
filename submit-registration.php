<?php
// Include the database configuration
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<p>Passwords do not match. Please try again.</p>";
        exit();
    }

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p>Email is already registered. Please use a different email.</p>";
        exit();
    }

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (username, fullname, email, password, phone, gender, dob) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $fullname, $email, $hashed_password, $phone, $gender, $dob);

    // Execute the query
    if ($stmt->execute()) {
        echo "<p>Registration successful! You can now <a href='login.html'>login</a>.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

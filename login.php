<?php
// Include the database configuration file
include('config.php');

// Start the session
session_start();

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Handle connection error
}

// Redirect to dashboard if already logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== NULL) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: dashboard.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize the form values
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate the input (Check if username and password are not empty)
    if (!empty($username) && !empty($password)) {
        
        // Create a query to check if the username exists in the database
        $query = "SELECT user_id, username, password, role FROM users WHERE username = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $username); // Bind the parameter
            $stmt->execute(); // Execute the query
            $result = $stmt->get_result(); // Get the result
            
            // Check if any user was found
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc(); // Fetch the user record

                // Verify if the entered password matches the hashed password in the database
                if (password_verify($password, $user['password'])) {
                    // Password is correct, start a session and store the user's information
                    
                    // Regenerate session ID to prevent session fixation attacks
                    session_regenerate_id(true);
                    
                    // Set session variables
                    $_SESSION['user_id'] = $user['user_id']; // Ensure user_id is set correctly
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role']; // Store the role in the session
                    
                    // Check if the user is an admin or a regular user
                    if (strtolower(trim($user['role'])) === 'admin') {
                        // Redirect admin to the admin dashboard
                        header("Location: admin_dashboard.php");
                        exit(); // Terminate the script to prevent further execution
                    } else {
                        // Redirect regular user to the user dashboard
                        header("Location: dashboard.php");
                        exit(); // Terminate the script to prevent further execution
                    }
                } else {
                    // Password is incorrect
                    echo "<p style='color:red;'>Incorrect password. Please try again.</p>";
                }
            } else {
                // Username not found
                echo "<p style='color:red;'>No account found with that username.</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color:red;'>Failed to prepare the SQL query: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Please fill in both fields.</p>";
    }
}

$conn->close();
?>

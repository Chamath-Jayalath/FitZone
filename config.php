<?php

$host = "localhost";   
$username = "root";    
$password = "";        
$dbname = "fitzone";   

// Create a database connection 
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

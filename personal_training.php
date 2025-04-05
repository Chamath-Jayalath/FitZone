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
    <title>Personal Training - FitZone</title>
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
            <li><a href="book_training.php">Your Personal Training</a></li>
        </ul>
    </nav>
</header>

<main class="content-section">
    <h2>Schedule Personal Training</h2>
    
    <form action="process_training.php" method="post" class="form-box">
        <label for="trainer">Select Trainer:</label>
        <select name="trainer" id="trainer" required>
        <option value="Nimal Perera">Nimal Perera</option>
        <option value="Samantha Silva">Samantha Silva</option>
        <option value="Chamari De Silva">Chamari De Silva</option>
        <option value="Pradeep Rajapaksa">Pradeep Rajapaksa</option>
        <option value="Shanika Fernando">Shanika Fernando</option>
        <option value="Dilshan Wijesinghe">Dilshan Wijesinghe</option>

        </select>

        <label for="date">Choose Date:</label>
        <input type="date" name="date" required>

        <label for="time">Choose Time:</label>
        <input type="time" name="time" required> <!-- Added time input here -->

        <button type="submit" class="cta">Book Training</button>
    </form>
</main>

<footer>
    <p>&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
</footer>

</body>  
</html>

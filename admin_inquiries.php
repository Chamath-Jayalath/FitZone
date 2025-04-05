<?php
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
include('config.php');

// Fetch all inquiries
$query = "SELECT * FROM inquiries ORDER BY submitted_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Inquiries</title>
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
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            
            <li><a href="admin_inquiries.php" class="active">View Inquiries</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="admin-inquiries">
    <h2>Inquiries Submitted by Users</h2>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Response</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['response'] ? htmlspecialchars($row['response']) : 'No response yet' ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <form action="update_response.php" method="post">
                                <input type="hidden" name="inquiry_id" value="<?= $row['id'] ?>">
                                <textarea name="response" placeholder="Enter your response here"></textarea>
                                <button type="submit">Update Response</button>
                            </form>
                        <?php else: ?>
                            <span>Response given</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<footer>
    <p>&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
</footer>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

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
    <title>Services - FitZone</title>
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
            <li><a href="book_class.php">Book a Class</a></li>
            <li><a href="personal_training.php">Personal Training</a></li>
            <li><a href="services.php" class="active">View Services</a></li>
            <li><a href="submit_query.php">Submit Inquiry</a></li>
            <li><a href="logout.php" class="btn">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="service-section">
    <h2>Our Services</h2>

    <!-- Service Table -->
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Group Classes</td>
                <td>Yoga, Zumba, HIIT, and more! Our group classes are designed to bring out the best in you while keeping you motivated and engaged.</td>
                <td>₨ 7,500 per class</td>
                <td><img src="group_classes.jpg" alt="Group Classes" class="service-img"></td>
            </tr>
            <tr>
                <td>Personal Training</td>
                <td>1-on-1 personalized sessions with certified trainers. Whether you’re looking to lose weight, build muscle, or train for a competition, we’ll help you achieve your goals.</td>
                <td>₨ 15,000 per session</td>
                <td><img src="personal_training.jpg" alt="Personal Training" class="service-img"></td>
            </tr>
            <tr>
                <td>Membership Plans</td>
                <td>Choose from Basic, Premium, and Elite packages that provide unlimited access to all facilities, including group classes and personal training sessions.</td>
                <td>From ₨ 5,000/month</td>
                <td><img src="membership_plans.jpg" alt="Membership Plans" class="service-img"></td>
            </tr>
        </tbody>
    </table>

    <!-- Detailed Service Descriptions Section -->
    <section class="service-details">
        <div class="service-item">
            <h3>Group Classes</h3>
            <p>Our group classes are designed to keep you engaged and motivated. We offer a wide range of classes including Yoga, Zumba, High-Intensity Interval Training (HIIT), and more. Whether you are looking for relaxation or an intense workout, we have something for everyone!</p>
            <ul>
                <li>Yoga - Improve flexibility and reduce stress</li>
                <li>Zumba - Dance your way to fitness</li>
                <li>HIIT - Boost metabolism with high-intensity workouts</li>
                
            </ul>
        </div>

        <div class="service-item">
            <h3>Personal Training</h3>
            <p>Get personalized training with our certified fitness experts. Whether your goal is to lose weight, build muscle, or enhance athletic performance, our trainers will tailor the program to your individual needs. You’ll get one-on-one attention, detailed assessments, and a plan to reach your goals efficiently.</p>
            <ul>
                <li>Custom workout plans</li>
                <li>Nutrition guidance</li>
                <li>Performance tracking</li>
                <li>Flexible schedules</li>
            </ul>
        </div>

        <div class="service-item">
            <h3>Membership Plans</h3>
            <p>Choose from our flexible membership plans to access all the amenities FitZone has to offer. From unlimited access to group classes to personal training sessions, our memberships are designed to fit all fitness goals and budgets.</p>
            <ul>
                <li>Basic Plan - Includes access to all group classes</li>
                <li>Premium Plan - Includes group classes and limited personal training</li>
                <li>Elite Plan - All-inclusive with unlimited access to everything</li>
            </ul>
        </div>
    </section>
</section>

<footer>
    <p>&copy; 2025 FitZone Fitness Center. All Rights Reserved.</p>
</footer>

</body>
</html>

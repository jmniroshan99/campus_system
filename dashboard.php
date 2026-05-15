<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

// Get total students count
$stmt = $pdo->query("SELECT COUNT(*) as total FROM students");
$total_students = $stmt->fetch()['total'];

// Get male/female count
$stmt = $pdo->query("SELECT gender, COUNT(*) as count FROM students GROUP BY gender");
$gender_stats = $stmt->fetchAll();

// Get course distribution
$stmt = $pdo->query("SELECT course, COUNT(*) as count FROM students GROUP BY course");
$course_stats = $stmt->fetchAll();

// Get recent students
$stmt = $pdo->query("SELECT * FROM students ORDER BY name LIMIT 5");
$recent_students = $stmt->fetchAll();

// Calculate male/female counts
$male_count = 0;
$female_count = 0;
foreach ($gender_stats as $stat) {
    if ($stat['gender'] == 'Male') $male_count = $stat['count'];
    if ($stat['gender'] == 'Female') $female_count = $stat['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Campus Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <i class="fas fa-school"></i>
                Campus Management System
            </div>
            <ul class="nav-menu">
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="register_student.php"><i class="fas fa-user-plus"></i> Register Student</a></li>
                <li><a href="search_student.php"><i class="fas fa-search"></i> Search Student</a></li>
                <li><a href="update_student.php"><i class="fas fa-edit"></i> Update Student</a></li>
                <li><a href="delete_student.php"><i class="fas fa-trash-alt"></i> Delete Student</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="stat-number"><?php echo $total_students; ?></div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-male"></i>
                <div class="stat-number"><?php echo $male_count; ?></div>
                <div class="stat-label">Male Students</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-female"></i>
                <div class="stat-number"><?php echo $female_count; ?></div>
                <div class="stat-label">Female Students</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-graduation-cap"></i>
                <div class="stat-number"><?php echo count($course_stats); ?></div>
                <div class="stat-label">Courses Offered</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-chart-bar"></i> Course Distribution</h2>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-book"></i> Course</th>
                            <th><i class="fas fa-users"></i> Number of Students</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($course_stats as $course): ?>
                        <tr>
                            <td><i class="fas fa-graduation-cap"></i> <?php echo $course['course']; ?></td>
                            <td><?php echo $course['count']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-clock"></i> Recent Students</h2>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-id-card"></i> NIC</th>
                            <th><i class="fas fa-user"></i> Name</th>
                            <th><i class="fas fa-graduation-cap"></i> Course</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_students as $student): ?>
                        <tr>
                            <td><i class="fas fa-id-card"></i> <?php echo $student['nic']; ?></td>
                            <td><i class="fas fa-user"></i> <?php echo htmlspecialchars($student['name']); ?></td>
                            <td><i class="fas fa-graduation-cap"></i> <?php echo $student['course']; ?></td>
                            <td><i class="fas fa-envelope"></i> <?php echo $student['email']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
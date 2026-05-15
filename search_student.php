<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

$student = null;
$search_nic = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_nic = $_POST['nic'];
    $stmt = $pdo->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt->execute([$search_nic]);
    $student = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Student - Campus Management System</title>
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
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-search"></i> Search Student Details</h2>
                <p><i class="fas fa-info-circle"></i> Enter NIC number to search for a student</p>
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>
                        <i class="fas fa-id-card"></i>
                        Enter NIC Number
                    </label>
                    <input type="text" name="nic" value="<?php echo htmlspecialchars($search_nic); ?>" required placeholder="e.g., 199512345678">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Search Student
                </button>
            </form>
        </div>
        
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php if ($student): ?>
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-user-circle"></i> Student Details</h2>
                        <p><i class="fas fa-id-card"></i> NIC: <?php echo $student['nic']; ?></p>
                    </div>
                    <div class="table-container">
                        <table>
                            <tr>
                                <th><i class="fas fa-id-card"></i> NIC</th>
                                <td><strong><?php echo $student['nic']; ?></strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-user"></i> Name</th>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-venus-mars"></i> Gender</th>
                                <td>
                                    <?php if($student['gender'] == 'Male'): ?>
                                        <i class="fas fa-male"></i> Male
                                    <?php elseif($student['gender'] == 'Female'): ?>
                                        <i class="fas fa-female"></i> Female
                                    <?php else: ?>
                                        <i class="fas fa-genderless"></i> Other
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-map-marker-alt"></i> Address</th>
                                <td><?php echo nl2br(htmlspecialchars($student['address'])); ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone"></i> Contact</th>
                                <td><i class="fas fa-phone-alt"></i> <?php echo $student['contact']; ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <td><i class="fas fa-envelope"></i> <?php echo $student['email']; ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-graduation-cap"></i> Course</th>
                                <td><i class="fas fa-book"></i> <?php echo $student['course']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="action-buttons" style="margin-top: 20px;">
                        <a href="update_student.php?nic=<?php echo $student['nic']; ?>" class="btn btn-info">
                            <i class="fas fa-edit"></i> Edit Student
                        </a>
                        <a href="delete_student.php?nic=<?php echo $student['nic']; ?>" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Student
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    No student found with NIC: <?php echo htmlspecialchars($search_nic); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
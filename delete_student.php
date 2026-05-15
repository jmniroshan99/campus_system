<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

$message = '';
$message_type = '';

// Check if NIC passed via GET
if (isset($_GET['nic'])) {
    $nic = $_GET['nic'];
    $stmt = $pdo->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt->execute([$nic]);
    $student = $stmt->fetch();
    
    if ($student) {
        $message = "Are you sure you want to delete student: " . htmlspecialchars($student['name']) . "?";
        $message_type = 'confirm';
        $confirm_nic = $nic;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    
    // Check if student exists
    $stmt = $pdo->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt->execute([$nic]);
    $student = $stmt->fetch();
    
    if ($student) {
        if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
            $stmt = $pdo->prepare("DELETE FROM students WHERE nic = ?");
            $stmt->execute([$nic]);
            $message = "Student with NIC: $nic has been deleted successfully!";
            $message_type = 'success';
        } else {
            $message = "Are you sure you want to delete student: " . htmlspecialchars($student['name']) . "?";
            $message_type = 'confirm';
            $confirm_nic = $nic;
        }
    } else {
        $message = "No student found with NIC: $nic";
        $message_type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student - Campus Management System</title>
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
                <h2><i class="fas fa-trash-alt"></i> Delete Student Record</h2>
                <p><i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> <strong style="color: #dc3545;">Warning:</strong> This action cannot be undone!</p>
            </div>
            
            <?php if ($message && $message_type != 'confirm'): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fas <?php echo $message_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($confirm_nic)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning!</strong> <?php echo $message; ?>
                    <form method="POST" action="" style="margin-top: 15px;">
                        <input type="hidden" name="nic" value="<?php echo $confirm_nic; ?>">
                        <input type="hidden" name="confirm" value="yes">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Yes, Delete Student
                        </button>
                        <a href="delete_student.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </form>
                </div>
            <?php else: ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-id-card"></i>
                            Enter NIC Number of Student to Delete
                        </label>
                        <input type="text" name="nic" required placeholder="e.g., 199512345678">
                    </div>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-search"></i>
                        Find Student
                    </button>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Dashboard
                    </a>
                </form>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-users"></i> All Students</h2>
            </div>
            <div class="table-container">
                <?php
                $stmt = $pdo->query("SELECT * FROM students ORDER BY name");
                $students = $stmt->fetchAll();
                ?>
                 <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-id-card"></i> NIC</th>
                            <th><i class="fas fa-user"></i> Name</th>
                            <th><i class="fas fa-graduation-cap"></i> Course</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-cog"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><i class="fas fa-id-card"></i> <?php echo $student['nic']; ?></td>
                            <td><i class="fas fa-user"></i> <?php echo htmlspecialchars($student['name']); ?></td>
                            <td><i class="fas fa-graduation-cap"></i> <?php echo $student['course']; ?></td>
                            <td><i class="fas fa-envelope"></i> <?php echo $student['email']; ?></td>
                            <td>
                                <a href="delete_student.php?nic=<?php echo $student['nic']; ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
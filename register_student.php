<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

$courses = ['Computer Science', 'Information Technology', 'Software Engineering', 'Data Science', 'Cyber Security'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO students (nic, name, gender, address, contact, email, course) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nic, $name, $gender, $address, $contact, $email, $course]);
        $success = "Student registered successfully!";
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student - Campus Management System</title>
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
                <h2><i class="fas fa-user-graduate"></i> Student Registration Form</h2>
                <p><i class="fas fa-info-circle"></i> Fill in all required fields (*)</p>
            </div>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>
                        <i class="fas fa-id-card"></i>
                        NIC Number *
                    </label>
                    <input type="text" name="nic" maxlength="12" required placeholder="e.g., 199512345678">
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-user"></i>
                        Full Name *
                    </label>
                    <input type="text" name="name" required placeholder="Enter full name">
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-venus-mars"></i>
                        Gender *
                    </label>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male"><i class="fas fa-male"></i> Male</option>
                        <option value="Female"><i class="fas fa-female"></i> Female</option>
                        <option value="Other"><i class="fas fa-genderless"></i> Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-map-marker-alt"></i>
                        Address *
                    </label>
                    <textarea name="address" required placeholder="Enter complete address"></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-phone"></i>
                        Contact Number *
                    </label>
                    <input type="tel" name="contact" required placeholder="e.g., 0771234567">
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-envelope"></i>
                        Email *
                    </label>
                    <input type="email" name="email" required placeholder="student@example.com">
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-graduation-cap"></i>
                        Course *
                    </label>
                    <select name="course" required>
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course; ?>">
                                <i class="fas fa-book"></i> <?php echo $course; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Register Student
                </button>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </form>
        </div>
    </div>
</body>
</html>
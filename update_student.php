<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

$courses = ['Computer Science', 'Information Technology', 'Software Engineering', 'Data Science', 'Cyber Security'];
$student = null;
$search_nic = '';

// Check if NIC passed via GET
if (isset($_GET['nic'])) {
    $search_nic = $_GET['nic'];
    $stmt = $pdo->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt->execute([$search_nic]);
    $student = $stmt->fetch();
}

// Search for student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search_nic = $_POST['nic'];
    $stmt = $pdo->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt->execute([$search_nic]);
    $student = $stmt->fetch();
}

// Update student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nic = $_POST['nic'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    
    try {
        $stmt = $pdo->prepare("UPDATE students SET name=?, gender=?, address=?, contact=?, email=?, course=? WHERE nic=?");
        $stmt->execute([$name, $gender, $address, $contact, $email, $course, $nic]);
        $success = "Student details updated successfully!";
        
        // Refresh student data
        $stmt = $pdo->prepare("SELECT * FROM students WHERE nic = ?");
        $stmt->execute([$nic]);
        $student = $stmt->fetch();
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
    <title>Update Student - Campus Management System</title>
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
                <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
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
                <h2><i class="fas fa-edit"></i> Update Student Details</h2>
                <p><i class="fas fa-info-circle"></i> Enter NIC to find and update student information</p>
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>
                        <i class="fas fa-id-card"></i>
                        Enter NIC Number
                    </label>
                    <input type="text" name="nic" value="<?php echo htmlspecialchars($search_nic); ?>" required placeholder="e.g., 199512345678">
                </div>
                <button type="submit" name="search" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Search Student
                </button>
            </form>
        </div>
        
        <?php if ($student): ?>
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-user-edit"></i> Update Form for <?php echo htmlspecialchars($student['name']); ?></h2>
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
                    <input type="hidden" name="nic" value="<?php echo $student['nic']; ?>">
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-user"></i>
                            Full Name *
                        </label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-venus-mars"></i>
                            Gender *
                        </label>
                        <select name="gender" required>
                            <option value="Male" <?php echo $student['gender'] == 'Male' ? 'selected' : ''; ?>>
                                <i class="fas fa-male"></i> Male
                            </option>
                            <option value="Female" <?php echo $student['gender'] == 'Female' ? 'selected' : ''; ?>>
                                <i class="fas fa-female"></i> Female
                            </option>
                            <option value="Other" <?php echo $student['gender'] == 'Other' ? 'selected' : ''; ?>>
                                <i class="fas fa-genderless"></i> Other
                            </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-map-marker-alt"></i>
                            Address *
                        </label>
                        <textarea name="address" required><?php echo htmlspecialchars($student['address']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-phone"></i>
                            Contact Number *
                        </label>
                        <input type="tel" name="contact" value="<?php echo $student['contact']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-envelope"></i>
                            Email *
                        </label>
                        <input type="email" name="email" value="<?php echo $student['email']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-graduation-cap"></i>
                            Course *
                        </label>
                        <select name="course" required>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo $course; ?>" <?php echo $student['course'] == $course ? 'selected' : ''; ?>>
                                    <i class="fas fa-book"></i> <?php echo $course; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Student
                    </button>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
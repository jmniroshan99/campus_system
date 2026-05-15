<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .logout-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-out;
        }
        .logout-box i {
            font-size: 60px;
            color: #667eea;
            margin-bottom: 20px;
        }
        .logout-box h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .logout-box p {
            color: #666;
            margin-bottom: 20px;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <meta http-equiv="refresh" content="2;url=index.php">
</head>
<body>
    <div class="logout-box">
        <i class="fas fa-sign-out-alt"></i>
        <h2>Logged Out Successfully</h2>
        <p>Thank you for using Campus Management System</p>
        <p><i class="fas fa-spinner fa-spin"></i> Redirecting to login page...</p>
    </div>
</body>
</html>
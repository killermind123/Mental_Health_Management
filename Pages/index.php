<?php include 'Includes/header.php'; ?> <!-- Including navbar at the top -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Selection</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            margin: 0;
            padding-top: 70px; /* To prevent overlap with the navbar */
        }

        /* Container Styling */
        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
            width: 400px;
        }

        .container:hover {
            transform: scale(1.05);
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
            font-weight: bold;
        }

        /* Button Styling */
        .login-btn {
            display: block;
            width: 100%;
            margin: 15px 0;
            padding: 18px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        /* Button Hover Animation */
        .login-btn::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s ease-in-out;
        }

        .login-btn:hover::after {
            left: 0;
        }

        /* Button Colors */
        .admin-btn { background: linear-gradient(135deg, #e74c3c, #ff7675); }
        .doctor-btn { background: linear-gradient(135deg, #3498db, #6ab3f8); }
        .patient-btn { background: linear-gradient(135deg, #2ecc71, #58d68d); }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Responsive Design */
        @media screen and (max-width: 480px) {
            .container {
                width: 90%;
                padding: 30px;
            }
            .login-btn {
                font-size: 18px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login As:</h2>
        <a href="admin_login.php"><button class="login-btn admin-btn">Admin</button></a>
        <a href="doctor_login.php"><button class="login-btn doctor-btn">Doctor</button></a>
        <a href="patient_login.php"><button class="login-btn patient-btn">Patient</button></a>
    </div>
</body>
</html>

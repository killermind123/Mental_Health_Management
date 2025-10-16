<?php
session_start();
if (!isset($_SESSION['doctor'])) {
    header("Location: doctor_login.php");
    exit();
}

// Retrieve the doctor's name if stored in session
$doctorName = isset($_SESSION['doctor_name']) ? $_SESSION['doctor_name'] : 'Doctor';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Dashboard Container */
        .dashboard {
            width: 50%;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Navigation Menu */
        .nav {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .nav a {
            text-decoration: none;
            padding: 12px 20px;
            background-color: #4285F4;
            color: white;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .nav a:hover {
            background-color: #357ae8;
            transform: scale(1.05);
        }

        /* Logout Button */
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #e74c3c;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .dashboard {
                width: 80%;
                padding: 20px;
            }

            .nav {
                flex-direction: column;
                gap: 10px;
            }

            .nav a, .logout-btn {
                padding: 14px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($doctorName); ?>!</h2>
        
        <!-- Navigation Menu -->
        <div class="nav">
            <a href="appointments.php">View Appointments</a>
            <a href="add_prescription.php">Add Prescription</a>
        </div>
        
        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Encrypt password
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $sql = "INSERT INTO patients (name, email, password, age, gender) VALUES ('$name', '$email', '$password', '$age', '$gender')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful! Please login.'); window.location='patient_login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Registration Container */
        .container {
            width: 400px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        /* Input Fields */
        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s ease-in-out;
        }

        input:focus, select:focus {
            border-color: #4285F4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
            outline: none;
        }

        /* Register Button */
        button {
            width: 100%;
            padding: 14px;
            background-color: #4285F4;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        button:hover {
            background-color: #357ae8;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media screen and (max-width: 480px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            input, select, button {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register as Patient</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="number" name="age" placeholder="Age" required>
            <select name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

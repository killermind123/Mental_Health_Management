<?php
session_start();
include 'db.php'; // Ensure this file sets up your $conn connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name      = trim($_POST['name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $specialty = $_POST['specialty'];  // Matches the column name in your database

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT id FROM doctors WHERE email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $error = "This email is already registered!";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new doctor into the database
        $stmt_insert = $conn->prepare("INSERT INTO doctors (name, email, password, specialty) VALUES (?, ?, ?, ?)");
        if ($stmt_insert === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt_insert->bind_param("ssss", $name, $email, $hashed_password, $specialty);

        if ($stmt_insert->execute()) {
            // Redirect to the login page after successful registration
            header("Location: doctor_login.php");
            exit();
        } else {
            $error = "Registration error: " . $conn->error;
        }
        $stmt_insert->close();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic inline CSS for demonstration */
        .container {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 6px 0;
            box-sizing: border-box;
        }
        button {
            background-color: #4285F4;
            color: white;
            border: none;
        }
        h2 {
            text-align: center;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register as Doctor</h2>
        <?php 
        if (isset($error)) { 
            echo "<p class='error'>$error</p>"; 
        } 
        ?>
        <form method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="specialty" required>
                <option value="">Select Specialty</option>
                <option value="Cardiology">Cardiology</option>
                <option value="Dermatology">Dermatology</option>
                <option value="Neurology">Neurology</option>
                <option value="Mental">Mental</option>
                <option value="Orthopedics">Orthopedics</option>
                <!-- Add more specialties as needed -->
            </select>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

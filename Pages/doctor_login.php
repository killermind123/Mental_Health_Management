<?php
session_start();
include 'db.php'; // Ensure this file sets up your $conn connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and trim form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare a statement to select the doctor record based on the email
    $stmt = $conn->prepare("SELECT id, name, password FROM doctors WHERE email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    // Get the result and check if a matching record exists
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $doctor = $result->fetch_assoc();
        // Verify the password using password_verify()
        if (password_verify($password, $doctor['password'])) {
            // Password is correct; set session variables as needed
            $_SESSION['doctor'] = $doctor['id'];
            $_SESSION['doctor_name'] = $doctor['name']; // Optional, for display purposes
            
            // Redirect to the doctor's dashboard
            header("Location: doctor_dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Login</title>
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

        /* Login Container */
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
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s ease-in-out;
        }

        input:focus {
            border-color: #4285F4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
            outline: none;
        }

        /* Login Button */
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

        /* Error Message */
        .error {
            color: red;
            background: rgba(231, 76, 60, 0.2);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        /* Responsive Design */
        @media screen and (max-width: 480px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            input, button {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Doctor Login</h2>
        <?php 
        if (isset($error)) { 
            echo "<p class='error'>$error</p>"; 
        } 
        ?>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

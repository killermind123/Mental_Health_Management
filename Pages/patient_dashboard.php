<?php
session_start();
include 'db.php';

if (!isset($_SESSION['patient'])) {
    header("Location: patient_login.php");
    exit();
}

// Get patient's information from the database
$patient_email = $_SESSION['patient']; // Assuming email is stored in session after login
$sql = "SELECT * FROM patients WHERE email='$patient_email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $patient = $result->fetch_assoc();
} else {
    echo "Patient information not found.";
    exit();
}

// Handle appointment booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    // Insert the appointment into the database
    $insert_sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date) 
                   VALUES ('{$patient['id']}', '$doctor_id', '$appointment_date')";

    if ($conn->query($insert_sql) === TRUE) {
        $success = "Appointment booked successfully!";
    } else {
        $error = "Error booking appointment: " . $conn->error;
    }
}

// Fetch doctors for appointment booking
$doctor_sql = "SELECT * FROM doctors";
$doctors_result = $conn->query($doctor_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard</title>
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

        /* Dashboard Container */
        .dashboard {
            width: 60%;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2, h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        /* Success and Error Messages */
        .success {
            color: green;
            font-weight: bold;
            padding: 10px;
            background: rgba(46, 204, 113, 0.2);
            border-radius: 6px;
        }

        .error {
            color: red;
            font-weight: bold;
            padding: 10px;
            background: rgba(231, 76, 60, 0.2);
            border-radius: 6px;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4285F4;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Form Styling */
        form {
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-bottom: 8px;
        }

        select, input[type="date"], button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        select:focus, input[type="date"]:focus {
            border-color: #4285F4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
            outline: none;
        }

        /* Button Styling */
        button {
            background-color: #4285F4;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            padding: 12px;
            transition: 0.3s ease-in-out;
        }

        button:hover {
            background-color: #357ae8;
            transform: scale(1.05);
        }

        /* Logout Button */
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #e74c3c;
            padding: 12px;
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
                width: 90%;
                padding: 20px;
            }

            form {
                width: 100%;
            }

            select, input, button {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($patient['name']); ?></h2>
        <a href="logout.php" class="logout-btn">Logout</a>

        <h3>Your Information</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($patient['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>

        <h3>Book an Appointment</h3>
        <form method="POST">
            <label for="doctor_id">Select Doctor:</label>
            <select name="doctor_id" required>
                <option value="">-- Select Doctor --</option>
                <?php while ($doctor = $doctors_result->fetch_assoc()) { ?>
                    <option value="<?php echo $doctor['id']; ?>"><?php echo htmlspecialchars($doctor['name']); ?></option>
                <?php } ?>
            </select>

            <label for="appointment_date">Select Appointment Date:</label>
            <input type="date" name="appointment_date" required>

            <button type="submit">Book Appointment</button>
        </form>

        <h3>Your Appointments</h3>
        <?php
        $appointments_sql = "SELECT a.*, d.name AS doctor_name FROM appointments a
                             JOIN doctors d ON a.doctor_id = d.id
                             WHERE a.patient_id = '{$patient['id']}'";
        $appointments_result = $conn->query($appointments_sql);

        if ($appointments_result->num_rows > 0) {
            echo "<table><tr><th>Doctor</th><th>Date</th><th>Status</th></tr>";
            while ($appointment = $appointments_result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($appointment['doctor_name']) . "</td>
                        <td>" . htmlspecialchars($appointment['appointment_date']) . "</td>
                        <td>Confirmed</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>You have no upcoming appointments.</p>";
        }
        ?>
    </div>
</body>
</html>

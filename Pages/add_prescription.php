<?php
session_start();
include 'db.php';

if (!isset($_SESSION['doctor'])) {
    header("Location: doctor_login.php");
    exit();
}

// Fetch patients from the database
$patients = [];
$sql = "SELECT id, name FROM patients"; // Assuming 'patients' is the table name
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Handle prescription submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorEmail = $_SESSION['doctor'];
    $patientId = $_POST['patient_id'];
    $prescription = $_POST['prescription'];
    $date = date("Y-m-d");

    // Fetch doctor ID
    $doctorQuery = "SELECT id FROM doctors WHERE email='$doctorEmail'";
    $doctorResult = $conn->query($doctorQuery);
    $doctor = $doctorResult->fetch_assoc();
    $doctorId = $doctor['id'];

    // Insert prescription into database
    $sql = "INSERT INTO prescriptions (doctor_id, patient_id, prescription, date) 
            VALUES ('$doctorId', '$patientId', '$prescription', '$date')";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Prescription added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Prescription</title>
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

        /* Success and Error Messages */
        .success {
            color: green;
            background: rgba(46, 204, 113, 0.2);
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .error {
            color: red;
            background: rgba(231, 76, 60, 0.2);
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            text-align: left;
            display: block;
        }

        select, textarea, button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: 0.3s;
        }

        select:focus, textarea:focus {
            border-color: #4285F4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
            outline: none;
        }

        textarea {
            height: 120px;
            resize: none;
        }

        /* Submit Button */
        button {
            background-color: #4285F4;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        button:hover {
            background-color: #357ae8;
            transform: scale(1.05);
        }

        /* Back to Dashboard Link */
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            color: #4285F4;
            transition: 0.3s;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .dashboard {
                width: 80%;
                padding: 20px;
            }

            select, textarea, button {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Add Prescription</h2>

        <!-- Success & Error Messages -->
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <!-- Prescription Form -->
        <form method="POST">
            <label>Select Patient:</label>
            <select name="patient_id" required>
                <option value="">-- Select Patient --</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?php echo $patient['id']; ?>">
                        <?php echo htmlspecialchars($patient['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label>Prescription:</label>
            <textarea name="prescription" placeholder="Enter prescription details..." required></textarea>

            <button type="submit">Submit Prescription</button>
        </form>

        <a href="doctor_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
session_start();
include 'db.php';

// Redirect to admin login if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Determine which section to display; default is "users"
$section = isset($_GET['section']) ? $_GET['section'] : 'users';

// Initialize message variables
$msg = "";
$error = "";

// -------------------------
// Process Add Doctor Form
// -------------------------
if ($section === "add_doctor" && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $name      = trim($_POST['name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $specialty = trim($_POST['specialty']);

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new doctor into the database using a prepared statement
    $stmt = $conn->prepare("INSERT INTO doctors (name, email, password, specialty) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        $error = "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $specialty);
        if ($stmt->execute()) {
            $msg = "Doctor added successfully!";
            // Redirect to view doctors after successful addition
            header("Location: admin_dashboard.php?section=doctors&msg=" . urlencode($msg));
            exit();
        } else {
            $error = "Error adding doctor: " . $conn->error;
        }
        $stmt->close();
    }
}

// -------------------------
// Process Delete Doctor
// -------------------------
if ($section === "delete_doctor" && isset($_GET['id'])) {
    $doctor_id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
    if (!$stmt) {
        $error = "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("i", $doctor_id);
        if ($stmt->execute()) {
            $msg = "Doctor deleted successfully!";
        } else {
            $error = "Error deleting doctor: " . $conn->error;
        }
        $stmt->close();
        // Redirect back to the doctors view section
        header("Location: admin_dashboard.php?section=doctors&msg=" . urlencode($msg));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic inline styles for demonstration */
        /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #74ebd5, #acb6e5);
    margin: 0;
    padding: 0;
    text-align: center;
}

/* Dashboard Container */
.dashboard {
    width: 80%;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    text-align: left;
}

/* Header Styling */
h2 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

/* Navigation Menu */
.nav {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 20px;
}

.nav a {
    text-decoration: none;
    padding: 12px 20px;
    background-color: #4285F4;
    color: white;
    border-radius: 6px;
    font-weight: bold;
    transition: 0.3s ease-in-out;
}

.nav a:hover {
    background-color: #357ae8;
    transform: scale(1.05);
}

/* Logout Button */
.logout-btn {
    float: right;
    background-color: #e74c3c;
    padding: 10px 16px;
    text-decoration: none;
    color: white;
    border-radius: 6px;
    font-weight: bold;
    transition: 0.3s;
}

.logout-btn:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

/* Messages & Errors */
.msg {
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
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background: #4285F4;
    color: white;
    font-weight: bold;
}

td {
    background: white;
}

tr:hover {
    background: #f1f1f1;
}

/* Form Styling */
form {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 50%;
    margin: 20px auto;
    text-align: left;
}

form label {
    display: block;
    font-weight: bold;
    margin: 10px 0 5px;
}

form input[type="text"],
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
}

form input[type="submit"] {
    background-color: #4285F4;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

form input[type="submit"]:hover {
    background-color: #357ae8;
    transform: scale(1.05);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .dashboard {
        width: 90%;
        padding: 20px;
    }

    .nav {
        flex-direction: column;
        gap: 10px;
    }

    form {
        width: 90%;
    }
}

    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, Admin!</h2>
        <a href="logout.php" class="logout-btn">Logout</a>

        <!-- Navigation Menu -->
        <div class="nav">
            <a href="admin_dashboard.php?section=users">User Management</a>
            <a href="admin_dashboard.php?section=doctors">Doctor Management</a>
            <a href="admin_dashboard.php?section=add_doctor">Add Doctor</a>
        </div>

        <!-- Display any messages or errors -->
        <?php
        if (!empty($msg)) {
            echo "<p class='msg'>" . htmlspecialchars($msg) . "</p>";
        }
        if (!empty($error)) {
            echo "<p class='error'>" . htmlspecialchars($error) . "</p>";
        }
        ?>

        <?php
        // -------------------------
        // Users Management Section
        // -------------------------
        if ($section === 'users') {
            echo "<h3>User Management</h3>";
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>" . htmlspecialchars($row['username']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>{$row['role']}</td>
                            <td>
                                <a href='edit_user.php?id={$row['id']}'>Edit</a> | 
                                <a href='delete_user.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No users found.</p>";
            }
        }
        // --------------------------
        // Doctor Management Section
        // --------------------------
        elseif ($section === 'doctors') {
            echo "<h3>Doctor Management</h3>";
            $sql = "SELECT id, name, email, specialty FROM doctors";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Specialty</th>
                            <th>Action</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['specialty']) . "</td>
                            <td>
                                <a href='admin_dashboard.php?section=delete_doctor&id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this doctor?\")'>Delete</a>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No doctors found.</p>";
            }
        }
        // ---------------------------
        // Add Doctor Form Section
        // ---------------------------
        elseif ($section === 'add_doctor') {
            ?>
            <h3>Add New Doctor</h3>
            <form method="post" action="admin_dashboard.php?section=add_doctor">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Doctor's full name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Doctor's email" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                
                <label for="specialty">Specialty:</label>
                <select id="specialty" name="specialty" required>
                    <option value="">-- Select Specialty --</option>
                    <option value="Psychiatrists">Psychiatrists</option>
                    <option value="Clinical Psychologists">Clinical Psychologists</option>
                    <option value="Counseling Psychologists">Counseling Psychologists</option>
                    <option value="Therapists">Therapists</option>
                    <option value="Mental Health Counselors">Mental Health Counselors</option>
                    <option value="Marriage and Family Therapists">Marriage and Family Therapists</option>
                    <option value="Neuropsychologists">Neuropsychologists</option>
                    <option value="Behavioral Therapists">Behavioral Therapists</option>
                    <option value="Addiction Counselors">Addiction Counselors</option>
                </select>
                
                <input type="submit" value="Add Doctor">
            </form>
            <?php
        } else {
            echo "<p>Please select a section from the navigation menu.</p>";
        }
        ?>
    </div>
</body>
</html>

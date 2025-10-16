Instruction on how to run application:
To install and run the Admin, Doctor, and Patient Management System on your local computer using XAMPP, follow these instructions.

Install XAMPP first.
Install XAMPP by downloading it from Apache Friends.
Launch the XAMPP Control Panel by opening:
Apache (for HTML and PHP files)
MySQL (for database)
Step Two: Configure the Database
Go to http://localhost/phpmyadmin/ to launch phpMyAdmin. Then, choose Databases → Make a new database with the name admin_panel.
To create tables, select the SQL tab and execute the script below:
SQL
Copy and Edit the admin user table
FORM TABLE admin (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL);

-- Table for doctors
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    specialty VARCHAR(100) NOT NULL
);

-- Table for patients
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL
);
Insert test admin credentials (optional):
sql
Copy
Edit
INSERT INTO admin (username, password) VALUES ('admin', MD5('admin123'));
 Step 3: Set Up the Project Files
Navigate to XAMPP installation folder (C:\xampp\htdocs\).
Create a new folder named:
 admin_panel
Copy all PHP, CSS, and database files into this folder.
 Step 4: Configure Database Connection
Open db.php and update database details:
php
Copy
Edit
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "admin_panel";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
 Step 5: Run the Application
Open XAMPP Control Panel and start Apache & MySQL.
Open your browser and visit:
 http://localhost/admin_panel/index.php
Choose Admin, Doctor, or Patient Login to access their respective dashboards.
Admin can manage doctors and patients.
Doctors can log in to manage patient records.
Patients can register, log in, and book appointments.
 Step 6: Logout and Session Management
To logout, users can click the Logout button, which redirects them to index.php and destroys the session.

Your Application is Now Running! 🚀
This setup ensures a secure, efficient, and functional healthcare management system. Let me know if you need further enhancements! 

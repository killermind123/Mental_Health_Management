<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    $conn->query("UPDATE users SET username='$username', email='$email', role='$role' WHERE id=$id");
    header("Location: admin_dashboard.php");
}
?>

<form method="post">
    Username: <input type="text" name="username" value="<?php echo $row['username']; ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
    Role:
    <select name="role">
        <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
        <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
    </select><br>
    <button type="submit">Update</button>
</form>

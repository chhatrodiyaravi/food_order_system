<?php
// Run this script once to create an admin user. Then delete this file.
include 'config/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('".$conn->real_escape_string($name)."','".$conn->real_escape_string($email)."','".$password."','admin')";
    if ($conn->query($sql)) {
        echo "Admin created. Delete install_admin.php for security.";
    } else { echo 'Error: '.$conn->error; }
    exit;
}
?>
<!doctype html>
<form method="POST">
  <h2>Create Admin User (run once)</h2>
  <input name="name" placeholder="Name" required><br>
  <input name="email" placeholder="Email" type="email" required><br>
  <input name="password" placeholder="Password" type="password" required><br>
  <button type="submit">Create Admin</button>
</form>

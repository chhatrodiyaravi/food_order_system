<?php
session_start();
include('../config/db.php');
include('auth_check.php');
include('layout_admin.php');

$success = "";
$error = "";

// Get current admin data
$admin_id = $_SESSION['admin_id'];
$admin = $conn->query("SELECT * FROM admins WHERE id = $admin_id")->fetch_assoc();

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    // Validate new passwords
    if ($new_pass !== $confirm_pass) {
        $error = "New passwords do not match!";
    } else {
        // Verify old password
        if (!password_verify($old_pass, $admin['password'])) {
            $error = "Old password is incorrect!";
        } else {
            // Hash new password
            $hashed = password_hash($new_pass, PASSWORD_BCRYPT);

            // Update in DB
            $conn->query("UPDATE admins SET password='$hashed' WHERE id=$admin_id");

            $success = "Password updated successfully!";
        }
    }
}

layout_start("Change Password");
?>

<div class="card p-4 shadow" style="max-width:500px;">

    <h4 class="mb-3 fw-bold text-danger">Change Admin Password</h4>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">

        <label class="form-label">Old Password</label>
        <input type="password" name="old_password" class="form-control mb-3" required>

        <label class="form-label">New Password</label>
        <input type="password" name="new_password" class="form-control mb-3" required>

        <label class="form-label">Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control mb-3" required>

        <button class="btn btn-danger w-100">Update Password</button>
    </form>

</div>

<?php layout_end(); ?>
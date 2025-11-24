<?php
session_start();
include('../config/db.php');
include('layout.php');
ob_start();

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-warning'>Please login to edit your profile.</div>";
    $content = ob_get_clean();
    renderLayout("Edit Profile", $content);
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

$success = "";
$error = "";

// When user submits form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    // Update name + email
    $update = $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$user_id");

    // If password change requested
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $conn->query("UPDATE users SET password='$password' WHERE id=$user_id");
    }

    $success = "Profile updated successfully!";
    // Refresh user data
    $result = $conn->query("SELECT * FROM users WHERE id = $user_id");
    $user = $result->fetch_assoc();

    // Update session name
    $_SESSION['user_name'] = $user['name'];
}
?>

<h3 class="fw-bold text-danger mb-4">Edit Profile</h3>

<div class="card shadow p-4" style="max-width:600px;">

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" required>
        </div>

        <hr>

        <h6 class="fw-bold">Change Password (Optional)</h6>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep old password">
        </div>

        <button class="btn btn-danger w-100 mt-3">Save Changes</button>

    </form>
</div>

<?php
$content = ob_get_clean();
renderLayout("Edit Profile", $content);
?>
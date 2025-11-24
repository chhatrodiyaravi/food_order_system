<?php
session_start();
include('../config/db.php');
include('layout.php');
ob_start();

// If user not logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-warning'>Please login to view your profile.</div>";
    $content = ob_get_clean();
    renderLayout("My Profile", $content);
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
?>

<h3 class="fw-bold text-danger mb-4">My Profile</h3>

<div class="card shadow p-4 mb-4" style="max-width:600px;">

    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
            alt="Profile"
            width="100"
            class="rounded-circle shadow-sm mb-3">
        <h4 class="fw-bold"><?php echo htmlspecialchars($user['name']); ?></h4>
        <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <hr>

    <p><strong>User ID:</strong> <?php echo $user['id']; ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <p><strong>Joined:</strong> <?php echo date("d M, Y", strtotime($user['created_at'])); ?></p>

    <div class="mt-4">
        <a href="edit_profile.php" class="btn btn-primary w-100 mb-2">
            <i class="bi bi-pencil-square"></i> Edit Profile
        </a>

        <a href="my_orders.php" class="btn btn-danger w-100 mb-2">
            <i class="bi bi-receipt"></i> View My Orders
        </a>

        <a href="logout.php" class="btn btn-outline-secondary w-100">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

</div>

<?php
$content = ob_get_clean();
renderLayout("My Profile", $content);
?>
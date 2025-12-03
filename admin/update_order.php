<?php
session_start();
include('../config/db.php');
include('auth_check.php');
include('layout_admin.php');

if (!isset($_GET['id'])) die("Invalid Order ID");

$id = intval($_GET['id']);

$order = $conn->query("SELECT * FROM orders WHERE id=$id")->fetch_assoc();

if (!$order) die("Order not found");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$id");
    header("Location: orders.php?updated=1");
    exit;
}

layout_start("Update Order Status");
?>

<div class="card p-4 shadow" style="max-width:450px;">
    <h4>Order #<?php echo $order['id']; ?></h4>

    <form method="POST" class="mt-3">

        <label class="form-label">Update Status</label>
        <select name="status" class="form-select" required>
            <option <?php if ($order['status'] == "Pending") echo "selected"; ?>>Pending</option>
            <option <?php if ($order['status'] == "Accepted") echo "selected"; ?>>Accepted</option>
            <option <?php if ($order['status'] == "Preparing") echo "selected"; ?>>Preparing</option>
            <option <?php if ($order['status'] == "Out for Delivery") echo "selected"; ?>>Out for Delivery</option>
            <option <?php if ($order['status'] == "Delivered") echo "selected"; ?>>Delivered</option>
            <option <?php if ($order['status'] == "Cancelled") echo "selected"; ?>>Cancelled</option>
        </select>

        <button class="btn btn-danger mt-3 w-100">Save Changes</button>

    </form>

    <a href="orders.php" class="btn btn-secondary mt-3 w-100">Back</a>
</div>

<?php layout_end(); ?>
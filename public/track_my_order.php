<?php
session_start();
include('../config/db.php');
include('layout.php');
ob_start();

if (!isset($_SESSION['last_order_id'])) {
    echo "<div class='alert alert-warning'>You do not have any active orders.</div>";
    $content = ob_get_clean();
    renderLayout("Track Order", $content);
    exit;
}

$order_id = $_SESSION['last_order_id'];
$result = $conn->query("SELECT * FROM orders WHERE id = $order_id");

if ($result->num_rows == 0) {
    echo "<div class='alert alert-danger'>Order not found.</div>";
    $content = ob_get_clean();
    renderLayout("Track Order", $content);
    exit;
}

$order = $result->fetch_assoc();
?>

<h3 class="fw-bold text-danger mb-4">Order Tracking</h3>

<div class="card shadow p-4 mb-4">
    <h4>Order #<?php echo $order['id']; ?></h4>
    <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
    <p><strong>Total:</strong> ₹<?php echo $order['total_amount']; ?></p>
    <p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>
</div>

<!-- Progress Bar -->
<?php
$stages = ['Pending', 'Accepted', 'Preparing', 'Out for Delivery', 'Delivered'];
$current = array_search($order['status'], $stages);
?>

<div class="progress" style="height:30px;">
    <?php foreach ($stages as $i => $stage): ?>
        <div class="progress-bar
            <?php echo ($i <= $current) ? 'bg-success' : 'bg-secondary'; ?>"
            style="width:<?php echo 100 / count($stages); ?>%;">
            <?php echo $stage; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
renderLayout("Track Order", $content);
?>
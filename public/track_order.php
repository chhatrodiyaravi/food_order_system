<?php
session_start();
include('../config/db.php');
include('layout.php');
ob_start();

// Check if order id is passed in URL
$order = null;

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM orders WHERE id = $order_id");

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    }
}
?>

<h3 class="fw-bold text-danger mb-4">Track Your Order</h3>

<!-- Search Box -->
<form method="GET" class="card shadow p-4 mb-4" style="max-width:500px;">
    <label class="form-label">Enter Order ID</label>
    <input type="number" name="id" class="form-control" placeholder="Example: 12" required>
    <button class="btn btn-danger mt-3 w-100">Track Order</button>
</form>

<?php if ($order): ?>

    <div class="card shadow p-4 mb-4">
        <h5 class="fw-bold text-danger">Order #<?php echo $order['id']; ?></h5>
        <p><strong>Customer:</strong> <?php echo $order['customer_name']; ?></p>
        <p><strong>Total:</strong> ₹<?php echo $order['total_amount']; ?></p>
        <p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>
        <p><strong>Payment:</strong> <?php echo $order['payment_method']; ?></p>
        <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
    </div>

    <!-- Status Progress Bar -->
    <h5 class="fw-bold mb-3">Order Status</h5>

    <?php
    // Order stages
    $stages = ['Pending', 'Accepted', 'Preparing', 'Out for Delivery', 'Delivered', 'Cancelled'];

    // Find current stage index
    $current_stage = array_search($order['status'], $stages);
    ?>

    <div class="progress" style="height:30px;">
        <?php foreach ($stages as $index => $stage): ?>
            <div class="progress-bar 
                <?php echo ($index <= $current_stage) ? 'bg-success' : 'bg-secondary'; ?>"
                style="width: <?php echo 100 / count($stages); ?>%;">
                <?php echo $stage; ?>
            </div>
        <?php endforeach; ?>
    </div>

<?php elseif (isset($_GET['id'])): ?>

    <div class="alert alert-danger mt-4">Order not found!</div>

<?php endif; ?>

<?php
$content = ob_get_clean();
renderLayout("Track Order", $content);
?>
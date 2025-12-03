<?php
session_start();
include('../config/db.php');
include('layout.php');
ob_start();

if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-warning'>Please login to view your orders.</div>";
    $content = ob_get_clean();
    renderLayout("My Orders", $content);
    exit;
}

$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT * FROM orders WHERE user_id=$user_id ORDER BY id DESC");
?>

<h3 class="fw-bold text-danger mb-4">My Orders</h3>

<?php if ($res->num_rows == 0): ?>
    <div class="alert alert-info">You haven't placed any orders yet.</div>
<?php else: ?>

    <?php while ($order = $res->fetch_assoc()): ?>
        <div class="card shadow-sm mb-3 p-3">

            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold">Order #<?php echo $order['id']; ?></h5>
                <span class="badge 
                    <?php
                    echo match ($order['status']) {
                        'Pending' => 'bg-secondary',
                        'Accepted' => 'bg-info',
                        'Preparing' => 'bg-warning',
                        'Out for Delivery' => 'bg-primary',
                        'Delivered' => 'bg-success',
                        'Cancelled' => 'bg-danger',
                        default => 'bg-dark'
                    };
                    ?>">
                    <?php echo $order['status']; ?>
                </span>
            </div>

            <p class="mt-2 mb-1"><strong>Total:</strong> ₹<?php echo $order['total_amount']; ?></p>
            <p class="mb-1"><strong>Date:</strong> <?php echo $order['created_at']; ?></p>
            <p class="mb-2"><strong>Address:</strong> <?php echo $order['address']; ?></p>


            <!-- ✅ Cancel Button (Only for Pending Orders) -->
            <?php if ($order['status'] == 'Pending'): ?>
                <a href="cancel_order.php?id=<?php echo $order['id']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to cancel this order?');">
                    Cancel Order
                </a>
            <?php endif; ?>


        </div>
    <?php endwhile; ?>

<?php endif; ?>

<?php
$content = ob_get_clean();
renderLayout("My Orders", $content);
?>
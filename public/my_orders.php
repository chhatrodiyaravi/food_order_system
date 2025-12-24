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

            <?php
            // show order items
            $oi = $conn->query("SELECT oi.*, fi.name, fi.image FROM order_items oi LEFT JOIN food_items fi ON fi.id = oi.food_id WHERE oi.order_id = " . intval($order['id']));
            if ($oi && $oi->num_rows > 0):
            ?>
                <div class="mt-3">
                    <h6>Items</h6>
                    <?php while ($it = $oi->fetch_assoc()): ?>
                        <div class="d-flex align-items-center mb-2">
                            <img src="/food_order_system/uploads/<?php echo htmlspecialchars($it['image']); ?>" width="60" height="45" style="object-fit:cover;" class="me-3">
                            <div class="flex-grow-1">
                                <strong><?php echo htmlspecialchars($it['name']); ?></strong>
                                <div class="small text-muted">Qty: <?php echo intval($it['quantity']); ?> — ₹<?php echo number_format($it['price'], 2); ?></div>
                            </div>

                            <?php if ($order['status'] === 'Delivered' && isset($_SESSION['user_id'])): ?>
                                <?php
                                $uid = intval($_SESSION['user_id']);
                                $ur = $conn->query("SELECT rating FROM ratings WHERE user_id=$uid AND food_id=" . intval($it['food_id']) . " LIMIT 1");
                                $user_rating = ($ur && $ur->num_rows) ? intval($ur->fetch_assoc()['rating']) : 0;
                                ?>
                                <div class="ms-3 text-center">
                                    <?php if ($user_rating > 0): ?>
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <i class="bi <?php echo ($s <= $user_rating) ? 'bi-star-fill text-warning' : 'bi-star text-muted'; ?>"></i>
                                        <?php endfor; ?>
                                        <div><a href="rate.php?id=<?php echo intval($it['food_id']); ?>" class="small">Edit</a></div>
                                    <?php else: ?>
                                        <form method="POST" action="rate.php">
                                            <input type="hidden" name="food_id" value="<?php echo intval($it['food_id']); ?>">
                                            <input type="hidden" name="redirect" value="my_orders.php">
                                            <div class="btn-group" role="group" aria-label="rating">
                                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                                    <button type="submit" name="rating" value="<?php echo $s; ?>" class="btn btn-sm btn-outline-secondary">
                                                        <?php echo $s; ?> <i class="bi bi-star-fill text-warning"></i>
                                                    </button>
                                                <?php endfor; ?>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

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
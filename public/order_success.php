<?php
session_start();

if (!isset($_SESSION['last_order_id'])) {
    echo "<div class='alert alert-info'>No active order to track.</div>";
    exit;
}

$order_id = $_SESSION['last_order_id'];
?>

<a href="track_my_order.php" class="btn btn-danger mt-3">
    Track My Order
</a>
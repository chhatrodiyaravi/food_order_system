<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$order_id = intval($_GET['id']);
$user_id  = $_SESSION['user_id'];

// Check if the order is pending and belongs to the user
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? AND status = 'Pending'");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Order cannot be cancelled");
}

// Cancel the order
$update = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
$update->bind_param("i", $order_id);
$update->execute();

echo "<script>alert('Order cancelled successfully'); window.location.href='my_orders.php';</script>";

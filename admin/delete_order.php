<?php
session_start();
include('../config/db.php');
include('auth_check.php');

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit;
}

$id = intval($_GET['id']);

// 1. Delete child records first (order items)
$conn->query("DELETE FROM order_items WHERE order_id = $id");

// 2. Now delete the order
$conn->query("DELETE FROM orders WHERE id = $id");

header("Location: orders.php?deleted=1");
exit;

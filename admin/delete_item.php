<?php
session_start();
include('../config/db.php');
include('auth_check.php');

if (!isset($_GET['id'])) {
    header("Location: items.php");
    exit;
}

$id = intval($_GET['id']);
// Check for existing references in order_items to avoid foreign key constraint error
$check = $conn->query("SELECT COUNT(*) AS cnt FROM order_items WHERE food_id=$id");
if ($check) {
    $row = $check->fetch_assoc();
    if ($row['cnt'] > 0) {
        // Item is referenced by orders; do not delete
        header("Location: items.php?error=referenced");
        exit;
    }
}

$deleted = $conn->query("DELETE FROM food_items WHERE id=$id");
if ($deleted) {
    header("Location: items.php?deleted=1");
    exit;
} else {
    header("Location: items.php?error=db");
    exit;
}

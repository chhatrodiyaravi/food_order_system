<?php
session_start();
include('../config/db.php');
include('auth_check.php');

if (!isset($_GET['id'])) {
    header("Location: items.php");
    exit;
}

$id = intval($_GET['id']);
$conn->query("DELETE FROM food_items WHERE id=$id");
header("Location: items.php?deleted=1");
exit;

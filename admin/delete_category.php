<?php
session_start();
include('../config/db.php');
include('auth_check.php');

if (!isset($_GET['id'])) {
    header("Location: categories.php");
    exit;
}

$id = intval($_GET['id']);
$conn->query("DELETE FROM categories WHERE id=$id");
header("Location: categories.php?deleted=1");
exit;

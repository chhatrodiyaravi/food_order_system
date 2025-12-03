<?php
session_start();

if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
    header("Location: cart.php");
    exit;
}

$id = intval($_POST['id']);
$qty = intval($_POST['quantity']);

// If cart item doesn't exist
if (!isset($_SESSION['cart'][$id])) {
    header("Location: cart.php");
    exit;
}

// If user enters 0 or negative → remove item
if ($qty <= 0) {
    unset($_SESSION['cart'][$id]);
} else {
    // Update quantity
    $_SESSION['cart'][$id]['quantity'] = $qty;
}

header("Location: cart.php");
exit;

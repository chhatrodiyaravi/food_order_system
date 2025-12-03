<?php
// NOTE: This is a minimal example. In production you MUST verify the payment signature server-side using Razorpay SDK and your secret.
include('../config/db.php');
$razorpay_payment_id = $_POST['razorpay_payment_id'];
$order_id = intval($_POST['order_id']);
if ($razorpay_payment_id && $order_id) {
  // mark payment success
  $conn->query("UPDATE orders SET payment_method='Online', status='Accepted' WHERE id=$order_id");
  // clear cart of the user who placed this order
  $res = $conn->query("SELECT user_id FROM orders WHERE id=$order_id");
  $uid = $res->fetch_assoc()['user_id'];
  $conn->query("DELETE FROM cart WHERE user_id=$uid");
  echo 'OK';
}
?>
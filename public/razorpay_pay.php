<?php
session_start();
include('../config/db.php');
include('../config/razorpay.php');
if (!isset($_SESSION['pending_order_id'])) { header('Location: index.php'); exit; }
$order_id = $_SESSION['pending_order_id'];
$res = $conn->query("SELECT o.*, u.name, u.email FROM orders o JOIN users u ON o.user_id=u.id WHERE o.id=$order_id");
$order = $res->fetch_assoc();
$amount_paise = $order['total'] * 100;
?>
<!doctype html><html><head><script src="https://checkout.razorpay.com/v1/checkout.js"></script></head><body>
<h3>Pay ₹<?php echo $order['total']; ?> with Razorpay</h3>
<button id="rzp-button">Pay Now</button>
<script>
var options = {
    "key": "<?php echo RAZORPAY_KEY_ID; ?>",
    "amount": "<?php echo $amount_paise; ?>",
    "currency": "INR",
    "name": "FoodOrder",
    "description": "Order #<?php echo $order['id']; ?>",
    "handler": function (response){
        // On success, call server to verify & mark payment
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'verify_payment.php', true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.onload = function(){ window.location='order_success.php'; }
        xhr.send('razorpay_payment_id='+response.razorpay_payment_id+'&order_id='+<?php echo $order['id']; ?>);
    }
};
document.getElementById('rzp-button').onclick = function(e){
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
}
</script>
</body></html>

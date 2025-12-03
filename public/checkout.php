<?php
session_start();
include('../config/db.php');
include('../public/layout.php');
ob_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
  header("Location: cart.php");
  exit;
}

// Calculate total
$grand_total = 0;
foreach ($_SESSION['cart'] as $item) {
  $grand_total += $item['price'] * $item['quantity'];
}

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $address = $conn->real_escape_string($_POST['address']);
  $total = $grand_total;
  $status = 'Pending';
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

  // Insert order
  $query = "INSERT INTO orders (customer_name, email, phone, user_id, total_amount, status, address, payment_method, created_at)
            VALUES ('$name', '$email', '$phone', $user_id, $total, '$status', '$address', 'COD', NOW())";
  $conn->query($query);
  $order_id = $conn->insert_id;

  // Insert order items
  $items_list = "";
  foreach ($_SESSION['cart'] as $item) {
    $fid = $item['id'];
    $qty = $item['quantity'];
    $price = $item['price'];
    $conn->query("INSERT INTO order_items (order_id, food_id, quantity, price) VALUES ($order_id,$fid,$qty,$price)");
    $items_list .= $item['name'] . " (x{$qty}), ";
  }
  $items_list = rtrim($items_list, ", ");

  // Update order items summary
  $conn->query("UPDATE orders SET items='$items_list' WHERE id=$order_id");

  // Show success
  unset($_SESSION['cart']);
  echo "<div class='container py-5 text-center'>
          <div class='alert alert-success shadow-sm'>
            <h4 class='fw-bold text-success mb-2'>🎉 Order Placed Successfully!</h4>
            <p>Your Order ID: <strong>#{$order_id}</strong></p>
            <p>Payment Method: <strong>Cash on Delivery</strong></p>
            <p>Thank you for ordering with FoodKart.</p>
            <a href='my_orders.php' class='btn btn-danger mt-3'>View My Orders</a>
          </div>
        </div>";
  $content = ob_get_clean();
  renderLayout('Order Success', $content);
  exit;
}
?>

<div class="container py-5">
  <h3 class="fw-bold text-danger mb-4"><i class="bi bi-credit-card"></i> Checkout</h3>

  <div class="row">
    <!-- LEFT: Delivery Details -->
    <div class="col-md-7">
      <div class="card p-4 shadow-sm border-0">
        <h5 class="fw-bold mb-3">Delivery Details</h5>
        <form method="POST" id="checkoutForm">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Delivery Address</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
          </div>

          <button type="submit" name="place_order" class="btn btn-danger w-100 py-2 fw-bold">
            <i class="bi bi-check-circle"></i> Place Order
          </button>
        </form>
      </div>
    </div>

    <!-- RIGHT: Order Summary -->
    <div class="col-md-5">
      <div class="card p-4 shadow-sm border-0">
        <h5 class="fw-bold mb-3">Order Summary</h5>

        <div style="max-height: 300px; overflow-y: auto;">
          <?php foreach ($_SESSION['cart'] as $item): ?>
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
              <div>
                <p class="mb-0"><strong><?php echo htmlspecialchars($item['name']); ?></strong></p>
                <small class="text-muted">₹<?php echo number_format($item['price'], 2); ?> x <?php echo $item['quantity']; ?></small>
              </div>
              <p class="mb-0 fw-bold">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="mt-3 pt-3 border-top">
          <div class="d-flex justify-content-between mb-2">
            <p class="mb-0">Subtotal:</p>
            <p class="mb-0">₹<?php echo number_format($grand_total, 2); ?></p>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <p class="mb-0">Delivery:</p>
            <p class="mb-0 text-success">FREE</p>
          </div>
          <div class="d-flex justify-content-between fs-5 fw-bold">
            <p>Total:</p>
            <p class="text-danger">₹<?php echo number_format($grand_total, 2); ?></p>
          </div>
        </div>

        <div class="alert alert-info mt-3 mb-0">
          <small><i class="bi bi-info-circle"></i> Payment on Delivery (COD) - Pay when you receive your order</small>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
renderLayout('Checkout', $content);
?>
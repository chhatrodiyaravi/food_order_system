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

// Handle COD order placement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $address = $conn->real_escape_string($_POST['address']);
  $payment_method = $_POST['payment_method'];
  $total = $grand_total;
  $status = ($payment_method == 'COD') ? 'Pending' : 'Paid';
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

  // ✅ Insert order details matching your table structure
  $query = "INSERT INTO orders (customer_name, email, phone, user_id, total_amount, status, address, payment_method, created_at)
            VALUES ('$name', '$email', '$phone', $user_id, $total, '$status', '$address', '$payment_method', NOW())";
  $conn->query($query);
  $order_id = $conn->insert_id;

  // ✅ Insert order items
  foreach ($_SESSION['cart'] as $item) {
    $fid = $item['id'];
    $qty = $item['quantity']
    $price = $item['price'];
    $conn->query("INSERT INTO order_items (order_id, food_id, quantity, price)
                  VALUES ($order_id,$fid,$qty,$price)");
  }

  unset($_SESSION['cart']);

  echo "<div class='container py-5 text-center'>
          <div class='alert alert-success shadow-sm'>
            <h4 class='fw-bold text-success mb-2'>🎉 Order Placed Successfully!</h4>
            <p>Your Order ID: <strong>#{$order_id}</strong></p>
            <p>Thank you for ordering with FoodKart.</p>
            <a href='index.php' class='btn btn-danger mt-3'>Back to Home</a>
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
            <textarea name="address" rows="3" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-select" required>
              <option value="COD">Cash on Delivery (COD)</option>
              <option value="Online">Online Payment (Razorpay)</option>
            </select>
          </div>

          <div class="text-end">
            <button type="submit" name="place_order" id="codBtn" class="btn btn-danger px-4">Place COD Order</button>
            <button type="button" id="payOnlineBtn" class="btn btn-success px-4 d-none">Pay Online</button>
          </div>
        </form>
      </div>
    </div>

    <!-- RIGHT: Order Summary -->
    <div class="col-md-5">
      <div class="card p-4 shadow-sm border-0">
        <h5 class="fw-bold mb-3">Order Summary</h5>
        <ul class="list-group mb-3">
          <?php foreach ($_SESSION['cart'] as $item): ?>
            <?php $total = $item['price'] * $item['quantity']; ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                <small>Qty: <?php echo $item['quantity']; ?></small>
              </div>
              <span>₹<?php echo number_format($total, 2); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="d-flex justify-content-between">
          <h5>Total:</h5>
          <h5 class="text-success fw-bold">₹<?php echo number_format($grand_total, 2); ?></h5>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  const paymentSelect = document.getElementById("payment_method");
  const codBtn = document.getElementById("codBtn");
  const payOnlineBtn = document.getElementById("payOnlineBtn");

  // Toggle buttons based on selected payment method
  paymentSelect.addEventListener("change", function() {
    if (this.value === "Online") {
      codBtn.classList.add("d-none");
      payOnlineBtn.classList.remove("d-none");
    } else {
      codBtn.classList.remove("d-none");
      payOnlineBtn.classList.add("d-none");
    }
  });

  // Razorpay integration
  payOnlineBtn.onclick = function(e) {
    e.preventDefault();

    var options = {
      "key": "rzp_test_yourKeyHere", // Replace with your Razorpay Test Key ID
      "amount": "<?php echo $grand_total * 100; ?>", // amount in paise
      "currency": "INR",
      "name": "FoodKart",
      "description": "Online Food Order Payment",
      "image": "/food_order_system/uploads/logo.png",
      "handler": function(response) {
        window.location.href = "payment_success.php?payment_id=" + response.razorpay_payment_id;
      },
      "theme": {
        "color": "#dc3545"
      }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
  };
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
  $(document).ready(function() {

    $("#checkoutForm").validate({
      rules: {
        name: {
          required: true,
          minlength: 3
        },
        email: {
          required: true,
          email: true
        },
        phone: {
          required: true,
          digits: true,
          minlength: 10,
          maxlength: 10
        },
        address: {
          required: true,
          minlength: 5
        },
        payment_method: {
          required: true
        }
      },

      messages: {
        name: {
          required: "Please enter your full name",
          minlength: "Name must be at least 3 characters"
        },
        email: {
          required: "Please enter email address",
          email: "Enter a valid email"
        },
        phone: {
          required: "Please enter phone number",
          digits: "Phone must contain digits only",
          minlength: "Enter 10-digit phone",
          maxlength: "Enter 10-digit phone"
        },
        address: {
          required: "Please enter delivery address",
          minlength: "Address is too short"
        },
        payment_method: {
          required: "Please select a payment method"
        }
      },

      errorClass: "text-danger small",
      errorElement: "div",

      highlight: function(element) {
        $(element).addClass("is-invalid");
      },

      unhighlight: function(element) {
        $(element).removeClass("is-invalid");
      }
    });

  });
</script>


<?php
$content = ob_get_clean();
renderLayout("Checkout", $content);
?>
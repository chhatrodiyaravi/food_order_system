<?php
session_start();
require_once '../config/db.php';
require_once '../public/layout.php';

// Start output buffering
ob_start();
?>

<h2 class="fw-bold text-danger mb-3">Welcome to FoodKart</h2>
<p class="text-muted mb-4">Choose your favorite food and order now 🍕🍔</p>

<?php
// Show login reminder for guests
if (!isset($_SESSION['user_id'])): ?>
<?php endif; ?>

<!-- Example of dynamic content -->
<?php
$result = $conn->query("SELECT * FROM food_items WHERE available=1");
?>
<div class="row">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm">
        <img src="/food_order_system/uploads/<?php echo htmlspecialchars($row['image']); ?>"
          class="card-img-top"
          style="height:200px;object-fit:cover;"
          alt="<?php echo htmlspecialchars($row['name']); ?>">
        <div class="card-body text-center">
          <h5 class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></h5>
          <p class="text-muted small mb-2"><?php echo htmlspecialchars($row['description']); ?></p>
          <p class="fw-bold text-success fs-5 mb-3">₹<?php echo number_format($row['price'], 2); ?></p>

          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- User logged in → can add to cart -->
            <a href="/food_order_system/public/cart.php?action=add&id=<?php echo $row['id']; ?>"
              class="btn btn-success btn-sm px-4">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </a>
          <?php else: ?>
            <!-- User not logged in → redirect to login -->
            <a href="/food_order_system/public/login.php?msg=Please login to add items"
              class="btn btn-outline-secondary btn-sm px-4">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php
// Get the buffered HTML and clear the buffer
$content = ob_get_clean();

// Render the full layout
renderLayout("Home - FoodKart", $content);
?>
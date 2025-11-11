<?php
require_once '../config/db.php';
require_once '../public/layout.php';

// start output buffering
ob_start();
?>



<h2>Welcome</h2>
<p>Choose your favorite food and order now</p>

<!-- Example of some dynamic content -->
<?php
$result = $conn->query("SELECT * FROM food_items WHERE available=1");
?>
<div class="row">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-3">
      <div class="card">
        <!-- <img src="../uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height:200px;object-fit:cover;"> -->
        <img src="/food_order_system/uploads/<?php echo $row['image']; ?>"
          class="card-img-top"
          style="height:200px;object-fit:cover;">

        <div class="card-body">
          <h5><?php echo htmlspecialchars($row['name']); ?></h5>
          <p>₹<?php echo $row['price']; ?></p>
          <a href="/food_order_system/public/cart.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Add to Cart</a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php
// get the buffered HTML and clear the buffer
$content = ob_get_clean();

// call layout
renderLayout("Home - FoodOrder System", $content);
?>
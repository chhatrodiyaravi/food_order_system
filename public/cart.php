<?php
session_start();
include('../config/db.php');
include('../public/layout.php');
ob_start();

/* -------------------------------
   ADD TO CART
--------------------------------*/
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
  $id = intval($_GET['id']);

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=Please login first to add items to your cart");
    exit;
  }

  $result = $conn->query("SELECT * FROM food_items WHERE id=$id AND available=1");

  if ($result && $result->num_rows > 0) {
    $item = $result->fetch_assoc();

    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
      $_SESSION['cart'][$id] = [
        'id' => $item['id'],
        'name' => $item['name'],
        'price' => $item['price'],
        'image' => $item['image'],
        'quantity' => 1
      ];
    }
  }

  header("Location: cart.php");
  exit;
}

/* -------------------------------
   REMOVE ITEM
--------------------------------*/
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  unset($_SESSION['cart'][$id]);
  header("Location: cart.php");
  exit;
}

/* -------------------------------
   CLEAR CART
--------------------------------*/
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
  unset($_SESSION['cart']);
  header("Location: cart.php");
  exit;
}
?>

<div class="container py-5">
  <h3 class="fw-bold text-danger mb-4"><i class="bi bi-cart3"></i> My Cart</h3>

  <?php if (empty($_SESSION['cart'])): ?>
    <div class="alert alert-info">Your cart is empty. <a href="index.php">Continue shopping</a>.</div>

  <?php else:

    /* ----------------------------------------------------
           1) Build array with category_name
        ----------------------------------------------------*/
    $cart_items = [];
    foreach ($_SESSION['cart'] as $item) {
      $id = $item['id'];

      $q = $conn->query("
                SELECT categories.name AS category_name
                FROM food_items 
                LEFT JOIN categories ON food_items.category_id = categories.id
                WHERE food_items.id = $id
            ");

      $cat = ($q && $q->num_rows > 0)
        ? $q->fetch_assoc()['category_name']
        : "Other";

      $item['category_name'] = $cat;
      $cart_items[] = $item;
    }

    /* ----------------------------------------------------
           2) Sort items by category
        ----------------------------------------------------*/
    usort($cart_items, function ($a, $b) {
      return strcmp($a['category_name'], $b['category_name']);
    });

  ?>

    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Image</th>
            <th>Food Name</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $grand_total = 0;
          $current_category = null;

          foreach ($cart_items as $item):

            // CATEGORY SEPARATOR ROW
            if ($current_category !== $item['category_name']) {
              $current_category = $item['category_name'];
              echo "<tr class='table-secondary'>
                                <th colspan='6' class='p-2 text-start'>
                                    Category: <b>$current_category</b>
                                </th>
                              </tr>";
            }

            $item_total = $item['price'] * $item['quantity'];
            $grand_total += $item_total;
          ?>

            <tr>
              <td><img src="/food_order_system/uploads/<?php echo $item['image']; ?>" width="80" height="60" style="object-fit:cover;"></td>

              <td><?php echo htmlspecialchars($item['name']); ?></td>

              <td>₹<?php echo number_format($item['price'], 2); ?></td>

              <td>
                <form action="update_quantity.php" method="POST" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                  <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control text-center" style="width:70px;"
                    onchange="this.form.submit()">
                </form>
              </td>

              <td>₹<?php echo number_format($item_total, 2); ?></td>

              <td>
                <a href="cart.php?action=remove&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>

          <?php endforeach; ?>

        </tbody>
      </table>
    </div>

    <!-- BOTTOM Total + Buttons -->
    <div class="text-end mt-3">
      <h5 class="fw-bold">Grand Total:
        <span class="text-success">₹<?php echo number_format($grand_total, 2); ?></span>
      </h5>

      <div class="mt-3">
        <a href="cart.php?action=clear" class="btn btn-outline-danger me-2">
          <i class="bi bi-x-circle"></i> Clear Cart
        </a>

        <a href="index.php" class="btn btn-outline-secondary me-2">
          <i class="bi bi-arrow-left"></i> Continue Shopping
        </a>

        <a href="checkout.php" class="btn btn-success">
          <i class="bi bi-credit-card"></i> Proceed to Checkout
        </a>
      </div>
    </div>

  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
renderLayout("My Cart", $content);
?>
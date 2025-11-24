<?php
session_start();
include('../config/db.php');
include('auth_check.php');
include('layout_admin.php');

layout_start("Admin Dashboard");
?>

<div class="row mb-4">

  <!-- USERS -->
  <div class="col-md-3">
    <div class="card-box text-center">
      <i class="bi bi-people fs-1 text-danger"></i>
      <h3 class="fw-bold">
        <?php echo $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total']; ?>
      </h3>
      <p class="text-muted">Users</p>
    </div>
  </div>

  <!-- CATEGORIES -->
  <div class="col-md-3">
    <div class="card-box text-center">
      <i class="bi bi-grid-3x3-gap fs-1 text-primary"></i>
      <h3 class="fw-bold">
        <?php echo $conn->query("SELECT COUNT(*) AS total FROM categories")->fetch_assoc()['total']; ?>
      </h3>
      <p class="text-muted">Categories</p>
    </div>
  </div>

  <!-- FOOD ITEMS -->
  <div class="col-md-3">
    <div class="card-box text-center">
      <i class="bi bi-basket2-fill fs-1 text-success"></i>
      <h3 class="fw-bold">
        <?php echo $conn->query("SELECT COUNT(*) AS total FROM food_items")->fetch_assoc()['total']; ?>
      </h3>
      <p class="text-muted">Food Items</p>
    </div>
  </div>

  <!-- ORDERS -->
  <div class="col-md-3">
    <div class="card-box text-center">
      <i class="bi bi-receipt fs-1 text-warning"></i>
      <h3 class="fw-bold">
        <?php echo $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total']; ?>
      </h3>
      <p class="text-muted">Orders</p>
    </div>
  </div>

</div>

<!-- LATEST ORDERS TABLE -->
<div class="card table-card shadow">
  <div class="card-header bg-danger text-white">
    <h5 class="mb-0">Latest Orders</h5>
  </div>

  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Total</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $orders = $conn->query("SELECT * FROM orders ORDER BY id DESC LIMIT 5");
        while ($o = $orders->fetch_assoc()):
        ?>
          <tr>
            <td><?php echo $o['id']; ?></td>
            <td><?php echo $o['customer_name'] ?? 'User#' . $o['user_id']; ?></td>
            <td>₹<?php echo $o['total_amount']; ?></td>
            <td>
              <span class="badge
                <?php
                echo match ($o['status']) {
                  'Pending' => 'bg-secondary',
                  'Accepted' => 'bg-info',
                  'Preparing' => 'bg-warning',
                  'Out for Delivery' => 'bg-primary',
                  'Delivered' => 'bg-success',
                  'Cancelled' => 'bg-danger',
                  default => 'bg-dark'
                };
                ?>">
                <?php echo $o['status']; ?>
              </span>
            </td>
            <td><?php echo $o['created_at']; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php layout_end(); ?>
<?php include('auth_check.php');
include('header.php');
// Stats
$total_orders = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='Pending'")->fetch_assoc()['c'];
$total_items = $conn->query("SELECT COUNT(*) as c FROM food_items")->fetch_assoc()['c'];
$total_users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
?>
<h3>Dashboard</h3>
<div class="row">
  <div class="col-md-3">
    <div class="card p-3">
      <h5>Total Orders</h5>
      <h2><?php echo $total_orders; ?></h2>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">
      <h5>Pending</h5>
      <h2><?php echo $pending; ?></h2>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">
      <h5>Items</h5>
      <h2><?php echo $total_items; ?></h2>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">
      <h5>Users</h5>
      <h2><?php echo $total_users; ?></h2>
    </div>
  </div>
</div>
<?php include('footer.php'); ?>
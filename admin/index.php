<?php
include('../config/db.php');
$res = $conn->query("SELECT * FROM food_items");
?>
<!doctype html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4">
  <h3>Admin - Food Items</h3>
  <a class="btn btn-primary mb-3" href="add_item.php">Add Item</a>
  <table class="table"><thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Action</th></tr></thead><tbody>
  <?php while($row=$res->fetch_assoc()): ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td>₹<?php echo $row['price']; ?></td>
      <td><img src="../uploads/<?php echo $row['image']; ?>" style="height:50px"></td>
      <td><a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
    </tr>
  <?php endwhile; ?>
  </tbody></table>
</body></html>

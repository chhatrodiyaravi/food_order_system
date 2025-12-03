<?php
include('../config/db.php');
include('auth_check.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // ✅ make sure the variable is defined even if empty
  $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
  $name = $conn->real_escape_string($_POST['name']);
  $desc = $conn->real_escape_string($_POST['description']);
  $price = floatval($_POST['price']);
  $img = '';

  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $img = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $img);
  }

  // ✅ insert only if category_id > 0
  if ($category_id > 0) {
    $sql = "INSERT INTO food_items (category_id, name, description, price, image)
            VALUES ('$category_id', '$name', '$desc', $price, '$img')";
    if ($conn->query($sql)) {
      header('Location: index.php');
      exit;
    } else {
      echo "Database error: " . $conn->error;
    }
  } else {
    echo "<div style='color:red;padding:10px;'>Please select a valid category!</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Add Food Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-sm p-4">
      <h3 class="mb-4">Add New Food Item</h3>
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select" required>
            <option value="">-- Select Category --</option>
            <?php
            $result = $conn->query("SELECT * FROM categories");
            while ($row = $result->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Food Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Price (₹)</label>
          <input type="number" name="price" class="form-control" required step="0.01">
        </div>

        <div class="mb-3">
          <label class="form-label">Food Image</label>
          <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Item</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</body>

</html>
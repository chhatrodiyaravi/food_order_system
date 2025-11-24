<?php
session_start();
include('../config/db.php');
include('auth_check.php');

if (!isset($_GET['id'])) {
    die("Invalid Category ID");
}

$id = intval($_GET['id']);
$row = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $image = $row['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
    }

    $conn->query("UPDATE categories SET name='$name', image='$image' WHERE id=$id");
    header("Location: categories.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <h3>Edit Category</h3>

    <form method="POST" enctype="multipart/form-data" class="mt-3">

        <label class="form-label">Category Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>

        <label class="form-label mt-3">Image</label>
        <input type="file" name="image" class="form-control">

        <?php if ($row['image']): ?>
            <img src="/food_order_system/uploads/<?php echo $row['image']; ?>" width="100" class="mt-2">
        <?php endif; ?>

        <button class="btn btn-success mt-3">Save Changes</button>
        <a href="categories.php" class="btn btn-secondary mt-3">Back</a>
    </form>

</body>

</html>
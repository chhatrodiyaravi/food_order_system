<?php
session_start();
include('../config/db.php');
include('auth_check.php');

if (!isset($_GET['id'])) die("Invalid Item ID");

$id = intval($_GET['id']);
$item = $conn->query("SELECT * FROM food_items WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $category_id = intval($_POST['category_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $desc = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $discount_percent = isset($_POST['discount_percent']) ? floatval($_POST['discount_percent']) : 0.00;
    $discount_active = isset($_POST['discount_active']) ? 1 : 0;

    $image = $item['image'];
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
    }

    $available = isset($_POST['available']) ? 1 : 0;

    $sql = "UPDATE food_items SET 
            category_id=$category_id,
            name='$name',
            description='$desc',
            price=$price,
            discount_percent=$discount_percent,
            discount_active=$discount_active,
            image='$image',
            available=$available
            WHERE id=$id";

    $conn->query($sql);

    header("Location: items.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Food Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <h3>Edit Food Item</h3>

    <form method="POST" enctype="multipart/form-data" class="mt-3">

        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
            <?php
            $cats = $conn->query("SELECT * FROM categories");
            while ($c = $cats->fetch_assoc()):
            ?>
                <option value="<?php echo $c['id']; ?>"
                    <?php echo ($c['id'] == $item['category_id']) ? 'selected' : ''; ?>>
                    <?php echo $c['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label class="form-label mt-3">Name</label>
        <input type="text" name="name" class="form-control"
            value="<?php echo $item['name']; ?>" required>

        <label class="form-label mt-3">Description</label>
        <textarea name="description" class="form-control" rows="3" required><?php echo $item['description']; ?></textarea>

        <label class="form-label mt-3">Price</label>
        <input type="number" name="price" class="form-control"
            value="<?php echo $item['price']; ?>" required step="0.01">

        <label class="form-label mt-3">Discount Percent (%)</label>
        <input type="number" name="discount_percent" class="form-control"
            value="<?php echo isset($item['discount_percent']) ? $item['discount_percent'] : '0.00'; ?>" step="0.01" min="0" max="100">

        <label class="form-check mt-3">
            <input type="checkbox" name="discount_active" class="form-check-input"
                <?php echo (isset($item['discount_active']) && $item['discount_active'] == 1) ? 'checked' : ''; ?>>
            Enable Discount
        </label>

        <label class="form-label mt-3">Image</label>
        <input type="file" name="image" class="form-control">

        <?php if ($item['image']): ?>
            <img src="/food_order_system/uploads/<?php echo $item['image']; ?>"
                width="120" class="mt-2 rounded">
        <?php endif; ?>

        <label class="form-check mt-3">
            <input type="checkbox" name="available" class="form-check-input"
                <?php echo ($item['available'] == 1) ? 'checked' : ''; ?>>
            Available
        </label>

        <button class="btn btn-success mt-3">Save Changes</button>
        <a href="items.php" class="btn btn-secondary mt-3">Back</a>
    </form>

</body>

</html>
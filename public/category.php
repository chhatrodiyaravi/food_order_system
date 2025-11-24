<?php
session_start();
include('../config/db.php');
include('layout.php');
ob_start();

// 1. Check if id exists in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger'>No category selected!</div>";
    $content = ob_get_clean();
    renderLayout("Category Error", $content);
    exit;
}

$cat_id = intval($_GET['id']);

// 2. Fetch category
$cat = $conn->query("SELECT * FROM categories WHERE id=$cat_id")->fetch_assoc();

if (!$cat) {
    echo "<div class='alert alert-danger'>Category does not exist!</div>";
    $content = ob_get_clean();
    renderLayout("Category Error", $content);
    exit;
}
?>

<h3 class="fw-bold mb-4">Category: <?php echo htmlspecialchars($cat['name']); ?></h3>

<div class="row">
    <?php
    $items = $conn->query("SELECT * FROM food_items WHERE category_id=$cat_id AND available=1");

    if ($items->num_rows == 0) {
        echo "<div class='alert alert-warning'>No items found in this category.</div>";
    }

    while ($row = $items->fetch_assoc()):
    ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="/food_order_system/uploads/<?php echo $row['image']; ?>"
                    class="card-img-top" style="height:200px;object-fit:cover;">
                <div class="card-body">
                    <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                    <p>₹<?php echo $row['price']; ?></p>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-success">Add to Cart</a>
                    <?php else: ?>
                        <a href="login.php?msg=Please login to add items" class="btn btn-secondary">Add to Cart</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php
$content = ob_get_clean();
renderLayout($cat['name'], $content);
?>
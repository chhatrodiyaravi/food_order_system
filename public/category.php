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
                    <?php
                    // fetch average rating for this item
                    $r_q = $conn->query("SELECT AVG(rating) AS avg_rating, COUNT(*) AS cnt FROM ratings WHERE food_id=" . intval($row['id']));
                    $r_data = $r_q ? $r_q->fetch_assoc() : ['avg_rating' => 0, 'cnt' => 0];
                    $r_avg = round(floatval($r_data['avg_rating']), 1);
                    $r_cnt = intval($r_data['cnt']);
                    ?>
                    <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                    <?php if ($r_cnt > 0): ?>
                        <p class="small text-warning mb-1"><?php echo $r_avg; ?> / 5 <i class="bi bi-star-fill"></i> (<?php echo $r_cnt; ?>)</p>
                    <?php else: ?>
                        <p class="small text-muted mb-1">Not rated</p>
                    <?php endif; ?>
                    <?php
                    $price = floatval($row['price']);
                    $discounted_price = $price;
                    if (isset($row['discount_active']) && $row['discount_active'] == 1 && isset($row['discount_percent']) && $row['discount_percent'] > 0) {
                        $discounted_price = round($price * (1 - floatval($row['discount_percent']) / 100), 2);
                    }
                    ?>
                    <p>
                        <?php if ($discounted_price < $price): ?>
                            <span class="text-decoration-line-through text-muted">₹<?php echo number_format($price, 2); ?></span>
                            <span class="ms-2">₹<?php echo number_format($discounted_price, 2); ?></span>
                            <small class="badge bg-danger ms-2"><?php echo htmlspecialchars($row['discount_percent']); ?>% OFF</small>
                        <?php else: ?>
                            ₹<?php echo number_format($price, 2); ?>
                        <?php endif; ?>
                    </p>

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
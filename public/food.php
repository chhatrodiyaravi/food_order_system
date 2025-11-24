<?php
session_start();
include('../config/db.php');
include('layout.php');
ob_start();

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid food selection!</div>";
    $content = ob_get_clean();
    renderLayout("Food Detail", $content);
    exit;
}

$food_id = intval($_GET['id']);
$food = $conn->query("SELECT * FROM food_items WHERE id=$food_id")->fetch_assoc();

if (!$food) {
    echo "<div class='alert alert-danger'>Food item not found!</div>";
    $content = ob_get_clean();
    renderLayout("Food Detail", $content);
    exit;
}
?>

<div class="row py-4">

    <div class="col-md-5">
        <img src="/food_order_system/uploads/<?php echo $food['image']; ?>"
            class="img-fluid rounded shadow">
    </div>

    <div class="col-md-7">
        <h2 class="fw-bold text-danger"><?php echo $food['name']; ?></h2>

        <p class="text-muted mt-2"><?php echo $food['description']; ?></p>

        <h3 class="text-success fw-bold my-3">₹<?php echo number_format($food['price'], 2); ?></h3>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="cart.php?action=add&id=<?php echo $food['id']; ?>"
                class="btn btn-danger btn-lg px-5">
                <i class="bi bi-cart-plus"></i> Add to Cart
            </a>
        <?php else: ?>
            <a href="login.php?msg=Please login to order"
                class="btn btn-secondary btn-lg px-5">
                Login to Order
            </a>
        <?php endif; ?>

    </div>
</div>

<?php
$content = ob_get_clean();
renderLayout($food['name'], $content);
?>
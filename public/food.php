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

        <?php
        // compute discounted price if applicable
        $price = floatval($food['price']);
        $discounted_price = $price;
        if (isset($food['discount_active']) && $food['discount_active'] == 1 && isset($food['discount_percent']) && $food['discount_percent'] > 0) {
            $discounted_price = round($price * (1 - floatval($food['discount_percent']) / 100), 2);
        }

        // fetch average rating
        $rating_q = $conn->query("SELECT AVG(rating) AS avg_rating, COUNT(*) AS cnt FROM ratings WHERE food_id=$food_id");
        $rating_data = $rating_q ? $rating_q->fetch_assoc() : ['avg_rating' => 0, 'cnt' => 0];
        $avg_rating = round(floatval($rating_data['avg_rating']), 1);
        $rating_count = intval($rating_data['cnt']);

        // fetch current user's rating (if logged in)
        $user_rating = null;
        if (isset($_SESSION['user_id'])) {
            $uid = intval($_SESSION['user_id']);
            $ur = $conn->query("SELECT rating, review, created_at FROM ratings WHERE food_id=$food_id AND user_id=$uid LIMIT 1");
            if ($ur && $ur->num_rows > 0) {
                $user_rating = $ur->fetch_assoc();
            }
        }

        // fetch recent reviews
        $reviews = [];
        $rev_q = $conn->query("SELECT r.rating, r.review, r.created_at, u.name AS user_name FROM ratings r JOIN users u ON u.id = r.user_id WHERE r.food_id=$food_id ORDER BY r.created_at DESC LIMIT 10");
        if ($rev_q) {
            while ($rr = $rev_q->fetch_assoc()) $reviews[] = $rr;
        }
        ?>

        <h3 class="text-success fw-bold my-3">
            <?php if ($discounted_price < $price): ?>
                <span class="text-decoration-line-through text-muted">₹<?php echo number_format($price, 2); ?></span>
                <span class="ms-2">₹<?php echo number_format($discounted_price, 2); ?></span>
                <small class="badge bg-danger ms-2"><?php echo htmlspecialchars($food['discount_percent']); ?>% OFF</small>
            <?php else: ?>
                ₹<?php echo number_format($price, 2); ?>
            <?php endif; ?>
        </h3>

        <p>
            <strong>Rating:</strong>
            <?php if ($rating_count > 0): ?>
                <?php echo $avg_rating; ?> / 5 (<?php echo $rating_count; ?> reviews)
            <?php else: ?>
                Not rated yet
            <?php endif; ?>
        </p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($user_rating): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Your Rating: <?php echo intval($user_rating['rating']); ?> / 5</h6>
                        <?php if (!empty($user_rating['review'])): ?>
                            <p class="card-text small text-muted"><?php echo nl2br(htmlspecialchars($user_rating['review'])); ?></p>
                        <?php endif; ?>
                        <a href="rate.php?id=<?php echo $food['id']; ?>" class="btn btn-sm btn-outline-primary">Edit Your Rating</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="mb-2"><a href="rate.php?id=<?php echo $food['id']; ?>" class="btn btn-sm btn-outline-success">Add Your Rating</a></div>
            <?php endif; ?>

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

        <?php if (!empty($reviews)): ?>
            <h5 class="mt-4">Recent Reviews</h5>
            <div class="list-group">
                <?php foreach ($reviews as $r): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><?php echo htmlspecialchars($r['user_name']); ?></h6>
                            <small class="text-muted"><?php echo intval($r['rating']); ?> / 5</small>
                        </div>
                        <?php if (!empty($r['review'])): ?>
                            <p class="mb-1 small"><?php echo nl2br(htmlspecialchars($r['review'])); ?></p>
                        <?php endif; ?>
                        <small class="text-muted"><?php echo htmlspecialchars($r['created_at']); ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
$content = ob_get_clean();
renderLayout($food['name'], $content);
?>
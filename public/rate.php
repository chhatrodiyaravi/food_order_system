<?php
session_start();
include('../config/db.php');
include('layout.php');

if (!isset($_GET['id']) && !isset($_POST['food_id'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?msg=Please login to rate items');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $food_id = intval($_POST['food_id']);
    $rating = intval($_POST['rating']);
    $review = $conn->real_escape_string($_POST['review']);
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';

    if ($rating < 1 || $rating > 5) $rating = 5;

    // upsert: if exists update else insert
    $exists = $conn->query("SELECT id FROM ratings WHERE user_id=$user_id AND food_id=$food_id");
    if ($exists && $exists->num_rows > 0) {
        $r = $exists->fetch_assoc();
        $rid = $r['id'];
        $conn->query("UPDATE ratings SET rating=$rating, review='$review', created_at=NOW() WHERE id=$rid");
    } else {
        $conn->query("INSERT INTO ratings (user_id, food_id, rating, review) VALUES ($user_id, $food_id, $rating, '$review')");
    }

    if (!empty($redirect)) {
        // sanitize redirect to allow only local pages
        $allowed = ['food.php', 'my_orders.php', 'index.php', 'category.php'];
        $rpath = basename($redirect);
        if (in_array($rpath, $allowed)) {
            header('Location: ' . $rpath . (strpos($rpath, 'food.php') !== false ? '?id=' . $food_id . '&rated=1' : ''));
            exit;
        }
    }

    header('Location: food.php?id=' . $food_id . '&rated=1');
    exit;
}

$food_id = intval($_GET['id']);
$food = $conn->query("SELECT id,name FROM food_items WHERE id=$food_id")->fetch_assoc();
if (!$food) {
    header('Location: index.php');
    exit;
}

ob_start();
?>
<div class="container py-5">
    <h3 class="fw-bold text-danger">Rate: <?php echo htmlspecialchars($food['name']); ?></h3>

    <form method="POST" class="mt-3" style="max-width:600px;">
        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">

        <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <select name="rating" class="form-select" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Review (optional)</label>
            <textarea name="review" class="form-control" rows="4"></textarea>
        </div>

        <button class="btn btn-danger">Submit Rating</button>
        <a href="food.php?id=<?php echo $food_id; ?>" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php
$content = ob_get_clean();
renderLayout('Rate Item', $content);
?>
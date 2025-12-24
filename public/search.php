<?php
include('../public/layout.php');
include('../config/db.php');
ob_start();

$q = trim($_GET['q'] ?? '');
?>

<div class="container py-4">
    <h3 class="fw-bold mb-4 text-danger">
        Search Results
        <?php if ($q != ''): ?>
            for "<span class="text-dark"><?php echo htmlspecialchars($q); ?></span>"
        <?php endif; ?>
    </h3>

    <?php
    if ($q == '') {
        echo "<div class='alert alert-warning'>Please enter a search term.</div>";
    } else {
        // Advanced search: 1) category match, 2) full-text relevance, 3) LIKE fallback
        $q_escaped = $conn->real_escape_string($q);

        $matches = [];

        // 1) category match (items from categories whose name matches query)
        $cat_ids = [];
        $cat_res = $conn->query("SELECT id FROM categories WHERE name LIKE '%$q_escaped%'");
        if ($cat_res && $cat_res->num_rows > 0) {
            while ($c = $cat_res->fetch_assoc()) $cat_ids[] = intval($c['id']);
        }

        if (!empty($cat_ids)) {
            $ids = implode(',', $cat_ids);
            $res = $conn->query("SELECT * FROM food_items WHERE category_id IN ($ids) AND available=1");
            if ($res) {
                while ($r = $res->fetch_assoc()) $matches[intval($r['id'])] = $r;
            }
        }

        // 2) try full-text search (boolean mode) for relevance — fallback if error
        $words = preg_split('/\s+/', $q_escaped);
        $boolean = '';
        foreach ($words as $w) {
            $w = preg_replace('/[^\w]/', '', $w);
            if ($w !== '') $boolean .= ' +' . $w . '*';
        }
        $boolean = trim($boolean);

        if ($boolean !== '') {
            $stmt = $conn->prepare("SELECT *, MATCH(name,description) AGAINST(? IN BOOLEAN MODE) AS score FROM food_items WHERE MATCH(name,description) AGAINST(? IN BOOLEAN MODE) AND available=1 ORDER BY score DESC LIMIT 100");
            if ($stmt) {
                $stmt->bind_param('ss', $boolean, $boolean);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res) {
                    while ($r = $res->fetch_assoc()) {
                        $matches[intval($r['id'])] = $r;
                    }
                }
                $stmt->close();
            }
        }

        // 3) fallback LIKE search to catch partial matches
        $like_sql = "SELECT * FROM food_items WHERE (name LIKE '%$q_escaped%' OR description LIKE '%$q_escaped%') AND available=1";
        $res_like = $conn->query($like_sql);
        if ($res_like) {
            while ($r = $res_like->fetch_assoc()) $matches[intval($r['id'])] = $r;
        }

        // Prepare results preserving insertion order (fulltext and category prioritized)
        $results = array_values($matches);

        if (count($results) > 0) {
            echo '<div class="row">';
            foreach ($results as $row) {
                $image = !empty($row['image'])
                    ? "/food_order_system/uploads/" . $row['image']
                    : "/food_order_system/uploads/no-image.png";
    ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="<?php echo $image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>" style="height:200px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h5 class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="text-muted small mb-2"><?php echo htmlspecialchars($row['description']); ?></p>
                            <?php
                            $price = floatval($row['price']);
                            $discounted_price = $price;
                            if (isset($row['discount_active']) && $row['discount_active'] == 1 && isset($row['discount_percent']) && $row['discount_percent'] > 0) {
                                $discounted_price = round($price * (1 - floatval($row['discount_percent']) / 100), 2);
                            }
                            ?>
                            <p class="fw-bold text-danger fs-5 mb-3">
                                <?php if ($discounted_price < $price): ?>
                                    <span class="text-decoration-line-through text-muted">₹<?php echo number_format($price, 2); ?></span>
                                    <span class="ms-2">₹<?php echo number_format($discounted_price, 2); ?></span>
                                    <small class="badge bg-danger ms-2"><?php echo htmlspecialchars($row['discount_percent']); ?>% OFF</small>
                                <?php else: ?>
                                    ₹<?php echo number_format($price, 2); ?>
                                <?php endif; ?>
                            </p>
                            <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm px-4">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
    <?php
            }
            echo '</div>';
        } else {
            echo "<div class='alert alert-info'>No food items found matching your search.</div>";
        }
    }
    ?>
</div>

<?php
$content = ob_get_clean();
renderLayout("Search Results", $content);
?>
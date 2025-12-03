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
        // Search in name or description
        $q_escaped = $conn->real_escape_string($q);
        $sql = "SELECT * FROM food_items WHERE (name LIKE '%$q_escaped%' OR description LIKE '%$q_escaped%') AND available=1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
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
                            <p class="fw-bold text-danger fs-5 mb-3">₹<?php echo number_format($row['price'], 2); ?></p>
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
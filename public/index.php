<?php
session_start();
require_once '../config/db.php';
require_once '../public/layout.php';

// Start output buffering
ob_start();
?>

<!-- FULL WIDTH MODERN HERO SLIDER -->
<div id="heroSlider" class="carousel slide" data-bs-ride="carousel">

  <div class="carousel-inner">

    <div class="carousel-item active">
      <img src="/food_order_system/uploads/slider3.jpg" class="d-block w-100 hero-img">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="fw-bold display-5">Fresh & Fast Food Delivery</h1>
        <p>Get your favorite meals delivered hot and quick 🍕🚀</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="/food_order_system/uploads/slider3.jpg" class="d-block w-100 hero-img">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="fw-bold display-5">Delicious Meals Everyday</h1>
        <p>Order now & enjoy the best dishes 😋</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="/food_order_system/uploads/slider3.jpg" class="d-block w-100 hero-img">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="fw-bold display-5">Fastest Delivery in Your City</h1>
        <p>Fresh, hot & tasty food delivered quickly</p>
      </div>
    </div>

  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>

</div>

<div class="my-4"></div>

<h2 class="fw-bold text-danger mb-3">Welcome to FoodKart</h2>
<p class="text-muted mb-4">Choose your favorite food and order now 🍕🍔</p>


<!-- Fetch Food Items -->
<?php
$result = $conn->query("SELECT * FROM food_items WHERE available = 1");
?>

<div class="row">

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm rounded-4 overflow-hidden food-card">

        <!-- Clickable Image -->
        <a href="food.php?id=<?php echo $row['id']; ?>">
          <img src="/food_order_system/uploads/<?php echo htmlspecialchars($row['image']); ?>"
            class="card-img-top food-image"
            alt="<?php echo htmlspecialchars($row['name']); ?>">
        </a>

        <div class="card-body text-center">

          <a href="food.php?id=<?php echo $row['id']; ?>" class="text-decoration-none">
            <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row['name']); ?></h5>
          </a>

          <p class="text-muted small mb-2"><?php echo htmlspecialchars($row['description']); ?></p>

          <p class="fw-bold text-success fs-5 mb-3">
            ₹<?php echo number_format($row['price'], 2); ?>
          </p>

          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/food_order_system/public/cart.php?action=add&id=<?php echo $row['id']; ?>"
              class="btn btn-danger w-100">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </a>
          <?php else: ?>
            <a href="/food_order_system/public/login.php?msg=Please login to add items"
              class="btn btn-outline-secondary w-100">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </a>
          <?php endif; ?>

        </div>

      </div>
    </div>
  <?php endwhile; ?>

</div>

<!-- Card Hover CSS -->
<style>
  .food-card {
    transition: 0.3s;
  }

  .food-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
  }

  .food-image {
    height: 230px;
    width: 100%;
    object-fit: cover;
    transition: 0.3s;
  }

  .food-card:hover .food-image {
    transform: scale(1.05);
  }
</style>

<?php
$content = ob_get_clean();
renderLayout("Home - FoodKart", $content);
?>
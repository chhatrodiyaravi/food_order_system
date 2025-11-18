<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include('../config/db.php');

function renderLayout($title, $content)
{
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title><?php echo htmlspecialchars($title); ?> - FoodKart</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            body {
                background: #fafafa;
            }

            .navbar-brand span {
                font-size: 1.5rem;
                letter-spacing: 0.3px;
            }

            .category-card img {
                border-radius: 10px;
                height: 120px;
                object-fit: cover;
            }

            .food-card img {
                height: 200px;
                object-fit: cover;
            }

            footer {
                background: #111;
                color: #bbb;
                padding: 40px 0 10px;
            }

            footer a {
                color: #bbb;
                text-decoration: none;
            }

            footer a:hover {
                color: #fff;
            }
        </style>
    </head>

    <body>

        <!-- ================= HEADER / NAVBAR ================= -->

        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
            <div class="container">

                <!-- Left: Logo -->
                <a class="navbar-brand d-flex align-items-center" href="/food_order_system/public/index.php">
                    <img src="/food_order_system/uploads/logo.png" alt="FoodKart" width="40" height="40" class="me-2">
                    <span class="fw-bold text-danger">FoodKart</span>
                </a>

                <!-- Toggle for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar content -->
                <div class="collapse navbar-collapse justify-content-between" id="navbarContent">

                    <!-- CENTER: Search bar -->
                    <form class="d-flex mx-auto" action="/food_order_system/public/search.php" method="GET" style="width: 40%;">
                        <input class="form-control me-2" type="search" name="q" placeholder="Search for dishes or restaurants..." aria-label="Search">
                        <button class="btn btn-danger" type="submit"><i class="bi bi-search"></i></button>
                    </form>

                    <!-- RIGHT: Nav links + Cart + User -->
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item"><a href="/food_order_system/public/index.php" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="/food_order_system/public/about.php" class="nav-link">About</a></li>
                        <li class="nav-item"><a href="/food_order_system/public/contact.php" class="nav-link">Contact</a></li>

                        <!-- Cart -->
                        <li class="nav-item ms-3">
                            <a href="/food_order_system/public/cart.php" class="btn btn-outline-success position-relative">
                                <i class="bi bi-cart3 fs-5"></i>
                                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?php echo count($_SESSION['cart']); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- User Login / Profile -->
                        <li class="nav-item ms-3">
                            <?php if (isset($_SESSION['user_name'])): ?>
                                <a href="/food_order_system/public/profile.php" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['user_name']; ?>
                                </a>
                                <a href="/food_order_system/public/logout.php" class="btn btn-danger btn-sm">Logout</a>
                            <?php else: ?>
                                <a href="/food_order_system/public/login.php" class="btn btn-outline-primary me-2">Login</a>
                                <a href="/food_order_system/public/register.php" class="btn btn-primary">Sign Up</a>
                            <?php endif; ?>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <!-- ================= SLIDER / CAROUSEL ================= -->
        <div id="homeCarousel" class="carousel slide mt-2" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/food_order_system/uploads/slider3.jpg" class="d-block w-100" style="height:400px; object-fit:cover;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold text-light">Order Delicious Food Anytime 🍔</h3>
                        <p>Fast Delivery • Great Taste • Affordable Price</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/food_order_system/uploads/slider4.jpg" class="d-block w-100" style="height:400px; object-fit:cover;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold text-light">Hot Pizzas, Cool Drinks 😋</h3>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/food_order_system/uploads/slider3.jpg" class="d-block w-100" style="height:400px; object-fit:cover;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold text-light">Your Favourite Meals, Just a Click Away 🚀</h3>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- ================= DYNAMIC CONTENT ================= -->
        <div class="container mt-5">
            <?php echo $content; ?>
        </div>

        <!-- ================= FOOTER ================= -->
        <footer class="mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h5 class="fw-bold text-white">About FoodKart</h5>
                        <p>FoodKart brings your favourite meals from local restaurants right to your doorstep. Fresh, fast, and flavorful!</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5 class="fw-bold text-white">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/food_order_system/public/about.php">About Us</a></li>
                            <li><a href="/food_order_system/public/contact.php">Contact</a></li>
                            <li><a href="/food_order_system/public/help.php">Help / FAQ</a></li>
                            <li><a href="/food_order_system/public/terms.php">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5 class="fw-bold text-white">Follow Us</h5>
                        <a href="#" class="me-3"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-twitter fs-4"></i></a>
                    </div>
                </div>
                <hr class="border-secondary">
                <p class="text-center mb-0 small">&copy; <?php echo date('Y'); ?> FoodKart — Online Food Ordering System.</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
<?php } ?>
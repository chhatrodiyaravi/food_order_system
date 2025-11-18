<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include('../config/db.php');

// MAIN LAYOUT FUNCTION
function renderLayout($title, $content)
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            .navbar-nav .nav-link {
                font-weight: 500;
                padding: 8px 14px;
            }

            .dropdown-menu {
                border-radius: 8px;
                padding: 8px;
            }

            .nav-item.dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
            }

            footer {
                margin-top: 50px;
                padding: 30px 0;
                background: #222;
                color: #ccc;
            }

            footer a {
                color: #fff;
                text-decoration: none;
            }

            footer a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body>

        <!-- ======= NAVBAR START ======= -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
            <div class="container">

                <!-- LOGO -->
                <a class="navbar-brand d-flex align-items-center" href="/food_order_system/public/index.php">
                    <img src="/food_order_system/uploads/logo.png" width="40" height="40" class="me-2">
                    <span class="fw-bold text-danger">FoodKart</span>
                </a>

                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">

                    <!-- LEFT NAV -->
                    <ul class="navbar-nav align-items-center">

                        <li class="nav-item">
                            <a href="/food_order_system/public/index.php" class="nav-link">Home</a>
                        </li>

                        <li class="nav-item">
                            <a href="/food_order_system/public/about.php" class="nav-link">About</a>
                        </li>

                        <!-- CATEGORY DROPDOWN -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown"
                                role="button" data-bs-toggle="dropdown">
                                Categories
                            </a>

                            <ul class="dropdown-menu">
                                <?php
                                $cats = $GLOBALS['conn']->query("SELECT * FROM categories");
                                while ($c = $cats->fetch_assoc()):
                                ?>
                                    <li>
                                        <a class="dropdown-item"
                                            href="/food_order_system/public/category.php?id=<?php echo $c['id']; ?>">
                                            <?php echo $c['name']; ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="/food_order_system/public/contact.php" class="nav-link">Contact</a>
                        </li>

                    </ul>

                    <!-- SEARCH BAR -->
                    <form class="d-flex mx-auto" action="/food_order_system/public/search.php" method="GET">
                        <input class="form-control" type="search" name="q"
                            placeholder="Search food..." style="width:300px;">
                        <button class="btn btn-outline-danger ms-2" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <!-- RIGHT SIDE: CART + LOGIN -->
                    <ul class="navbar-nav align-items-center">

                        <!-- CART -->
                        <li class="nav-item ms-3">
                            <a href="/food_order_system/public/cart.php"
                                class="btn btn-outline-success position-relative">
                                <i class="bi bi-cart3 fs-5"></i>

                                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?php echo count($_SESSION['cart']); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- LOGIN / USER -->
                        <li class="nav-item ms-3">
                            <?php if (isset($_SESSION['user_name'])): ?>
                                <a href="/food_order_system/public/profile.php" class="btn btn-outline-primary">
                                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['user_name']; ?>
                                </a>
                                <a href="/food_order_system/public/logout.php" class="btn btn-danger btn-sm ms-2">Logout</a>
                            <?php else: ?>
                                <a href="/food_order_system/public/login.php" class="btn btn-outline-primary me-2">Login</a>
                                <a href="/food_order_system/public/register.php" class="btn btn-primary">Sign Up</a>
                            <?php endif; ?>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <!-- ======= NAVBAR END ======= -->

        <!-- MAIN PAGE CONTENT -->
        <div class="container py-4">
            <?php echo $content; ?>
        </div>

        <!-- ======= FOOTER ======= -->
        <footer>
            <div class="container text-center">
                <p class="mb-1">© <?php echo date("Y"); ?> FoodKart — All rights reserved.</p>
                <p>
                    <a href="/food_order_system/public/about.php">About</a> |
                    <a href="/food_order_system/public/contact.php">Contact</a> |
                    <a href="#">Privacy Policy</a> |
                    <a href="#">Terms of Service</a>
                </p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>
<?php } ?>
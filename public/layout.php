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

            .navbar-nav .nav-link {
                padding: 8px 12px;
                font-size: 15px;
                transition: 0.3s;
            }

            .navbar-nav .nav-link:hover {
                color: #dc3545 !important;
            }

            .dropdown-menu .dropdown-item:hover {
                background: #ffeaea;
                color: #dc3545;
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

        <!-- ================== RESPONSIVE MODERN NAVBAR ================== -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
            <div class="container">

                <!-- LOGO -->
                <a class="navbar-brand d-flex align-items-center" href="/food_order_system/public/index.php">
                    <img src="/food_order_system/uploads/logo.png" width="42" height="42" class="me-2 rounded-circle">
                    <span class="fw-bold fs-4 text-danger">FoodKart</span>
                </a>

                <!-- MOBILE TOGGLER -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- NAV CONTENT -->
                <div class="collapse navbar-collapse" id="navbarContent">

                    <!-- LEFT MENU -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item mx-1">
                            <a href="/food_order_system/public/index.php" class="nav-link fw-semibold">Home</a>
                        </li>

                        <li class="nav-item mx-1">
                            <a href="/food_order_system/public/about.php" class="nav-link fw-semibold">About</a>
                        </li>

                        <!-- Dropdown -->
                        <li class="nav-item dropdown mx-1">
                            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="categoryDropdown"
                                role="button" data-bs-toggle="dropdown">
                                Categories
                            </a>



                            <ul class="dropdown-menu shadow-sm border-0 p-2">
                                <?php
                                $cats = $GLOBALS['conn']->query("SELECT * FROM categories");
                                while ($c = $cats->fetch_assoc()):
                                ?>
                                    <li>
                                        <a class="dropdown-item rounded"
                                            href="/food_order_system/public/category.php?id=<?php echo $c['id']; ?>">
                                            <?php echo $c['name']; ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="/food_order_system/public/my_orders.php" class="nav-link">My Orders</a>
                        </li>

                        <li class="nav-item mx-1">
                            <a href="/food_order_system/public/contact.php" class="nav-link fw-semibold">Contact Us</a>
                        </li>

                    </ul>

                    <!-- RESPONSIVE SEARCH BAR -->
                    <form class="d-flex mb-2 mb-lg-0" action="/food_order_system/public/search.php" method="GET">
                        <input class="form-control" type="search" name="q" placeholder="Search food..." style="width:260px;">
                        <button class="btn btn-outline-danger ms-2" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <!-- RIGHT: CART & LOGIN -->
                    <ul class="navbar-nav align-items-center ms-lg-3">

                        <!-- CART -->
                        <li class="nav-item me-2">
                            <a href="/food_order_system/public/cart.php"
                                class="btn btn-outline-success position-relative">
                                <i class="bi bi-cart3 fs-5"></i>
                                <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?php echo count($_SESSION['cart']); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- LOGIN / USER -->
                        <li class="nav-item">
                            <?php if (isset($_SESSION['user_name'])): ?>
                                <a href="/food_order_system/public/profile.php" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-person-circle"></i>
                                    <?php echo $_SESSION['user_name']; ?>
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
        <!-- ================== END NAVBAR ================== -->


        <!-- MAIN PAGE CONTENT -->
        <div class="container py-4">
            <?php echo $content; ?>
        </div>

        <!-- ================== FOOTER ================== -->
        <footer style="background:#111; color:#eee; margin-top:50px; padding:40px 0; font-family:Arial;">
            <div style="max-width:1200px; margin:auto; display:flex; flex-wrap:wrap; justify-content:space-between;">

                <!-- Brand -->
                <div style="width:250px; margin-bottom:30px;">
                    <h2 style="color:#ffcc00;">FoodieZone</h2>
                    <p style="line-height:1.6;">
                        Delicious food delivered fast at your doorstep.
                        Order from a wide range of cuisines with the best offers.
                    </p>
                </div>

                <!-- Quick Links -->
                <div style="width:200px; margin-bottom:30px;">
                    <h3 style="color:#ffcc00;">Quick Links</h3>
                    <ul style="list-style:none; padding:0; line-height:2;">
                        <li><a href="index.php" style="color:#bbb; text-decoration:none;">Home</a></li>
                        <li><a href="category.php" style="color:#bbb; text-decoration:none;">Categories</a></li>
                        <li><a href="cart.php" style="color:#bbb; text-decoration:none;">My Cart</a></li>
                        <li><a href="contact.php" style="color:#bbb; text-decoration:none;">Contact Us</a></li>
                        <li><a href="about.php" style="color:#bbb; text-decoration:none;">About Us</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div style="width:200px; margin-bottom:30px;">
                    <h3 style="color:#ffcc00;">Support</h3>
                    <ul style="list-style:none; padding:0; line-height:2;">
                        <li><a href="#" style="color:#bbb; text-decoration:none;">Privacy Policy</a></li>
                        <li><a href="#" style="color:#bbb; text-decoration:none;">Refund Policy</a></li>
                        <li><a href="#" style="color:#bbb; text-decoration:none;">Terms & Conditions</a></li>
                        <li><a href="#" style="color:#bbb; text-decoration:none;">Help Center</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div style="width:250px; margin-bottom:30px;">
                    <h3 style="color:#ffcc00;">Contact Us</h3>
                    <p>Email: support@foodiezone.com</p>
                    <p>Phone: +91 98765 43210</p>
                    <p>Address: Rajkot, Gujarat, India</p>

                    <!-- Social Icons -->
                    <div style="margin-top:10px;">
                        <a href="#" style="color:#ffcc00; margin-right:10px;">Facebook</a>
                        <a href="#" style="color:#ffcc00; margin-right:10px;">Instagram</a>
                        <a href="#" style="color:#ffcc00;">Twitter</a>
                    </div>
                </div>

            </div>

            <hr style="border-color:#333;">

            <p style="text-align:center; padding-top:10px; font-size:14px;">
                © <?php echo date("Y"); ?> FoodieZone – All Rights Reserved.
            </p>
        </footer>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>
<?php } ?>
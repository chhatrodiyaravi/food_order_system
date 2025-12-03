<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
include('auth_check.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?? "Admin Panel"; ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: #212529;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            color: white;
        }

        .sidebar h4 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #dee2e6;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            margin: 5px 12px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #495057;
            color: white;
        }

        .sidebar .active {
            background: #dc3545;
            color: white;
        }

        /* HEADER */
        .admin-header {
            margin-left: 250px;
            background: white;
            padding: 15px 25px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .admin-header h3 {
            font-weight: bold;
        }

        /* MAIN CONTENT */
        .admin-content {
            margin-left: 250px;
            padding: 25px;
        }

        /* CARDS */
        .card-box {
            border-radius: 12px;
            padding: 25px;
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .card-box:hover {
            transform: translateY(-4px);
            box-shadow: 0px 5px 18px rgba(0, 0, 0, 0.1);
        }

        .img-thumb {
            width: 60px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4>FoodKart Admin</h4>

        <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="categories.php" class="<?= basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : '' ?>">
            <i class="bi bi-grid me-2"></i> Categories
        </a>

        <a href="items.php" class="<?= basename($_SERVER['PHP_SELF']) == 'items.php' ? 'active' : '' ?>">
            <i class="bi bi-basket me-2"></i> Items
        </a>

        <a href="orders.php" class="<?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : '' ?>">
            <i class="bi bi-receipt me-2"></i> Orders
        </a>

        <a href="logout.php" class="mt-5">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>

    <?php
    function layout_start($page_title)
    {
        $GLOBALS['title'] = $page_title;
        echo "<div class='admin-header'><h3>$page_title</h3></div><div class='admin-content'>";
    }

    function layout_end()
    {
        echo "</div></body></html>";
    }
    ?>
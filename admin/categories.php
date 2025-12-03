<?php
session_start();
include('../config/db.php');
include('auth_check.php'); // admin login check
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Categories - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .table-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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

    <div class="container py-5">
        <h2 class="fw-bold text-danger mb-4">Manage Categories</h2>

        <a href="add_category.php" class="btn btn-danger mb-3">
            <i class="bi bi-plus-circle"></i> Add New Category
        </a>

        <div class="card table-card">
            <table class="table table-bordered mb-0 table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="70">ID</th>
                        <th>Name</th>
                        <th width="120">Image</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
                    if ($result->num_rows == 0):
                    ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No categories found.</td>
                        </tr>

                        <?php else:
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td class="fw-semibold"><?php echo $row['name']; ?></td>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="/food_order_system/uploads/<?php echo $row['image']; ?>" class="img-thumb">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="edit_category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="delete_category.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this category?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>

                    <?php endwhile;
                    endif; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="btn btn-secondary mt-4">Back to Dashboard</a>

    </div>

</body>

</html>
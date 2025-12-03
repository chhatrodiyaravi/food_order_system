<?php
session_start();
include('../config/db.php');
include('auth_check.php'); // admin check
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Food Items - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .table-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .img-thumb {
            width: 70px;
            height: 55px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <h2 class="fw-bold text-danger mb-4">Manage Food Items</h2>

        <a href="add_item.php" class="btn btn-danger mb-3">
            <i class="bi bi-plus-circle"></i> Add New Item
        </a>

        <div class="card table-card">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="60">ID</th>
                        <th>Name</th>
                        <th width="120">Category</th>
                        <th width="90">Price</th>
                        <th width="100">Image</th>
                        <th width="95">Available</th>
                        <th width="165">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = "SELECT food_items.*, categories.name AS category_name 
                        FROM food_items 
                        LEFT JOIN categories ON food_items.category_id = categories.id
                        ORDER BY food_items.id DESC";

                    $result = $conn->query($sql);

                    if ($result->num_rows == 0):
                    ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">No food items found.</td>
                        </tr>

                        <?php else:
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>

                                <td class="fw-semibold"><?php echo $row['name']; ?></td>

                                <td><?php echo $row['category_name'] ?? '<span class="text-muted">No Category</span>'; ?></td>

                                <td>₹<?php echo $row['price']; ?></td>

                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="/food_order_system/uploads/<?php echo $row['image']; ?>" class="img-thumb">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php echo ($row['available'] == 1)
                                        ? '<span class="badge bg-success">Yes</span>'
                                        : '<span class="badge bg-danger">No</span>'; ?>
                                </td>

                                <td>
                                    <a href="edit_item.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="delete_item.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this item?');">
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
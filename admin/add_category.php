<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
    }

    $conn->query("INSERT INTO categories (name, image) VALUES ('$name', '$image')");
    header("Location: categories.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <div class="container">
        <h3 class="mb-3">Add New Category</h3>

        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Pizza, Burger, Dessert...">
            </div>

            <div class="mb-3">
                <label class="form-label">Category Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-success">Add Category</button>
            <a href="categories.php" class="btn btn-secondary">Back</a>
        </form>

    </div>

</body>

</html>
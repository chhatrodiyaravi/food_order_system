<?php
session_start();
// session_unset();
// session_destroy();
include('../config/db.php');

// If already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Fetch admin user
    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $admin = $res->fetch_assoc();

        // var_dump("Entered Password:", $password);
        // var_dump("Stored Hash:", $admin['password']);
        // var_dump("Verify Result:", password_verify($password, $admin['password']));
        // exit;

        // Check hashed password
        if ($password === $admin['password']) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Admin user does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login - FoodKart</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f2f3f7;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-box {
            max-width: 400px;
            margin: 100px auto;
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <h3 class="text-center text-danger login-title mb-3">
            <i class="bi bi-shield-lock"></i> Admin Login
        </h3>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text"
                    name="username"
                    class="form-control"
                    placeholder="Enter admin username"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Enter password"
                        required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePass()">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button class="btn btn-danger w-100 mt-3">Login</button>

        </form>

    </div>

    <script>
        function togglePass() {
            let pass = document.getElementById("password");
            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>

</body>

</html>
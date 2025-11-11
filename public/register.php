<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $check = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($check->num_rows > 0) {
    $error = "Email already exists!";
  } else {
    $conn->query("INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')");
    header('Location: login.php');
    exit;
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Create Account - Food Order System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f6fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .register-card {
      background: #fff;
      width: 380px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 2rem;
    }

    .register-card img {
      width: 60px;
      display: block;
      margin: 0 auto 1rem;
    }

    .btn-primary {
      background-color: #1976d2;
      border: none;
    }

    .btn-primary:hover {
      background-color: #1565c0;
    }

    .social-btn {
      border: 1px solid #ccc;
      background-color: #fff;
      width: 100%;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .social-btn img {
      width: 20px;
    }

    .divider {
      text-align: center;
      margin: 1rem 0;
      position: relative;
    }

    .divider::before,
    .divider::after {
      content: "";
      height: 1px;
      width: 40%;
      background: #ccc;
      position: absolute;
      top: 50%;
    }

    .divider::before {
      left: 0;
    }

    .divider::after {
      right: 0;
    }
  </style>
</head>

<body>
  <div class="register-card">
    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Dot-blue.svg" alt="logo"> -->
    <h4 class="text-center mb-2">Create account</h4>
    <p class="text-center text-muted mb-4">Join and start ordering your favorite food!</p>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" required placeholder="Enter your name">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
      </div>
      <div class="mb-3 position-relative">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required placeholder="Create password">
      </div>

      <button type="submit" class="btn btn-primary w-100 py-2">CREATE ACCOUNT</button>
    </form>

    <div class="divider">or</div>

    <!-- <button class="social-btn">
      <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt=""> Sign up with Google
    </button>

    <button class="social-btn">
      <img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/Facebook_icon.svg" alt=""> Sign up with Facebook
    </button> -->

    <p class="text-center mt-3 mb-0 small">
      Already have an account? <a href="login.php" class="text-primary text-decoration-none">Sign in</a>
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $conn->real_escape_string($_POST['email']);
  $password = $_POST['password'];

  $res = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($res->num_rows) {
    $user = $res->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['role'] = $user['role'];
      header('Location: index.php');
      exit;
    }
  }
  $error = "Invalid email or password!";
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login - FoodKart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f6fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-card {
      background: #fff;
      width: 360px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 2rem;
    }

    .btn-primary {
      background-color: #1976d2;
      border: none;
    }

    .btn-primary:hover {
      background-color: #1565c0;
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
  <div class="login-card">

    <h4 class="text-center mb-2">Sign in</h4>
    <p class="text-center text-muted mb-4">to continue to your account</p>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" id="loginForm">

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email">
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password">
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="rememberMe">
          <label class="form-check-label" for="rememberMe">Keep me signed in</label>
        </div>
        <a href="#" class="text-decoration-none small text-danger">Forgot password?</a>
      </div>

      <button type="submit" class="btn btn-danger w-100 py-2">SIGN IN</button>
    </form>

    <div class="divider">or</div>

    <p class="text-center mt-3 mb-0 small">
      Don't have an account?
      <a href="register.php" class="text-danger text-decoration-none">Create account</a>
    </p>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- jQuery Validation -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

  <!-- Validation Script -->
  <script>
    $(document).ready(function() {
      $("#loginForm").validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 4
          }
        },

        messages: {
          email: {
            required: "Please enter your email",
            email: "Please enter a valid email"
          },
          password: {
            required: "Please enter your password",
            minlength: "Password must be at least 4 characters long"
          }
        },

        errorClass: "text-danger small",
        errorElement: "div",

        highlight: function(element) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
          $(element).removeClass("is-invalid");
        }
      });
    });
  </script>

</body>

</html>
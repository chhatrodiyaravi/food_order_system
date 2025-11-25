<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  // Check duplicate email
  $check = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($check->num_rows > 0) {
    $error = "Email already exists!";
  } else {
    $conn->query("INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')");
    header('Location: login.php?msg=Account created successfully! Please login.');
    exit;
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Create Account - FoodKart</title>
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

  <div class="register-card">

    <h4 class="text-center mb-2">Create account</h4>
    <p class="text-center text-muted mb-4">Join and start ordering your favorite food!</p>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" id="registerForm">

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter your name">
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email">
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Create password">
      </div>

      <button type="submit" class="btn btn-danger w-100 py-2">CREATE ACCOUNT</button>
    </form>

    <div class="divider">or</div>

    <p class="text-center mt-3 mb-0 small">
      Already have an account?
      <a href="login.php" class="text-danger text-decoration-none">Sign in</a>
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
      $("#registerForm").validate({
        rules: {
          name: {
            required: true,
            minlength: 2
          },
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 6
          }
        },

        messages: {
          name: {
            required: "Please enter your full name",
            minlength: "Name must be at least 2 characters"
          },
          email: {
            required: "Please enter your email",
            email: "Please enter a valid email address"
          },
          password: {
            required: "Please create a password",
            minlength: "Password must be at least 6 characters long"
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
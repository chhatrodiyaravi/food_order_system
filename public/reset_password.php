<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['reset_email'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass1 = $_POST['password'];
    $pass2 = $_POST['confirm_password'];

    if ($pass1 !== $pass2) {
        $message = "Passwords do not match!";
    } else {
        // Hash password
        $hashed = password_hash($pass1, PASSWORD_BCRYPT);

        // Update DB
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hashed, $email);

        if ($stmt->execute()) {
            unset($_SESSION['reset_email']);
            $message = "Password updated! You can now login.";
        } else {
            $message = "Something went wrong!";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - FoodKart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f6fa;
        }

        .card-reset {
            max-width: 480px;
            margin: 6vh auto;
            border-radius: 12px;
        }

        .eye-btn {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="card card-reset shadow-sm">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h4 class="mb-0">Create New Password</h4>
                <small class="text-muted">Choose a strong password for your account</small>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST" id="resetForm" novalidate>
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                        <span class="input-group-text eye-btn" id="togglePwd">👁️</span>
                    </div>
                    <!-- <div class="form-text">Minimum 4 characters</div> -->
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                </div>

                <button type="submit" class="btn btn-danger w-100">Reset Password</button>
            </form>

            <div class="text-center mt-3">
                <a href="login.php" class="small text-decoration-none">Back to Login</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            // Toggle password field
            $('#togglePwd').on('click', function() {
                var pwd = $('#password');
                var type = pwd.attr('type') === 'password' ? 'text' : 'password';
                pwd.attr('type', type);
                // also toggle confirm if you'd like
            });

            // Validation
            $('#resetForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 4
                    },
                    confirm_password: {
                        required: true,
                        minlength: 4,
                        equalTo: '#password'
                    }
                },
                messages: {
                    password: {
                        required: 'Enter your new password',
                        minlength: 'At least 4 characters'
                    },
                    confirm_password: {
                        required: 'Confirm your password',
                        minlength: 'At least 4 characters',
                        equalTo: 'Passwords do not match'
                    }
                },
                errorClass: 'invalid-feedback',
                errorElement: 'div',
                highlight: function(el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function(el) {
                    $(el).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.input-group').length ? element.closest('.input-group') : element);
                }
            });
        });
    </script>
</body>


<!-- this is commen -->

</html>
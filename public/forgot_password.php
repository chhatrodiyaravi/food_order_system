<?php
session_start();
include('../config/db.php'); // change path if needed

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Save email temporarily for reset
        $_SESSION['reset_email'] = $email;
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "Email not found!";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - FoodKart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f6fa;
        }

        .card-reset {
            max-width: 420px;
            margin: 6vh auto;
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <div class="card card-reset shadow-sm">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h4 class="mb-0">Forgot Password</h4>
                <small class="text-muted">Enter your account email to continue</small>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST" id="forgotForm" novalidate>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text">@</span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="your@example.com" required>
                    </div>
                    <div class="form-text">We'll send a reset link if the email exists.</div>
                </div>

                <button type="submit" class="btn btn-danger w-100">Send Reset Link</button>
            </form>

            <div class="text-center mt-3">
                <a href="login.php" class="small text-decoration-none">Back to sign in</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            $('#forgotForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: 'Please enter your email address',
                        email: 'Enter a valid email'
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
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
</body>

</html>
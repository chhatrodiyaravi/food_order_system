<?php
include('../public/layout.php');
ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="fw-bold text-danger mb-3 text-center">Contact Us</h2>
            <p class="text-center text-muted mb-4">
                Have questions, feedback, or need support?
                We'd love to hear from you!
            </p>

            <form id="contactForm" method="POST" action="contact.php" class="card shadow p-4 border-0">
                <div class="mb-3">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="4" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-danger w-100">Send Message</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);

                // For college/local use, just display success (no actual mail function)
                echo "<div class='alert alert-success mt-4'>Thank you, <strong>$name</strong>! Your message has been received.</div>";

                // Optional: Save to DB or send email using mail()
                // $conn->query("INSERT INTO messages (name, email, message) VALUES ('$name','$email','$message')");
            }
            ?>

            <div class="text-center mt-5">
                <p class="text-muted">
                    <i class="bi bi-geo-alt"></i> Rajkot, Gujarat, India<br>
                    <i class="bi bi-envelope"></i> support@foodkart.com<br>
                    <i class="bi bi-telephone"></i> +91 98765 43210
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {

        $("#contactForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },

                email: {
                    required: true,
                    email: true
                },

                message: {
                    required: true,
                    minlength: 10
                }
            },

            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Name must be at least 3 characters"
                },

                email: {
                    required: "Please enter your email",
                    email: "Enter a valid email address"
                },

                message: {
                    required: "Please enter your message",
                    minlength: "Message must be at least 10 characters long"
                }
            },

            errorClass: "text-danger",
            errorElement: "small",
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });

    });
</script>

<?php
$content = ob_get_clean();
renderLayout("Contact Us", $content);
?>
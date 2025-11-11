<?php
include('../public/layout.php');
ob_start();
?>

<div class="container py-4">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold text-danger mb-3">About FoodKart</h2>
            <p class="lead">FoodKart is your trusted online food ordering and delivery platform, connecting you to your favorite local restaurants and cafes.</p>
            <p>We aim to bring delicious food to your doorstep quickly, safely, and affordably. Whether you crave pizza, burgers, biryani, or desserts — we’ve got it all covered!</p>
            <p>Our mission is to make online food ordering simple and enjoyable for everyone. We partner with the best restaurants and ensure fast delivery, fresh ingredients, and excellent customer service.</p>
        </div>
        <div class="col-md-6 text-center">
            <img src="/food_order_system/uploads/about_food.jpg" alt="About FoodKart" class="img-fluid rounded shadow">
        </div>
    </div>

    <div class="text-center mt-5">
        <h4 class="fw-bold mb-3">Why Choose FoodKart?</h4>
        <div class="row">
            <div class="col-md-4">
                <i class="bi bi-truck fs-1 text-danger"></i>
                <h6 class="mt-2 fw-bold">Fast Delivery</h6>
                <p>Hot meals delivered right on time.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-emoji-smile fs-1 text-danger"></i>
                <h6 class="mt-2 fw-bold">Best Restaurants</h6>
                <p>Top-rated chefs and trusted kitchens.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-shield-check fs-1 text-danger"></i>
                <h6 class="mt-2 fw-bold">Quality & Safety</h6>
                <p>Hygienic packaging and 100% freshness guaranteed.</p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderLayout("About Us", $content);
?>
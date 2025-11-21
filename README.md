# Food Order System - Plain PHP Starter

This is a minimal Plain PHP + MySQL starter project for an Online Food Ordering System.
Includes: user registration/login, menu, cart, checkout, admin item management, and sample images.

## Setup Steps (XAMPP)

1. Put `food_order_system` into `htdocs` or use the provided ZIP.
2. Start Apache and MySQL in XAMPP.
3. Create the database:
   - Open http://localhost/phpmyadmin
   - Create database named `food_order_db`
4. Import SQL file `database/food_order_db.sql` (provided).
5. Update `config/db.php` if your DB credentials differ.
6. Add your Razorpay test keys in `config/razorpay.php`.
7. Run the site:
   - Visit http://localhost/food_order_system/public/

## Admin user

A small helper `install_admin.php` is provided in the project root to create the admin user.
Run it once in browser: http://localhost/food_order_system/install_admin.php
Default admin credentials (set by you when running the script).

## Notes

- This is a starter. Improve security before production: prepared statements, CSRF, input validation, HTTPS.
- For Razorpay integration, ensure your keys are set and you test in sandbox mode.

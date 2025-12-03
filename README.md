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
<<<<<<< HEAD
6. **Cashfree Payment Gateway Setup:**
   - The project now uses Cashfree for online payments
   - Configuration is in `config/cashfree.php`
   - Test credentials are already configured for sandbox mode
   - To use production, update API keys in `config/cashfree.php`
7. **Database Migration:**
   - Import `database/migration_cashfree.sql` to add payment-related columns
   - Run in phpMyAdmin or MySQL console
8. Run the site:
=======
6. Add your Razorpay test keys in `config/razorpay.php`.
7. Run the site:
>>>>>>> 0d6c4840b28b5f5cc20de54d3139d2c149f02ca1
   - Visit http://localhost/food_order_system/public/

## Admin user

A small helper `install_admin.php` is provided in the project root to create the admin user.
Run it once in browser: http://localhost/food_order_system/install_admin.php
Default admin credentials (set by you when running the script).

## Notes

- This is a starter. Improve security before production: prepared statements, CSRF, input validation, HTTPS.
<<<<<<< HEAD
- Payment Gateway: Uses Cashfree for online payments (sandbox mode by default)
- Password Reset: Email-based password reset functionality included
- Admin: Default admin user can be created using `install_admin.php`
=======
- For Razorpay integration, ensure your keys are set and you test in sandbox mode.
>>>>>>> 0d6c4840b28b5f5cc20de54d3139d2c149f02ca1

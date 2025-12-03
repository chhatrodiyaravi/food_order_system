# Forgot Password Setup Guide

## What's New

I've added a complete "Forgot Password" feature to your food order system. Here's what has been implemented:

## Files Created

1. **public/forgot_password.php** - Email verification page

   - Users enter their email address
   - System generates a reset token valid for 1 hour
   - Reset link is sent via email

2. **public/reset_password.php** - Password reset page

   - Users click the link from email
   - They set a new password
   - Password is updated in the database

3. **database/migration_add_password_reset.sql** - Database migration script

## Files Modified

- **public/login.php** - Updated "Forgot password?" link to point to `forgot_password.php`

## Setup Instructions

### Step 1: Update Database

Run the migration script to add the required columns to the users table:

```sql
ALTER TABLE users ADD COLUMN reset_token VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE users ADD COLUMN token_expiry DATETIME NULL DEFAULT NULL;
```

**Option A: Using phpMyAdmin**

- Open phpMyAdmin
- Select your `food_order_db` database
- Go to SQL tab
- Copy and paste the SQL commands from `database/migration_add_password_reset.sql`
- Click Execute

**Option B: Using MySQL Command Line**

```bash
mysql -u root food_order_db < database/migration_add_password_reset.sql
```

### Step 2: Configure Email (Without SMTP - Works Out of the Box!)

The system works without SMTP! It uses PHP's built-in `mail()` function with intelligent fallback:

**Development Mode (No Email Server Needed):**

- If email cannot be sent, the system displays the reset link directly on the page
- You can copy and paste the link into your browser
- Perfect for local testing and development in XAMPP
- A convenient "Open Reset Page" button is provided

**Production Mode (With Mail Server):**

- Email will be sent automatically when mail() function works
- Ensure your server has `sendmail` configured or a mail relay
- Check `php.ini` for mail settings

**No configuration needed!** The system handles both cases automatically.

### Step 3: Test the Feature

1. Go to login page: `http://localhost/food_order_system/public/login.php`
2. Click on "Forgot password?" link
3. Enter your registered email address
4. Check your email for the reset link
5. Click the link to reset your password
6. Enter your new password and confirm it
7. You should see success message and be able to login with new password

## How It Works

### Forgot Password Flow:

1. User clicks "Forgot password?" on login page
2. User enters their email on `forgot_password.php`
3. System generates a unique reset token (valid for 1 hour)
4. Reset email is sent to user with a link containing the token
5. User clicks link in email → `reset_password.php?token=xxxxx`
6. User enters new password
7. System validates token expiry and updates password
8. User can now login with new credentials

### Security Features:

- ✅ Passwords are hashed using bcrypt
- ✅ Reset tokens expire after 1 hour
- ✅ Tokens are randomly generated and cryptographically secure
- ✅ Email verification (token must exist in DB and not be expired)
- ✅ Password validation (minimum 4 characters, must match confirmation)
- ✅ Security message for non-existent emails (doesn't reveal if email exists)

## File Structure

```
food_order_system/
├── public/
│   ├── login.php (modified - link updated)
│   ├── forgot_password.php (new)
│   ├── reset_password.php (new)
├── database/
│   ├── migration_add_password_reset.sql (new)
```

## Troubleshooting

**Problem: Reset link not shown**

- If email() function fails and no link is displayed, check `php.ini` mail settings
- For development, the system will show the reset link directly in a success message
- You can copy and paste the link or click "Open Reset Page" button

**Problem: "Invalid reset link" message**

- Token may have expired (valid for 1 hour only)
- User may request password reset again
- Check database has reset_token and token_expiry columns

**Problem: Password not updating**

- Verify database migration was applied
- Check user email exists in database
- Ensure confirm password matches
- Verify the token hasn't expired

**Problem: I'm seeing the fallback link (development mode)**

- This is normal for local XAMPP development
- The system shows you the reset link directly for easy testing
- Just click "Open Reset Page" or copy the link into your browser

## For Production

Before going live, consider:

1. Configure your mail server (`php.ini` `sendmail` or mail relay)
2. Or use hosted email service (SendGrid, AWS SES, etc.)
3. Add rate limiting to prevent brute force attacks
4. Use HTTPS only for password reset links
5. Add admin panel to view/manually reset user passwords
6. Log password reset attempts for security audit
7. Consider requiring email verification for new accounts

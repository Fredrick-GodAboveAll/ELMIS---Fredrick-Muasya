# Install dependencies
composer install

# Create password_resets table
# Run this SQL in your database:
# database/schemas/password_resets.sql

# Configure email settings in app/Services/EmailService.php:
# - Set your SMTP server details
# - Add your email credentials
# - Update the reset link URL if needed

# For Gmail SMTP:
# 1. Enable 2-factor authentication
# 2. Generate an app password
# 3. Use your Gmail address and app password in EmailService.php

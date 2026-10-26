# Authentication Documentation

This document explains how authentication works in this project and how the login, registration, forgot-password, reset-password, and logout flows are connected.

## Key authentication files

- `routes/web.php` — defines auth routes and middleware access rules
- `app/Controllers/AuthController.php` — handles auth form display, validation, and redirects
- `app/Services/AuthService.php` — contains user login, registration, logout, and password-reset logic
- `app/Core/Csrf.php` — generates and validates CSRF tokens for secure form submission
- `app/Core/Session.php` — wraps PHP session operations and flash messaging
- `app/Views/auth/*.php` — auth pages and forms

## Route flow

1. `GET /login` shows the login form.
2. `POST /login` validates CSRF and credentials, then redirects to `/dashboard` on success.
3. `GET /register` shows the registration form.
4. `POST /register` validates the registration data and saves a new user.
5. `GET /forgot-password` shows the email entry form.
6. `POST /forgot-password` sends a reset token and shows the "check mail" page.
7. `GET /reset-password?token=...` shows the password reset form when the token is valid.
8. `POST /reset-password` updates the password and redirects to login.
9. `GET /logout` ends the session and shows the logout confirmation page.

## CSRF protection

- Each auth form includes a hidden `csrf_token` field.
- `App\Core\Csrf::generate()` stores a token in the session and returns it for the form.
- `App\Core\Csrf::validate()` checks the token on every POST route.
- If the token is invalid, the request stops immediately and throws an exception.

## Password confirmation logic

- The validator expects a main field, e.g. `password`, and a confirmation field named `password_confirm`.
- The rule `confirmed` checks that `$data['password'] === $data['password_confirm']`.
- This is why the form field names must exactly match the controller validation rules.

## Forgot password and reset password

- `AuthService::sendResetLink()` creates a token, saves it into the database, and sends an email.
- The reset link uses the `APP_URL` environment variable if available, otherwise it defaults to `http://localhost:8000`.
- Set `APP_URL` in your environment or `.env` file so the reset email contains a valid link.
- `AuthController::resetPassword()` verifies the token before showing the reset form.
- `AuthController::doResetPassword()` validates the new password and confirmation.

## Email setup note

- The current project uses PHP `mail()` inside `AuthService::sendResetLink()`.
- For reliable email delivery, use a real SMTP setup and a library such as PHPMailer.
- The existing `EMAIL_SETUP.md` file can help you configure SMTP and update `AuthService`.

## Session and logout

- `Session::start()` is called in `public/index.php` before routing begins.
- User login saves `user_id`, `user_name`, and `user_role` into session.
- `AuthMiddleware` protects private routes by checking `Session::has('user_id')`.
- `AuthService::logout()` destroys the session and logs the user out.

## Helpful tips

- If `forgot password` shows a page 500, the issue is likely in `AuthService::sendResetLink()` or the email setup.
- If `password_confirm` still fails, inspect the form field names and the controller validation rules.
- Use the `AUTHENTICATION_DOC.md` and `.github/skills/auth/SKILL.md` files as your reference when working on auth.

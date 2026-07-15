# Authentication Skill

Use when:
- working on login, registration, forgot password, reset password, or logout features
- fixing CSRF token, session, or password confirmation issues
- updating `app/Controllers/AuthController.php`, `app/Services/AuthService.php`, `app/Core/Csrf.php`, or auth views
- explaining the authentication flow to a teammate or yourself
- improving email/password reset behavior or mail configuration

## What this skill covers
- authentication request flow
- CSRF token generation and validation
- form validation rules for `password_confirm`
- password reset token generation and expiration
- session-based access control and logout handling

### Files to review
- `routes/web.php`
- `app/Controllers/AuthController.php`
- `app/Services/AuthService.php`
- `app/Core/Csrf.php`
- `app/Core/Session.php`
- `app/Views/auth/*.php`
- `AUTHENTICATION_DOC.md`

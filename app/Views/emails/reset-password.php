<?php
// Email template for password reset request
// Variables: $resetLink, $userEmail
?>
<div
  style="
    font-family: system-ui, sans-serif, Arial;
    font-size: 14px;
    color: #333;
    padding: 20px 14px;
    background-color: #f5f5f5;
  "
>
  <div style="max-width: 600px; margin: auto; background-color: #fff">
    <div style="text-align: center; background-color: #333; padding: 14px">
      <a style="text-decoration: none; outline: none" href="<?= $homeLink ?? 'http://localhost:8000' ?>" target="_blank">
        <div style="font-size: 24px; font-weight: bold; color: #fff;">fleave</div>
      </a>
    </div>
    <div style="padding: 20px">
      <h1 style="font-size: 22px; margin-bottom: 26px; color: #333;">Password Reset Request</h1>
      <p>
        We received a request to reset the password for your fleave account. To proceed, please click the
        link below to create a new password:
      </p>
      <p style="margin: 20px 0;">
        <a 
          href="<?= $resetLink ?>"
          style="
            display: inline-block;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #fc0038;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
          "
          target="_blank"
        >
          Reset Password
        </a>
      </p>
      <p>Or copy and paste this link in your browser:</p>
      <p style="word-break: break-all; color: #666;"><?= $resetLink ?></p>
      <p style="color: #999; font-size: 13px;">This link will expire in one hour.</p>
      <p>
        If you didn't request this password reset, please ignore this email or let us know
        immediately at <a href="mailto:support@fleave.local" style="color: #fc0038; text-decoration: none;">support@fleave.local</a>. 
        Your account remains secure.
      </p>
      <p>Best regards,<br />The fleave Team</p>
    </div>
  </div>
  <div style="max-width: 600px; margin: auto">
    <p style="color: #999; font-size: 12px; text-align: center; padding: 14px 0;">
      The email was sent to <?= $userEmail ?><br />
      You received this email because you are registered with fleave
    </p>
  </div>
</div>

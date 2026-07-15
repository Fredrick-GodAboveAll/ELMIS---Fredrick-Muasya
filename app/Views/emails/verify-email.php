<?php
// Email template for email verification after registration
// Variables: $verificationLink, $userName
?>
<div style="font-family: system-ui, sans-serif, Arial; font-size: 16px; background-color: #fff8f1">
  <div style="max-width: 600px; margin: auto; padding: 16px">
    <a style="text-decoration: none; outline: none" href="<?= $homeLink ?? 'http://localhost:8000' ?>" target="_blank">
      <div style="font-size: 24px; font-weight: bold; color: #333;">fleave</div>
    </a>
    <p>Welcome to the fleave family! We're excited to have you on board.</p>
    <p>
      Your account has been successfully created, and you're now ready to explore all the great
      features we offer for managing your leave requests.
    </p>
    <p>
      <a
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
        href="<?= $verificationLink ?>"
        target="_blank"
      >
        Verify Your Email
      </a>
    </p>
    <p>
      If you have any questions or need help getting started, our support team is just an email away
      at
      <a href="mailto:support@fleave.local" style="text-decoration: none; outline: none; color: #fc0038">support@fleave.local</a>. 
      We're here to assist you every step of the way!
    </p>
    <p>Best regards,<br />The fleave Team</p>
  </div>
</div>

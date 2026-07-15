<!-- Email verification page: instructs the user to open the verification email sent after registration. -->
<div class="row flex-center min-vh-100 py-6">
 <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
 <div class="card"><div class="card-body p-4 p-sm-5">
 <h5 class="mb-0">Verify Your Email</h5><small>Check your email for verification link</small>
 <?php if ($success = \App\Core\Session::flash('success')): ?>
 <div class="alert alert-success mt-3"><?= $success ?></div>
 <?php endif; ?>
 <?php if ($error = \App\Core\Session::flash('error')): ?>
 <div class="alert alert-danger mt-3"><?= $error ?></div>
 <?php endif; ?>
 <div class="mt-3 text-center">
 <p>We've sent a verification email to your registered email address.</p>
 <p>Please click the link in the email to verify your account and complete registration.</p>
 <p class="text-muted small">The verification link will expire in 24 hours.</p>
 </div>
 <div class="mt-4">
 <a class="btn btn-primary d-block w-100" href="/login">Back to Login</a>
 </div>
 </div></div>
 </div>
</div>

<!-- Forgot password page: user enters email to request a password reset link. -->
<div class="row flex-center min-vh-100 py-6">
 <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
 <div class="card"><div class="card-body p-4 p-sm-5">
 <h5 class="mb-0">Forgot password?</h5>
 <small>Enter your email to reset your password.</small>
 <?php if ($error = \App\Core\Session::flash('error')): ?>
 <div class="alert alert-danger mt-3"><?= $error ?></div>
 <?php endif; ?>
 <?php if ($success = \App\Core\Session::flash('success')): ?>
 <div class="alert alert-success mt-3"><?= $success ?></div>
 <?php endif; ?>
 <?php if ($errors = \App\Core\Session::flash('errors')): ?>
 <div class="alert alert-danger"><ul class="mb-0">
 <?php foreach ($errors as $field => $msgs): ?>
 <?php foreach ($msgs as $msg): ?><li><?= $msg ?></li><?php endforeach; ?>
 <?php endforeach; ?>
 </ul></div>
 <?php endif; ?>
 <!-- Forgot password form: a reset email link will be sent if the address exists -->
 <form method="POST" action="/forgot-password" class="mt-3">
 <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
 <div class="mb-3">
 <input class="form-control" type="email" name="email" placeholder="Email address"
 value="<?= htmlspecialchars(\App\Core\Session::flash('old')['email'] ?? '') ?>" required>
 </div>
 <div class="mb-3">
 <button class="btn btn-primary d-block w-100" type="submit">Send reset link</button>
 </div>
 </form>
 <a class="fs-10" href="/login">Back to login</a>
 </div></div>
 </div>
</div>

<!-- Reset password page: token is required and submitted back to the server for validation. -->
<div class="row flex-center min-vh-100 py-6">
 <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
 <div class="card"><div class="card-body p-4 p-sm-5">
 <h5 class="mb-0">Reset password</h5><small>Enter your new password below.</small>
 <?php if ($error = \App\Core\Session::flash('error')): ?>
 <div class="alert alert-danger mt-3"><?= $error ?></div>
 <?php endif; ?>
 <?php if ($errors = \App\Core\Session::flash('errors')): ?>
 <div class="alert alert-danger"><ul class="mb-0">
 <?php foreach ($errors as $f => $msgs): foreach ($msgs as $msg): ?><li><?= $msg ?></li><?php endforeach; endforeach; ?>
 </ul></div>
 <?php endif; ?>
 <!-- Reset password form: token must be submitted so the server can verify the request -->
 <form method="POST" action="/reset-password" class="mt-3">
 <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
 <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
 <div class="mb-3">
 <input class="form-control" type="password" name="password" placeholder="New password" required>
 </div>
 <div class="mb-3">
 <input class="form-control" type="password" name="password_confirm" placeholder="Confirm new password" required>
 </div>
 <div class="mb-3">
 <button class="btn btn-primary d-block w-100" type="submit">Reset password</button>
 </div>
 </form>
 <a class="fs-10" href="/login">Back to login</a>
 </div></div>
 </div>
</div>

<!-- Registration page: users create a new account here. Password confirmation must match exactly. -->
<div class="row flex-center min-vh-100 py-6">
 <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
 <div class="card"><div class="card-body p-4 p-sm-5">
 <h5 class="mb-0">Register</h5><small>Create your account - password must be at least 8 characters</small>
 <?php if ($error = \App\Core\Session::flash('error')): ?>
 <div class="alert alert-danger mt-3"><?= $error ?></div>
 <?php endif; ?>
 <?php if ($errors = \App\Core\Session::flash('errors')): ?>
 <div class="alert alert-danger"><ul class="mb-0">
 <?php foreach ($errors as $field => $msgs): ?>
 <?php foreach ($msgs as $msg): ?><li><?= $msg ?></li><?php endforeach; ?>
 <?php endforeach; ?>
 </ul></div>
 <?php endif; ?>
 <!-- Registration form: `password_confirm` must exactly match `password` -->
 <form method="POST" action="/register" class="mt-3">
 <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
 <div class="mb-3">
 <input class="form-control" type="text" name="name" placeholder="Full name"
 value="<?= htmlspecialchars(\App\Core\Session::flash('old')['name'] ?? '') ?>" required>
 </div>
 <div class="mb-3">
 <input class="form-control" type="email" name="email" placeholder="Email address"
 value="<?= htmlspecialchars(\App\Core\Session::flash('old')['email'] ?? '') ?>" required>
 </div>
 <div class="mb-3">
 <input class="form-control" type="password" name="password" placeholder="Password (min. 8 characters)" required>
 </div>
 <div class="mb-3">
 <input class="form-control" type="password" name="password_confirm" placeholder="Confirm password" required>
 </div>
 <div class="mb-3">
 <button class="btn btn-primary d-block w-100" type="submit">Register</button>
 </div>
 <small class="text-muted d-block mt-2">After registration, you'll receive an email to verify your account.</small>
 </form>
 <a class="fs-10" href="/login">Already have an account? Log in</a>
 </div></div>
 </div>
</div>

<!-- Login page: renders the login form and displays session flash messages. -->
<div class="row flex-center min-vh-100 py-6">
 <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
 <div class="card">
 <div class="card-body p-4 p-sm-5">
 <div class="row flex-between-center mb-2">
 <div class="col-auto"><h5>Log in</h5></div>
 <div class="col-auto fs-10 text-600">
 <span>or</span> <a href="/register">Create an account</a>
 </div>
 </div>
 <?php if ($error = \App\Core\Session::flash('error')): ?>
 <div class="alert alert-danger"><?= $error ?></div>
 <?php endif; ?>
 <?php if ($success = \App\Core\Session::flash('success')): ?>
 <div class="alert alert-success"><?= $success ?></div>
 <?php endif; ?>
 <?php if ($errors = \App\Core\Session::flash('errors')): ?>
 <div class="alert alert-danger"><ul class="mb-0">
 <?php foreach ($errors as $field => $msgs): ?>
 <?php foreach ($msgs as $msg): ?><li><?= $msg ?></li><?php endforeach; ?>
 <?php endforeach; ?>
 </ul></div>
 <?php endif; ?>
 <!-- Login form: CSRF token is required to protect against cross-site request forgery -->
 <form method="POST" action="/login">
 <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
 <div class="mb-3">
 <input class="form-control" type="email" name="email" placeholder="Email address"
 value="<?= htmlspecialchars(\App\Core\Session::flash('old')['email'] ?? '') ?>" required>
 </div>
 <div class="mb-3">
 <input class="form-control" type="password" name="password" placeholder="Password" required>
 </div>
 <div class="row flex-between-center">
 <div class="col-auto">
 <div class="form-check mb-0">
 <input class="form-check-input" type="checkbox" name="remember" id="remember">
 <label class="form-check-label mb-0" for="remember">Remember me</label>
 </div>
 </div>
 <div class="col-auto"><a class="fs-10" href="/forgot-password">Forgot Password?</a></div>
 </div>
 <div class="mb-3">
 <button class="btn btn-primary d-block w-100 mt-3" type="submit">Log in</button>
 </div>
 </form>
 </div>
 </div>
 </div>
</div>
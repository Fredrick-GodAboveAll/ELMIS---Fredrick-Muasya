<!-- Lock screen page: allows a logged-in user to re-enter their password after locking the screen. -->
<div class="row flex-center min-vh-100 py-6">
 <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
 <div class="card"><div class="card-body p-4 p-sm-5 text-center">
 <img class="img-thumbnail rounded-circle mb-3" src="https://via.placeholder.com/80" alt="" width="80" />
 <h5 class="mb-2"><?= \App\Core\Session::get('user_name') ?></h5>
 <p class="fs-10 mb-3">Enter your password to unlock</p>
 <?php if ($error = \App\Core\Session::flash('error')): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
 <form method="POST" action="/unlock">
 <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
 <div class="mb-3">
 <input class="form-control" type="password" name="password" placeholder="Password" required>
 </div>
 <div class="mb-3">
 <button class="btn btn-primary d-block w-100" type="submit">Unlock</button>
 </div>
 </form>
 <a class="fs-10" href="/logout">Sign in as a different user</a>
 </div></div>
 </div>
</div>
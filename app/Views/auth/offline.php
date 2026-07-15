<!-- You are offline page: shown when trying to access email-dependent features without internet -->
<div class="row flex-center min-vh-100 py-6">
  <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
    <div class="card">
      <div class="card-body p-4 p-sm-5 text-center">
        <div class="mb-4">
          <span class="fas fa-cloud-slash fs-1 text-warning"></span>
        </div>
        <h5 class="mb-3">You Are Offline</h5>
        <p class="fs-10 mb-4">
          This feature requires an active internet connection and email service.
        </p>
        <p class="fs-10 text-muted mb-4">
          <?php if ($featureName = \App\Core\Session::flash('offline_feature')): ?>
            <strong><?= htmlspecialchars($featureName) ?></strong> is not available while offline.
          <?php else: ?>
            Please check your internet connection and try again.
          <?php endif; ?>
        </p>
        <p class="fs-10 text-muted mb-4">
          <strong>Available Offline:</strong> Login
        </p>
        <div class="mt-4">
          <a class="btn btn-primary btn-sm" href="/login">
            <span class="fas fa-arrow-left me-2"></span> Back to Login
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Network error page: shown when database or network connection fails -->
<div class="row flex-center min-vh-100 py-6">
  <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
    <div class="card">
      <div class="card-body p-4 p-sm-5 text-center">
        <div class="mb-4">
          <span class="fas fa-wifi-slash fs-1 text-danger"></span>
        </div>
        <h5 class="mb-3">Network or Database Error</h5>
        <p class="fs-10 mb-4">
          We're unable to connect to the database. This could be because:
        </p>
        <ul class="text-start fs-10 mb-4" style="display: inline-block;">
          <li>The database server is offline or unavailable</li>
          <li>Network connection is lost</li>
          <li>Database credentials are incorrect</li>
        </ul>
        <p class="fs-10 text-muted mb-4">
          Please check your database connection and try again.
        </p>
        <div class="mt-4">
          <a class="btn btn-primary btn-sm me-2" href="/login">
            <span class="fas fa-arrow-left me-2"></span> Back to Login
          </a>
          <button class="btn btn-secondary btn-sm" onclick="location.reload()">
            <span class="fas fa-sync me-2"></span> Retry
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

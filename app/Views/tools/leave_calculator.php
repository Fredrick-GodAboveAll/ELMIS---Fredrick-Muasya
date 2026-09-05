<?php $currentPage = $currentPage ?? 'tools'; ?>

<div class="row">
  <div class="col-10">
    <h4>Leave Calculator Test</h4>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
          <div><?= htmlspecialchars($err) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($result !== null): ?>
      <div class="alert alert-success">Calculated days: <strong><?= htmlspecialchars((string)$result) ?></strong></div>
    <?php endif; ?>
    <?php if (!empty($endDateResult)): ?>
      <div class="alert alert-success">Computed end date: <strong><?= htmlspecialchars((string)$endDateResult) ?></strong></div>
    <?php endif; ?>
    <?php if (!empty($returnDateResult)): ?>
      <div class="alert alert-success">Return to work date: <strong><?= htmlspecialchars((string)$returnDateResult) ?></strong></div>
    <?php endif; ?>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Automatic End Date</label>
        <input type="date" class="form-control" value="<?= htmlspecialchars($endDateResult ?? '') ?>" disabled />
      </div>
      <div class="col-md-6">
        <label class="form-label">Return to Work Date</label>
        <input type="date" class="form-control" value="<?= htmlspecialchars($returnDateResult ?? '') ?>" disabled />
      </div>
    </div>

    <form method="post" class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($oldInput['start_date'] ?? '') ?>" required />
      </div>
      <div class="col-md-4">
        <label class="form-label">Leave Type</label>
        <select name="leave_type" class="form-select" required>
          <option value="">Select leave type</option>
          <option value="annual" <?= ((($oldInput['leave_type'] ?? '') === 'annual') ? 'selected' : '') ?>>Annual</option>
          <option value="sick" <?= ((($oldInput['leave_type'] ?? '') === 'sick') ? 'selected' : '') ?>>Sick</option>
          <option value="maternity" <?= ((($oldInput['leave_type'] ?? '') === 'maternity') ? 'selected' : '') ?>>Maternity</option>
          <option value="paternity" <?= ((($oldInput['leave_type'] ?? '') === 'paternity') ? 'selected' : '') ?>>Paternity</option>
          <option value="compassionate" <?= ((($oldInput['leave_type'] ?? '') === 'compassionate') ? 'selected' : '') ?>>Compassionate</option>
          <option value="casual" <?= ((($oldInput['leave_type'] ?? '') === 'casual') ? 'selected' : '') ?>>Casual</option>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">Number of Days</label>
        <input type="number" name="number_of_days" min="1" class="form-control" value="<?= htmlspecialchars($oldInput['number_of_days'] ?? '') ?>" required />
        <div class="form-text">Provide number of days; the calculator will compute the end date automatically.</div>
      </div>
      <div class="col-12">
        <button class="btn btn-primary" type="submit">Calculate</button>
      </div>
    </form>
  </div>
</div>

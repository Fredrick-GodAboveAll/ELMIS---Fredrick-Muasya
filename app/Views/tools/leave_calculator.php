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
    <?php if (!empty($leavePeriodResult)): ?>
      <div class="alert alert-info">Leave Period: <strong><?= htmlspecialchars((string)$leavePeriodResult) ?></strong></div>
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
        <select name="leave_type_id" class="form-select" required>
          <option value="">Select leave type</option>
          <?php foreach ($leaveTypes as $leaveType): ?>
            <?php $selected = ((string) ($oldInput['leave_type_id'] ?? '') === (string) $leaveType->id) ? 'selected' : ''; ?>
            <option value="<?= (int) $leaveType->id ?>" <?= $selected ?>><?= htmlspecialchars($leaveType->name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">Number of Days</label>
        <input type="number" name="number_of_days" min="1" class="form-control" value="<?= htmlspecialchars($oldInput['number_of_days'] ?? '') ?>" required />
        <div class="form-text" id="leaveEntitlementHint">Calculation is based on the selected leave type's calculation method.</div>
      </div>
      <div class="col-12">
        <button class="btn btn-primary" type="submit">Calculate</button>
      </div>
    </form>
  </div>
</div>

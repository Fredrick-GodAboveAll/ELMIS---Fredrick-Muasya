<?php
namespace App\Services;

use App\Models\LeaveType;
use InvalidArgumentException;

class LeaveTypeService
{
    private LeaveType $leaveTypeModel;

    public function __construct()
    {
        $this->leaveTypeModel = new LeaveType();
    }

    public function getAll(): array
    {
        return $this->leaveTypeModel->all();
    }

    public function findById(int $id): ?object
    {
        $leaveType = $this->leaveTypeModel->findById($id);
        return $leaveType ?: null;
    }

    public function findActiveById(int $id): ?object
    {
        $leaveType = $this->leaveTypeModel->findActiveById($id);
        return $leaveType ?: null;
    }

    // compatibility wrapper used by controllers expecting ->all()
    public function all(): array
    {
        return $this->getAll();
    }

    public function create(array $data): int
    {
        $name = trim((string) ($data['name'] ?? ($data['leave_name'] ?? '')));
        $calculationMethod = trim((string) ($data['calculation_method'] ?? 'working_days'));
        $isActive = isset($data['is_active']) ? (int) $data['is_active'] : 1;

        if ($name === '') {
            throw new InvalidArgumentException('Leave type name is required.');
        }

        if (!in_array($calculationMethod, ['working_days', 'calendar_days'], true)) {
            throw new InvalidArgumentException('Calculation method must be working_days or calendar_days.');
        }

        if (!in_array($isActive, [0, 1], true)) {
            throw new InvalidArgumentException('Active status is invalid.');
        }

        if ($this->leaveTypeModel->existsByName($name)) {
            throw new InvalidArgumentException('A leave type with this name already exists.');
        }

        $createdId = $this->leaveTypeModel->create([
            'name' => $name,
            'calculation_method' => $calculationMethod,
            'is_active' => $isActive,
        ]);

        if ($createdId === false) {
            throw new InvalidArgumentException('Unable to save the leave type. Please try again.');
        }

        return $createdId;
    }

    public function update(int $id, array $data): bool
    {
        $name = trim((string) ($data['name'] ?? ($data['leave_name'] ?? '')));
        $calculationMethod = trim((string) ($data['calculation_method'] ?? 'working_days'));
        $isActive = isset($data['is_active']) ? (int) $data['is_active'] : 1;

        if ($name === '') {
            throw new InvalidArgumentException('Leave type name is required.');
        }

        if (!in_array($calculationMethod, ['working_days', 'calendar_days'], true)) {
            throw new InvalidArgumentException('Calculation method must be working_days or calendar_days.');
        }

        if (!in_array($isActive, [0, 1], true)) {
            throw new InvalidArgumentException('Active status is invalid.');
        }

        $existing = $this->leaveTypeModel->findById($id);
        if (!$existing) {
            throw new InvalidArgumentException('The selected leave type could not be found.');
        }

        if (strtolower($existing->name) !== strtolower($name) && $this->leaveTypeModel->existsByName($name)) {
            throw new InvalidArgumentException('A leave type with this name already exists.');
        }

        return $this->leaveTypeModel->update($id, [
            'name' => $name,
            'calculation_method' => $calculationMethod,
            'is_active' => $isActive,
        ]);
    }
}

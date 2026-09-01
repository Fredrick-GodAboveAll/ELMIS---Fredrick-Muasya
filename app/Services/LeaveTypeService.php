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

    public function create(array $data): int
    {
        $name = trim((string) ($data['name'] ?? ''));
        $annualEntitlementValue = (float) ($data['annual_entitlement_value'] ?? 0);
        $calculationMethod = trim((string) ($data['calculation_method'] ?? 'working_days'));
        $carryForward = (int) ($data['carry_forward'] ?? 0);
        $carryForwardLimit = (float) ($data['carry_forward_limit'] ?? 0);

        if ($name === '') {
            throw new InvalidArgumentException('Leave type name is required.');
        }

        if ($annualEntitlementValue < 0) {
            throw new InvalidArgumentException('Annual entitlement must be 0 or greater.');
        }

        if (!in_array($calculationMethod, ['working_days', 'calendar_days'], true)) {
            throw new InvalidArgumentException('Calculation method must be working_days or calendar_days.');
        }

        if (!in_array($carryForward, [0, 1], true)) {
            throw new InvalidArgumentException('Carry forward value is invalid.');
        }

        if ($carryForward === 0 && $carryForwardLimit > 0) {
            $carryForwardLimit = 0;
        }

        if ($carryForward === 1 && $carryForwardLimit < 0) {
            throw new InvalidArgumentException('Carry forward limit cannot be negative.');
        }

        if ($this->leaveTypeModel->existsByName($name)) {
            throw new InvalidArgumentException('A leave type with this name already exists.');
        }

        $createdId = $this->leaveTypeModel->create([
            'name' => $name,
            'annual_entitlement_value' => number_format($annualEntitlementValue, 2, '.', ''),
            'calculation_method' => $calculationMethod,
            'carry_forward' => $carryForward,
            'carry_forward_limit' => number_format($carryForwardLimit, 2, '.', ''),
            'is_active' => 1,
        ]);

        if ($createdId === false) {
            throw new InvalidArgumentException('Unable to save the leave type. Please try again.');
        }

        return $createdId;
    }
}

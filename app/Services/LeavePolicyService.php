<?php
namespace App\Services;

use App\Models\LeavePolicy;
use InvalidArgumentException;

class LeavePolicyService
{
    private LeavePolicy $leavePolicyModel;

    public function __construct()
    {
        $this->leavePolicyModel = new LeavePolicy();
    }

    public function all(): array
    {
        return $this->leavePolicyModel->all();
    }

    public function findById(int $id)
    {
        $policy = $this->leavePolicyModel->findById($id);
        if (!$policy) {
            throw new InvalidArgumentException('The selected policy could not be found.');
        }

        return $policy;
    }

    public function create(array $data): int
    {
        $name = trim((string) ($data['name'] ?? ''));
        $description = isset($data['description']) ? trim((string) $data['description']) : '';
        $isActive = isset($data['is_active']) ? (int) $data['is_active'] : 1;

        if ($name === '') {
            throw new InvalidArgumentException('Policy name is required.');
        }

        if (!in_array($isActive, [0, 1], true)) {
            throw new InvalidArgumentException('Active status is invalid.');
        }

        if ($this->leavePolicyModel->existsByName($name)) {
            throw new InvalidArgumentException('A policy with this name already exists.');
        }

        $createdId = $this->leavePolicyModel->create([
            'name' => $name,
            'description' => $description,
            'is_active' => $isActive,
        ]);

        if ($createdId === false) {
            throw new InvalidArgumentException('Unable to save the policy. Please try again.');
        }

        return $createdId;
    }
}

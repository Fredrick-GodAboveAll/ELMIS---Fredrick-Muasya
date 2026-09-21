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

    /**
     * Return policies with configured counts for a financial year
     */
    public function allWithEntitlementCounts(?int $financialYearId): array
    {
        return $this->leavePolicyModel->allWithEntitlementCounts($financialYearId);
    }

    public function setActive(int $id, int $isActive): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid policy id.');
        }

        if (!in_array($isActive, [0, 1], true)) {
            throw new InvalidArgumentException('Invalid active flag.');
        }

        return $this->leavePolicyModel->setActive($id, $isActive);
    }

    public function create(array $data): int
    {
        $name = trim((string) ($data['name'] ?? ''));
        $description = isset($data['description']) ? trim((string) $data['description']) : '';
        $hasIsActive = array_key_exists('is_active', $data);
        $isActive = $hasIsActive ? (int) $data['is_active'] : null;

        if ($name === '') {
            throw new InvalidArgumentException('Policy name is required.');
        }

        if ($hasIsActive && !in_array($isActive, [0, 1], true)) {
            throw new InvalidArgumentException('Active status is invalid.');
        }

        if ($this->leavePolicyModel->existsByName($name)) {
            throw new InvalidArgumentException('A policy with this name already exists.');
        }

        $payload = [
            'name' => $name,
            'description' => $description,
        ];
        if ($hasIsActive) {
            $payload['is_active'] = $isActive;
        }

        $createdId = $this->leavePolicyModel->create($payload);

        if ($createdId === false) {
            throw new InvalidArgumentException('Unable to save the policy. Please try again.');
        }

        return $createdId;
    }
}

<?php
namespace App\Services;

use App\Core\Database;
use App\Models\LeavePolicy;
use InvalidArgumentException;
use PDO;

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

    public function findPolicy(int $id): ?object
    {
        $stmt = $this->leavePolicyModel->findById($id);
        return $stmt ?: null;
    }

    public function getEntitlementsWithDetails(int $policyId, int $fyId): array
    {
        if ($policyId <= 0 || $fyId <= 0) {
            return [];
        }

        $sql = "SELECT
                le.id AS entitlement_id,
                lt.name AS leave_type_name,
                lt.calculation_method,
                le.entitlement AS base_entitlement,
                le.carry_forward,
                le.carry_forward_limit,
                lpd.id AS detail_id,
                lpd.allocation AS allocation
            FROM leave_entitlements le
            JOIN leave_types lt ON lt.id = le.leave_type_id
            LEFT JOIN leave_policy_details lpd
                ON lpd.leave_entitlement_id = le.id
                AND lpd.leave_policy_id = :policy_id
            WHERE le.financial_year_id = :fy_id
            ORDER BY lt.name ASC";

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([
            'policy_id' => $policyId,
            'fy_id' => $fyId,
        ]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function upsertDetail(int $policyId, int $entitlementId, float $allocation): void
    {
        if ($policyId <= 0 || $entitlementId <= 0) {
            throw new InvalidArgumentException('Invalid policy or entitlement id.');
        }

        $sql = "INSERT INTO leave_policy_details
                (leave_policy_id, leave_entitlement_id, allocation)
                VALUES (:policy_id, :entitlement_id, :allocation)
                ON DUPLICATE KEY UPDATE allocation = VALUES(allocation)";

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([
            'policy_id' => $policyId,
            'entitlement_id' => $entitlementId,
            'allocation' => (float) $allocation,
        ]);
    }

    public function deleteDetail(int $policyId, int $entitlementId): void
    {
        if ($policyId <= 0 || $entitlementId <= 0) {
            throw new InvalidArgumentException('Invalid policy or entitlement id.');
        }

        $sql = "DELETE FROM leave_policy_details
                WHERE leave_policy_id = :policy_id
                  AND leave_entitlement_id = :entitlement_id";

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([
            'policy_id' => $policyId,
            'entitlement_id' => $entitlementId,
        ]);
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

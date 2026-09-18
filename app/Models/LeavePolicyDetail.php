<?php
namespace App\Models;

use PDO;

class LeavePolicyDetail extends Model
{
    protected $table = 'leave_policy_details';

    public function findByPolicyId(int $policyId): array
    {
        $sql = "SELECT lpd.*, le.financial_year_id, le.leave_type_id, fy.label AS financial_year_label, lt.name AS leave_type_name
                FROM {$this->table} lpd
                INNER JOIN leave_entitlements le ON le.id = lpd.leave_entitlement_id
                INNER JOIN financial_years fy ON fy.id = le.financial_year_id
                INNER JOIN leave_types lt ON lt.id = le.leave_type_id
                WHERE lpd.leave_policy_id = :policy_id
                ORDER BY fy.start_date DESC, lt.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['policy_id' => $policyId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findByPolicyAndYear(int $policyId, int $financialYearId): array
    {
        $sql = "SELECT lpd.id, lpd.leave_policy_id, lpd.leave_entitlement_id, lpd.allocation
                FROM {$this->table} lpd
                INNER JOIN leave_entitlements le ON le.id = lpd.leave_entitlement_id
                WHERE lpd.leave_policy_id = :policy_id AND le.financial_year_id = :financial_year_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'policy_id' => $policyId,
            'financial_year_id' => $financialYearId,
        ]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function existsForPolicyAndEntitlement(int $policyId, int $leaveEntitlementId): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE leave_policy_id = ? AND leave_entitlement_id = ? LIMIT 1");
        $stmt->execute([$policyId, $leaveEntitlementId]);

        return (bool) $stmt->fetchColumn();
    }

    public function upsert(int $policyId, int $leaveEntitlementId, float $allocation): bool
    {
        if ($this->existsForPolicyAndEntitlement($policyId, $leaveEntitlementId)) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET allocation = :allocation, updated_at = CURRENT_TIMESTAMP WHERE leave_policy_id = :policy_id AND leave_entitlement_id = :leave_entitlement_id");
            return $stmt->execute([
                'allocation' => $allocation,
                'policy_id' => $policyId,
                'leave_entitlement_id' => $leaveEntitlementId,
            ]);
        }

        $stmt = $this->db->prepare("INSERT INTO {$this->table} (leave_policy_id, leave_entitlement_id, allocation) VALUES (:policy_id, :leave_entitlement_id, :allocation)");
        return $stmt->execute([
            'policy_id' => $policyId,
            'leave_entitlement_id' => $leaveEntitlementId,
            'allocation' => $allocation,
        ]);
    }

    public function deleteById(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deleteByPolicyAndEntitlement(int $policyId, int $leaveEntitlementId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE leave_policy_id = ? AND leave_entitlement_id = ?");
        return $stmt->execute([$policyId, $leaveEntitlementId]);
    }
}

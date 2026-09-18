<?php
namespace App\Services;

use App\Models\FinancialYear;
use App\Models\LeaveEntitlement;
use App\Models\LeavePolicy;
use App\Models\LeavePolicyDetail;
use InvalidArgumentException;

class LeavePolicyDetailService
{
    private LeavePolicy $leavePolicyModel;
    private LeavePolicyDetail $leavePolicyDetailModel;
    private LeaveEntitlement $leaveEntitlementModel;
    private FinancialYear $financialYearModel;

    public function __construct()
    {
        $this->leavePolicyModel = new LeavePolicy();
        $this->leavePolicyDetailModel = new LeavePolicyDetail();
        $this->leaveEntitlementModel = new LeaveEntitlement();
        $this->financialYearModel = new FinancialYear();
    }

    public function getPolicy(int $policyId)
    {
        $policy = $this->leavePolicyModel->findById($policyId);
        if (!$policy) {
            throw new InvalidArgumentException('The selected policy could not be found.');
        }

        return $policy;
    }

    public function getAvailableFinancialYears(): array
    {
        return $this->financialYearModel->all();
    }

    public function getEntitlementsForYear(int $financialYearId): array
    {
        $sql = "SELECT le.id AS entitlement_id, le.financial_year_id, le.leave_type_id, le.entitlement, le.carry_forward, le.carry_forward_limit, lt.name AS leave_type_name, fy.label AS financial_year_label
                FROM leave_entitlements le
                INNER JOIN leave_types lt ON lt.id = le.leave_type_id
                INNER JOIN financial_years fy ON fy.id = le.financial_year_id
                WHERE le.financial_year_id = :financial_year_id
                ORDER BY lt.name ASC";

        $stmt = $this->leavePolicyDetailModel->db->prepare($sql);
        $stmt->execute(['financial_year_id' => $financialYearId]);

        return $stmt->fetchAll();
    }

    public function getPolicyDetailsForYear(int $policyId, int $financialYearId): array
    {
        return $this->leavePolicyDetailModel->findByPolicyAndYear($policyId, $financialYearId);
    }

    public function savePolicyDetail(int $policyId, int $leaveEntitlementId, float $allocation): bool
    {
        $policy = $this->leavePolicyModel->findById($policyId);
        if (!$policy) {
            throw new InvalidArgumentException('The selected policy could not be found.');
        }

        $entitlement = $this->leaveEntitlementModel->findById($leaveEntitlementId);
        if (!$entitlement) {
            throw new InvalidArgumentException('The selected entitlement could not be found.');
        }

        if (!is_numeric($allocation) || (float) $allocation < 0) {
            throw new InvalidArgumentException('Allocation must be a valid non-negative number.');
        }

        $normalized = (float) $allocation;
        $rounded = round($normalized, 2);

        // Keep the DECIMAL(6,2) constraint aligned with the schema by validating sensible range.
        if ($rounded < 0 || $rounded > 9999.99) {
            throw new InvalidArgumentException('Allocation must be between 0 and 9999.99.');
        }

        return $this->leavePolicyDetailModel->upsert($policyId, $leaveEntitlementId, $rounded);
    }
}

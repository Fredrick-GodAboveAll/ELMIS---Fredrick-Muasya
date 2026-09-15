<?php
namespace App\Services;

use App\Models\LeaveEntitlement;

class LeaveEntitlementService
{
    private LeaveEntitlement $leaveEntitlementModel;

    public function __construct()
    {
        $this->leaveEntitlementModel = new LeaveEntitlement();
    }

    public function getFinancialYearConfigurationSummary(): array
    {
        $years = $this->leaveEntitlementModel->getFinancialYearConfigurationSummary();

        foreach ($years as $year) {
            $year->active_leave_type_count = (int) ($year->active_leave_type_count ?? 0);
            $year->entitlement_rule_count = (int) ($year->entitlement_rule_count ?? 0);
            $year->configuration_status = $this->resolveConfigurationStatus($year->entitlement_rule_count, $year->active_leave_type_count);
            $year->configuration_text = $this->buildConfigurationText($year->entitlement_rule_count, $year->active_leave_type_count);
            $year->display_label = $this->formatYearLabel((string) $year->label);
        }

        return $years;
    }

    public function getFinancialYearSummary(): array
    {
        return $this->getFinancialYearConfigurationSummary();
    }

    public function getEntitlementsForYear(string $yearLabel): array
    {
        $normalized = $this->normalizeYearLabel($yearLabel);

        return $this->leaveEntitlementModel->findByYearLabel($normalized);
    }

    public function getAvailableLeaveTypesForYear(string $yearLabel): array
    {
        $normalized = $this->normalizeYearLabel($yearLabel);
        $financialYearModel = new \App\Models\FinancialYear();
        $fy = $financialYearModel->findByLabel($normalized);
        if (!$fy) {
            return [];
        }

        return $this->leaveEntitlementModel->getEligibleLeaveTypesForYear((int) $fy->id);
    }

    public function create(string $yearLabel, array $data)
    {
        $normalized = $this->normalizeYearLabel($yearLabel);

        $financialYearModel = new \App\Models\FinancialYear();
        $fy = $financialYearModel->findByLabel($normalized);
        if (!$fy) {
            throw new \InvalidArgumentException('Selected financial year could not be found.');
        }

        $financialYearId = (int) $fy->id;

        $leaveTypeService = new \App\Services\LeaveTypeService();
        $leaveType = $leaveTypeService->findActiveById((int) ($data['leave_type_id'] ?? 0));
        if (!$leaveType) {
            throw new \InvalidArgumentException('Selected leave type is invalid or inactive.');
        }

        // Entitlement must be numeric, whole number and >= 0
        if (!isset($data['entitlement']) || !is_numeric($data['entitlement'])) {
            throw new \InvalidArgumentException('Entitlement must be a whole number.');
        }
        if ((float) $data['entitlement'] != (int) $data['entitlement']) {
            throw new \InvalidArgumentException('Entitlement must be a whole number.');
        }
        $entitlement = (int) $data['entitlement'];
        if ($entitlement < 0) {
            throw new \InvalidArgumentException('Entitlement must be 0 or greater.');
        }

        // carry_forward must be 0 or 1
        $carryForward = isset($data['carry_forward']) && ((int) $data['carry_forward'] === 1) ? 1 : 0;

        // carry_forward_limit: when carry_forward is 0 it must be exactly 0; when 1 it must be a whole number >=0
        if (!isset($data['carry_forward_limit']) || $data['carry_forward_limit'] === '') {
            $carryForwardLimitRaw = 0;
        } else {
            $carryForwardLimitRaw = $data['carry_forward_limit'];
        }

        if ($carryForward === 0) {
            if (!is_numeric($carryForwardLimitRaw) || (int) $carryForwardLimitRaw !== 0) {
                throw new \InvalidArgumentException('Maximum carry forward must be 0 when carry forward is disabled.');
            }
            $carryForwardLimit = 0;
        } else {
            if (!is_numeric($carryForwardLimitRaw)) {
                throw new \InvalidArgumentException('Maximum carry forward must be a whole number.');
            }
            if ((float) $carryForwardLimitRaw != (int) $carryForwardLimitRaw) {
                throw new \InvalidArgumentException('Maximum carry forward must be a whole number.');
            }
            $carryForwardLimit = (int) $carryForwardLimitRaw;
            if ($carryForwardLimit < 0) {
                throw new \InvalidArgumentException('Maximum carry forward must be 0 or greater.');
            }
        }


        // Prevent duplicates (application-level check before attempting insert)
        if ($this->leaveEntitlementModel->existsForYearType($financialYearId, (int) $data['leave_type_id'])) {
            throw new \InvalidArgumentException('An entitlement for this leave type already exists for the selected financial year.');
        }

        $insertData = [
            'financial_year_id' => $financialYearId,
            'leave_type_id' => (int) $data['leave_type_id'],
            'entitlement' => $entitlement,
            'carry_forward' => $carryForward,
            'carry_forward_limit' => $carryForwardLimit,
        ];

        try {
            $createdId = $this->leaveEntitlementModel->create($insertData);
        } catch (\PDOException $e) {
            // A PDO exception may occur on duplicate key race. Provide a friendly
            // message when the entitlement now exists; otherwise return a generic error.
            if ($this->leaveEntitlementModel->existsForYearType($financialYearId, (int) $data['leave_type_id'])) {
                throw new \InvalidArgumentException('An entitlement for this leave type already exists for the selected financial year. The configuration may have been updated since this page was opened.');
            }

            throw new \InvalidArgumentException('Unable to save the entitlement. Please try again.');
        }

        if ($createdId === false) {
            throw new \InvalidArgumentException('Unable to save the entitlement. Please try again.');
        }

        return $createdId;
    }

    public function getCurrentOrLatestYearLabel(): string
    {
        $years = $this->getFinancialYearSummary();

        if (empty($years)) {
            return '';
        }

        foreach ($years as $year) {
            if (!empty($year->is_current)) {
                return (string) $year->label;
            }
        }

        return (string) $years[0]->label;
    }

    private function normalizeYearLabel(string $yearLabel): string
    {
        $value = trim((string) $yearLabel);
        $value = str_replace(' ', '', $value);
        $value = str_replace('–', '/', $value);
        $value = str_replace('—', '/', $value);
        $value = preg_replace('/\s*\/\s*/', '/', $value) ?? $value;

        return $value;
    }

    private function formatYearLabel(string $yearLabel): string
    {
        $normalized = $this->normalizeYearLabel($yearLabel);
        return str_replace('/', ' / ', $normalized);
    }

    private function resolveConfigurationStatus(int $configuredCount, int $activeCount): string
    {
        if ($activeCount <= 0) {
            return 'Not Configured';
        }

        if ($configuredCount === 0) {
            return 'Not Configured';
        }

        if ($configuredCount < $activeCount) {
            return 'Configured';
        }

        return 'Fully Configured';
    }

    private function buildConfigurationText(int $configuredCount, int $activeCount): string
    {
        $safeActiveCount = max(0, $activeCount);
        $safeConfiguredCount = max(0, $configuredCount);

        if ($safeActiveCount <= 0) {
            return '0 of 0 configured';
        }

        return $safeConfiguredCount . ' of ' . $safeActiveCount . ' configured';
    }
}

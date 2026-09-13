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

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

    public function getFinancialYearSummary(): array
    {
        $years = $this->leaveEntitlementModel->getFinancialYearSummary();

        foreach ($years as $year) {
            $year->status = $this->resolveStatus($year);
            $year->display_label = $this->formatYearLabel((string) $year->label);
            $year->entitlement_rule_count = (int) ($year->entitlement_rule_count ?? 0);
            $year->active_leave_type_count = (int) ($year->active_leave_type_count ?? 0);
        }

        return $years;
    }

    public function getEntitlementsForYear(string $yearLabel): array
    {
        $normalized = $this->normalizeYearLabel($yearLabel);
        $rows = $this->leaveEntitlementModel->findByYearLabel($normalized);

        foreach ($rows as $row) {
            $row->display_label = $this->formatYearLabel((string) ($row->financial_year_label ?? $normalized));
            $row->leave_type_name = $row->leave_type_name ?? 'Unassigned';
            $row->entitlement = (float) ($row->entitlement ?? 0);
            $row->carry_forward = (bool) ($row->carry_forward ?? 0);
            $row->carry_forward_limit = (float) ($row->carry_forward_limit ?? 0);
        }

        return $rows;
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

    private function resolveStatus(object $year): string
    {
        if (!empty($year->is_current)) {
            return 'Active';
        }

        $startDate = new \DateTimeImmutable((string) $year->start_date);
        $today = new \DateTimeImmutable('now');

        if ($startDate > $today) {
            return 'Upcoming';
        }

        return 'Closed';
    }
}

<?php
namespace App\Services;

use App\Models\FinancialYear;

class LeavePeriodService
{
    private FinancialYear $financialYearModel;

    public function __construct()
    {
        $this->financialYearModel = new FinancialYear();
    }

    public function resolveForDate(string $date): ?object
    {
        return $this->financialYearModel->findByDate($date) ?: null;
    }
}

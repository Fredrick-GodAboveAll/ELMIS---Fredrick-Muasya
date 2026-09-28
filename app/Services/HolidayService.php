<?php
namespace App\Services;

use App\Models\FinancialYear;
use App\Models\Holiday;

class HolidayService
{
    private Holiday $holidayModel;
    private FinancialYear $financialYearModel;

    public function __construct()
    {
        $this->holidayModel = new Holiday();
        $this->financialYearModel = new FinancialYear();
    }

    public function getHolidayListsForPage(): array
    {
        return $this->holidayModel->getHolidayListsWithYearAndCounts();
    }

    public function getFinancialYears(): array
    {
        return $this->financialYearModel->all();
    }

    public function getHolidayListDetailById(int $id): ?object
    {
        return $this->holidayModel->getHolidayListDetail($id);
    }

    public function getHolidaysForList(int $holidayListId): array
    {
        return $this->holidayModel->getHolidaysForList($holidayListId);
    }

    public function createHolidayList(array $data): int|false
    {
        $name = trim((string) ($data['name'] ?? ''));
        $financialYearId = (int) ($data['financial_year_id'] ?? 0);
        $isDefault = isset($data['is_default']) ? (int) $data['is_default'] : 0;
        $isActive = array_key_exists('is_active', $data) ? (int) $data['is_active'] : 1;

        if ($name === '') {
            throw new \InvalidArgumentException('Holiday list name is required.');
        }

        if ($financialYearId <= 0) {
            throw new \InvalidArgumentException('Financial year is required.');
        }

        if (!in_array($isDefault, [0, 1], true)) {
            throw new \InvalidArgumentException('Default / Primary value is invalid.');
        }

        if (!in_array($isActive, [0, 1], true)) {
            throw new \InvalidArgumentException('Active / Inactive value is invalid.');
        }

        return $this->holidayModel->create([
            'name' => $name,
            'financial_year_id' => $financialYearId,
            'is_default' => $isDefault,
            'is_active' => $isActive,
        ]);
    }

    public function setActive(int $id, int $isActive): bool
    {
        if (!in_array($isActive, [0, 1], true)) {
            throw new \InvalidArgumentException('Invalid holiday list status.');
        }

        return $this->holidayModel->setActive($id, $isActive);
    }

    public function createHoliday(array $data): int|false
    {
        $holidayListId = (int) ($data['holiday_list_id'] ?? 0);
        $name = trim((string) ($data['name'] ?? ''));
        $holidayDate = trim((string) ($data['holiday_date'] ?? ''));
        $isWeeklyOff = array_key_exists('is_weekly_off', $data) ? (int) $data['is_weekly_off'] : 0;

        if ($holidayListId <= 0) {
            throw new \InvalidArgumentException('A valid holiday list is required.');
        }

        if ($name === '') {
            throw new \InvalidArgumentException('Holiday name is required.');
        }

        if ($holidayDate === '') {
            throw new \InvalidArgumentException('Holiday date is required.');
        }

        $date = \DateTime::createFromFormat('Y-m-d', $holidayDate);
        if ($date === false || $date->format('Y-m-d') !== $holidayDate) {
            $date = new \DateTime($holidayDate);
        }

        if ($date === false || $date->format('Y-m-d') === '1970-01-01') {
            throw new \InvalidArgumentException('Holiday date is invalid.');
        }

        if (!in_array($isWeeklyOff, [0, 1], true)) {
            throw new \InvalidArgumentException('Weekly off flag is invalid.');
        }

        return $this->holidayModel->createHoliday([
            'holiday_list_id' => $holidayListId,
            'name' => $name,
            'holiday_date' => $date->format('Y-m-d'),
            'is_weekly_off' => $isWeeklyOff,
        ]);
    }
}

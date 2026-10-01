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

    public function getHolidaysForList(int $holidayListId, int $financialYearId): array
    {
        return $this->holidayModel->getHolidaysForList($holidayListId, $financialYearId);
    }

    public function createHolidayList(array $data): int|false
    {
        $name = trim((string) ($data['name'] ?? ''));
        $isActive = array_key_exists('is_active', $data) ? (int) $data['is_active'] : 1;

        if ($name === '') {
            throw new \InvalidArgumentException('Holiday list name is required.');
        }

        if (!in_array($isActive, [0, 1], true)) {
            throw new \InvalidArgumentException('Active / Inactive value is invalid.');
        }

        return $this->holidayModel->create([
            'name' => $name,
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
        $financialYearId = (int) ($data['financial_year_id'] ?? 0);
        $name = trim((string) ($data['name'] ?? ''));
        $holidayDate = trim((string) ($data['holiday_date'] ?? ''));
        $isWeeklyOff = array_key_exists('is_weekly_off', $data) ? (int) $data['is_weekly_off'] : 0;

        $date = $this->validateHolidayData($holidayListId, $financialYearId, $name, $holidayDate, $isWeeklyOff);

        return $this->holidayModel->createHoliday([
            'holiday_list_id' => $holidayListId,
            'financial_year_id' => $financialYearId,
            'name' => $name,
            'holiday_date' => $date,
            'is_weekly_off' => $isWeeklyOff,
        ]);
    }

    public function updateHoliday(array $data): bool
    {
        $holidayId = (int) ($data['holiday_id'] ?? 0);
        $holidayListId = (int) ($data['holiday_list_id'] ?? 0);
        $financialYearId = (int) ($data['financial_year_id'] ?? 0);
        $name = trim((string) ($data['name'] ?? ''));
        $holidayDate = trim((string) ($data['holiday_date'] ?? ''));
        $isWeeklyOff = array_key_exists('is_weekly_off', $data) ? (int) $data['is_weekly_off'] : 0;

        if ($holidayId <= 0 || !$this->holidayModel->findHolidayForList($holidayId, $holidayListId, $financialYearId)) {
            throw new \InvalidArgumentException('Holiday not found in this list.');
        }

        $date = $this->validateHolidayData($holidayListId, $financialYearId, $name, $holidayDate, $isWeeklyOff);

        return $this->holidayModel->updateHoliday($holidayId, $holidayListId, $financialYearId, $name, $date, $isWeeklyOff);
    }

    public function deleteHoliday(int $holidayId, int $holidayListId, int $financialYearId): bool
    {
        if ($holidayId <= 0 || $holidayListId <= 0 || $financialYearId <= 0 || !$this->holidayModel->findHolidayForList($holidayId, $holidayListId, $financialYearId)) {
            throw new \InvalidArgumentException('Holiday not found in this list.');
        }

        return $this->holidayModel->deleteHoliday($holidayId, $holidayListId, $financialYearId);
    }

    private function validateHolidayData(int $holidayListId, int $financialYearId, string $name, string $holidayDate, int $isWeeklyOff): string
    {
        $date = $this->validateHolidayInput($name, $holidayDate, $isWeeklyOff);

        if ($holidayListId <= 0) {
            throw new \InvalidArgumentException('A valid holiday list is required.');
        }

        if ($financialYearId <= 0) {
            throw new \InvalidArgumentException('A valid financial year is required.');
        }

        $holidayList = $this->holidayModel->getHolidayListDetail($holidayListId);
        if (!$holidayList) {
            throw new \InvalidArgumentException('Holiday list not found.');
        }

        $financialYear = $this->financialYearModel->find($financialYearId);
        if (!$financialYear) {
            throw new \InvalidArgumentException('Financial year not found.');
        }

        if ($date < $financialYear->start_date || $date > $financialYear->end_date) {
            throw new \InvalidArgumentException('Holiday date must be within the selected financial year.');
        }

        return $date;
    }

    private function validateHolidayInput(string $name, string $holidayDate, int $isWeeklyOff): string
    {
        if ($name === '') {
            throw new \InvalidArgumentException('Holiday name is required.');
        }

        $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $holidayDate);
        $dateErrors = \DateTimeImmutable::getLastErrors();
        if ($date === false || ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))) {
            throw new \InvalidArgumentException('Holiday date is invalid.');
        }

        if (!in_array($isWeeklyOff, [0, 1], true)) {
            throw new \InvalidArgumentException('Weekly off flag is invalid.');
        }

        return $date->format('Y-m-d');
    }
}

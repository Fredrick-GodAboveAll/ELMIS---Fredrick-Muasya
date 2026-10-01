<?php
namespace App\Models;

use PDO;

class Holiday extends Model
{
    protected $table = 'holiday_lists';

    public function getHolidayListsWithYearAndCounts(): array
    {
        $sql = "SELECT hl.id,
                       hl.name,
                       hl.is_active,
                       COUNT(h.id) AS holidays_count,
                       COALESCE(GROUP_CONCAT(DISTINCT fy.label ORDER BY fy.start_date SEPARATOR ', '), 'All FYs') AS financial_year_label
                FROM {$this->table} hl
                LEFT JOIN holidays h ON h.holiday_list_id = hl.id
                LEFT JOIN financial_years fy ON fy.id = h.financial_year_id
                GROUP BY hl.id, hl.name, hl.is_active
                ORDER BY hl.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getHolidayListDetail(int $id): ?object
    {
        $sql = "SELECT hl.id,
                   hl.name,
                   hl.is_active
                FROM {$this->table} hl
                WHERE hl.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ?: null;
    }

    public function getHolidaysForList(int $holidayListId, int $financialYearId): array
    {
        $sql = "SELECT h.id,
                       h.holiday_date,
                       h.name,
                       h.is_weekly_off,
                       h.holiday_list_id,
                       h.financial_year_id
                FROM holidays h
                WHERE h.holiday_list_id = :holiday_list_id
                  AND h.financial_year_id = :financial_year_id
                ORDER BY h.holiday_date ASC, h.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':holiday_list_id' => $holidayListId,
            ':financial_year_id' => $financialYearId,
        ]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function create(array $data): int|false
    {
        $name = trim((string) ($data['name'] ?? ''));
        $isActive = array_key_exists('is_active', $data) ? (int) $data['is_active'] : 1;

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (name, is_active) VALUES (:name, :is_active)"
        );
        $ok = $stmt->execute([
            ':name' => $name,
            ':is_active' => $isActive,
        ]);

        return $ok ? (int) $this->db->lastInsertId() : false;
    }

    public function findHolidayForList(int $holidayId, int $holidayListId, int $financialYearId): ?object
    {
        $sql = "SELECT id, name, holiday_date, is_weekly_off
                FROM holidays
                WHERE id = :id
                  AND holiday_list_id = :holiday_list_id
                  AND financial_year_id = :financial_year_id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $holidayId,
            ':holiday_list_id' => $holidayListId,
            ':financial_year_id' => $financialYearId,
        ]);

        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row ?: null;
    }

        public function updateHoliday(int $holidayId, int $holidayListId, int $financialYearId, string $name, string $holidayDate, int $isWeeklyOff): bool
    {
        $sql = "UPDATE holidays
                SET name = :name, holiday_date = :holiday_date, is_weekly_off = :is_weekly_off
                                WHERE id = :id
                                    AND holiday_list_id = :holiday_list_id
                                    AND financial_year_id = :financial_year_id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':holiday_date' => $holidayDate,
            ':is_weekly_off' => $isWeeklyOff,
            ':id' => $holidayId,
            ':holiday_list_id' => $holidayListId,
            ':financial_year_id' => $financialYearId,
        ]);
    }

    public function deleteHoliday(int $holidayId, int $holidayListId, int $financialYearId): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM holidays
             WHERE id = :id AND holiday_list_id = :holiday_list_id AND financial_year_id = :financial_year_id"
        );

        return $stmt->execute([
            ':id' => $holidayId,
            ':holiday_list_id' => $holidayListId,
            ':financial_year_id' => $financialYearId,
        ]);
    }

    public function setActive(int $id, int $isActive): bool
    {
        $sql = "UPDATE {$this->table} SET is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return (bool) $stmt->execute([
            'is_active' => (int) $isActive,
            'id' => $id,
        ]);
    }

    public function createHoliday(array $data): int|false
    {
        $holidayListId = (int) ($data['holiday_list_id'] ?? 0);
        $financialYearId = (int) ($data['financial_year_id'] ?? 0);
        $name = trim((string) ($data['name'] ?? ''));
        $holidayDate = trim((string) ($data['holiday_date'] ?? ''));
        $isWeeklyOff = array_key_exists('is_weekly_off', $data) ? (int) $data['is_weekly_off'] : 0;

        $sql = "INSERT INTO holidays (holiday_list_id, financial_year_id, name, holiday_date, is_weekly_off)
            VALUES (:holiday_list_id, :financial_year_id, :name, :holiday_date, :is_weekly_off)";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            ':holiday_list_id' => $holidayListId,
            ':financial_year_id' => $financialYearId,
            ':name' => $name,
            ':holiday_date' => $holidayDate,
            ':is_weekly_off' => $isWeeklyOff,
        ]);

        if (!$ok) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }
}

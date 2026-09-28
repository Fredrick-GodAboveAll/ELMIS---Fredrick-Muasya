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
                       hl.is_default,
                       hl.is_active,
                       fy.label AS financial_year_label,
                       fy.start_date,
                       fy.end_date,
                       COUNT(h.id) AS holidays_count
                FROM {$this->table} hl
                LEFT JOIN financial_years fy ON fy.id = hl.financial_year_id
                LEFT JOIN holidays h ON h.holiday_list_id = hl.id
                GROUP BY hl.id, hl.name, hl.is_default, hl.is_active, fy.label, fy.start_date, fy.end_date
                ORDER BY fy.start_date DESC, hl.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getHolidayListDetail(int $id): ?object
    {
        $sql = "SELECT hl.id,
                       hl.name,
                       hl.is_default,
                       hl.is_active,
                       fy.label AS financial_year_label,
                       fy.start_date,
                       fy.end_date
                FROM {$this->table} hl
                LEFT JOIN financial_years fy ON fy.id = hl.financial_year_id
                WHERE hl.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ?: null;
    }

    public function getHolidaysForList(int $holidayListId): array
    {
        $sql = "SELECT h.id,
                       h.holiday_date,
                       h.name,
                       h.is_weekly_off,
                       h.holiday_list_id
                FROM holidays h
                WHERE h.holiday_list_id = :holiday_list_id
                ORDER BY h.holiday_date ASC, h.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':holiday_list_id' => $holidayListId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function create(array $data): int|false
    {
        $name = trim((string) ($data['name'] ?? ''));
        $financialYearId = (int) ($data['financial_year_id'] ?? 0);
        $isDefault = isset($data['is_default']) ? (int) $data['is_default'] : 0;
        $isActive = array_key_exists('is_active', $data) ? (int) $data['is_active'] : 1;

        if ($isDefault === 1) {
            $resetStmt = $this->db->prepare("UPDATE {$this->table} SET is_default = 0, updated_at = CURRENT_TIMESTAMP WHERE is_default = 1");
            $resetStmt->execute();
        }

        $sql = "INSERT INTO {$this->table} (financial_year_id, name, is_default, is_active)
                VALUES (:financial_year_id, :name, :is_default, :is_active)";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            ':financial_year_id' => $financialYearId,
            ':name' => $name,
            ':is_default' => $isDefault,
            ':is_active' => $isActive,
        ]);

        if (!$ok) {
            return false;
        }

        return (int) $this->db->lastInsertId();
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
        $name = trim((string) ($data['name'] ?? ''));
        $holidayDate = trim((string) ($data['holiday_date'] ?? ''));
        $isWeeklyOff = array_key_exists('is_weekly_off', $data) ? (int) $data['is_weekly_off'] : 0;

        $sql = "INSERT INTO holidays (holiday_list_id, name, holiday_date, is_weekly_off)
                VALUES (:holiday_list_id, :name, :holiday_date, :is_weekly_off)";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            ':holiday_list_id' => $holidayListId,
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

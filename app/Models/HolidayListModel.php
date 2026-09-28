<?php
namespace App\Models;

use PDO;

class HolidayListModel extends Model
{
    protected $table = 'holiday_lists';

    public function allWithFinancialYearAndCount(): array
    {
        $sql = "SELECT
                    hl.id,
                    hl.name,
                    hl.is_active,
                    hl.is_default,
                    fy.label AS financial_year_label,
                    (SELECT COUNT(*) FROM holidays h WHERE h.holiday_list_id = hl.id) AS holidays_count
                FROM {$this->table} hl
                LEFT JOIN financial_years fy ON fy.id = hl.financial_year_id
                ORDER BY hl.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function existsByNameAndFinancialYear(string $name, int $financialYearId): bool
    {
        $sql = "SELECT id FROM {$this->table}
                WHERE TRIM(name) = TRIM(:name)
                  AND financial_year_id = :financial_year_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => trim($name),
            ':financial_year_id' => $financialYearId,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public function find($id)
    {
        $sql = "SELECT id, name, is_default, is_active, created_at, updated_at
                FROM {$this->table}
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => (int) $id]);

        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row ?: null;
    }

    public function setActive(int $id, int $isActive): void
    {
        $sql = "UPDATE {$this->table} SET is_active = :is_active WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':is_active' => (int) $isActive,
            ':id' => $id,
        ]);
    }

    public function deleteWithChildren(int $id): void
    {
        try {
            $this->db->beginTransaction();

            $pivotTable = 'financial_year_holiday_lists';
            $pivotExists = $this->db->query(
                "SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '{$pivotTable}' LIMIT 1"
            )->fetchColumn();

            if ($pivotExists) {
                $pivotSql = "DELETE FROM {$pivotTable} WHERE holiday_list_id = :id";
                $pivotStmt = $this->db->prepare($pivotSql);
                $pivotStmt->execute([':id' => $id]);
            }

            $holidayListSql = "DELETE FROM {$this->table} WHERE id = :id";
            $holidayListStmt = $this->db->prepare($holidayListSql);
            $holidayListStmt->execute([':id' => $id]);

            $this->db->commit();
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    public function create(array $data): int
    {
        $name = trim((string) ($data['name'] ?? ''));
        $financialYearId = (int) ($data['financial_year_id'] ?? 0);
        $isDefault = array_key_exists('is_default', $data) ? (int) $data['is_default'] : 0;
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

        if ($this->existsByNameAndFinancialYear($name, $financialYearId)) {
            throw new \InvalidArgumentException('A holiday list with this name already exists for the selected financial year.');
        }

        $sql = "INSERT INTO {$this->table} (name, financial_year_id, is_default, is_active)
                VALUES (:name, :financial_year_id, :is_default, :is_active)";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            ':name' => $name,
            ':financial_year_id' => $financialYearId,
            ':is_default' => $isDefault,
            ':is_active' => $isActive,
        ]);

        if (!$ok) {
            throw new \RuntimeException('Unable to create holiday list.');
        }

        return (int) $this->db->lastInsertId();
    }
}

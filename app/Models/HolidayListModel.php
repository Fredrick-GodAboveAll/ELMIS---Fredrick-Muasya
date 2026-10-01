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

        public function existsByName(string $name): bool
    {
        $sql = "SELECT id FROM {$this->table}
                                WHERE TRIM(name) = TRIM(:name)
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => trim($name),
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public function find($id)
    {
        $sql = "SELECT id, name, is_active, created_at, updated_at
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

            $holidayDeleteSql = 'DELETE FROM holidays WHERE holiday_list_id = :id';
            $holidayDeleteStmt = $this->db->prepare($holidayDeleteSql);
            $holidayDeleteStmt->execute([':id' => $id]);

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
        $isActive = array_key_exists('is_active', $data) ? (int) $data['is_active'] : 1;

        if ($name === '') {
            throw new \InvalidArgumentException('Holiday list name is required.');
        }

        if (!in_array($isActive, [0, 1], true)) {
            throw new \InvalidArgumentException('Active / Inactive value is invalid.');
        }

        if ($this->existsByName($name)) {
            throw new \InvalidArgumentException('A holiday list with this name already exists.');
        }

        $sql = "INSERT INTO {$this->table} (name, is_active)
                VALUES (:name, :is_active)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':is_active' => $isActive,
        ]);

        return (int) $this->db->lastInsertId();
    }
}

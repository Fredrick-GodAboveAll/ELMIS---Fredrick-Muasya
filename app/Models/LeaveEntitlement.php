<?php
namespace App\Models;

use PDO;

class LeaveEntitlement extends Model
{
    protected $table = 'leave_entitlements';

    public function getFinancialYearConfigurationSummary(): array
    {
        $sql = "SELECT
                    fy.id,
                    fy.label,
                    fy.start_date,
                    fy.end_date,
                    fy.is_current,
                    COUNT(DISTINCT lt.id) AS active_leave_type_count,
                    COUNT(DISTINCT le.id) AS entitlement_rule_count
                FROM financial_years fy
                LEFT JOIN leave_types lt ON lt.is_active = 1
                LEFT JOIN leave_entitlements le ON le.financial_year_id = fy.id AND le.leave_type_id = lt.id
                GROUP BY fy.id, fy.label, fy.start_date, fy.end_date, fy.is_current
                ORDER BY fy.start_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFinancialYearSummary(): array
    {
        return $this->getFinancialYearConfigurationSummary();
    }

    public function findByYearLabel(string $yearLabel): array
    {
        $sql = "SELECT
                    fy.id AS financial_year_id,
                    fy.label AS financial_year_label,
                    fy.start_date,
                    fy.end_date,
                    fy.is_current,
                    lt.id AS leave_type_id,
                    lt.name AS leave_type_name,
                    lt.calculation_method,
                    le.id AS entitlement_id,
                    le.entitlement,
                    le.carry_forward,
                    le.carry_forward_limit,
                    le.pro_rata_allowed,
                    le.created_at,
                    le.updated_at
                FROM financial_years fy
                INNER JOIN leave_entitlements le ON le.financial_year_id = fy.id
                INNER JOIN leave_types lt ON lt.id = le.leave_type_id
                WHERE fy.label = :label
                ORDER BY lt.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['label' => $yearLabel]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function existsForYearType(int $financialYearId, int $leaveTypeId): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE financial_year_id = ? AND leave_type_id = ? LIMIT 1");
        $stmt->execute([$financialYearId, $leaveTypeId]);
        return (bool) $stmt->fetchColumn();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (financial_year_id, leave_type_id, entitlement, carry_forward, carry_forward_limit, created_at, updated_at) VALUES (:financial_year_id, :leave_type_id, :entitlement, :carry_forward, :carry_forward_limit, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

        $stmt = $this->db->prepare($sql);

        $ok = $stmt->execute([
            'financial_year_id' => $data['financial_year_id'],
            'leave_type_id' => $data['leave_type_id'],
            'entitlement' => $data['entitlement'],
            'carry_forward' => $data['carry_forward'],
            'carry_forward_limit' => $data['carry_forward_limit'],
        ]);

        if (!$ok) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }

    /**
     * Return active leave types that do not yet have an entitlement for the given financial year id
     */
    public function getEligibleLeaveTypesForYear(int $financialYearId): array
    {
        $sql = "SELECT lt.id, lt.name, lt.calculation_method FROM leave_types lt LEFT JOIN leave_entitlements le ON le.leave_type_id = lt.id AND le.financial_year_id = :fy_id WHERE lt.is_active = 1 AND le.id IS NULL ORDER BY lt.name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['fy_id' => $financialYearId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

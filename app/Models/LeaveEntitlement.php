<?php
namespace App\Models;

use PDO;

class LeaveEntitlement extends Model
{
    protected $table = 'leave_entitlements';

    public function getFinancialYearSummary(): array
    {
        $sql = "SELECT
                    fy.id,
                    fy.label,
                    fy.start_date,
                    fy.end_date,
                    fy.is_current,
                    COUNT(DISTINCT le.id) AS entitlement_rule_count,
                    COUNT(DISTINCT lt.id) AS active_leave_type_count
                FROM financial_years fy
                LEFT JOIN leave_entitlements le ON le.financial_year_id = fy.id
                LEFT JOIN leave_types lt ON lt.id = le.leave_type_id AND lt.is_active = 1
                GROUP BY fy.id, fy.label, fy.start_date, fy.end_date, fy.is_current
                ORDER BY fy.start_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
                LEFT JOIN leave_entitlements le ON le.financial_year_id = fy.id
                LEFT JOIN leave_types lt ON lt.id = le.leave_type_id
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
}

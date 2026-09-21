<?php
namespace App\Models;

use PDO;

class LeavePolicy extends Model
{
    protected $table = 'leave_policies';

    public function all(): array
    {
        $sql = "SELECT id, name, description, is_active, created_at, updated_at FROM {$this->table} ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare("SELECT id, name, description, is_active, created_at, updated_at FROM {$this->table} WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function existsByName(string $name): bool
    {
        $sql = "SELECT id FROM {$this->table} WHERE LOWER(name) = LOWER(?) LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);

        return (bool) $stmt->fetchColumn();
    }

    public function create(array $data): int|false
    {
        // If is_active is provided in $data, include it explicitly; otherwise rely on DB default.
        $name = trim((string) ($data['name'] ?? ''));
        $description = isset($data['description']) ? trim((string) $data['description']) : null;

        if (array_key_exists('is_active', $data)) {
            $sql = "INSERT INTO {$this->table} (name, description, is_active) VALUES (:name, :description, :is_active)";
            $stmt = $this->db->prepare($sql);
            $params = [
                'name' => $name,
                'description' => $description,
                'is_active' => (int) $data['is_active'],
            ];
        } else {
            $sql = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";
            $stmt = $this->db->prepare($sql);
            $params = [
                'name' => $name,
                'description' => $description,
            ];
        }

        $ok = $stmt->execute($params);

        if (!$ok) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }

    /**
     * Fetch policies with configured and total entitlement counts for a given financial year.
     * Returns an array of stdClass objects with properties: id,name,description,is_active,configured_count,total_entitlements
     */
    public function allWithEntitlementCounts(?int $financialYearId): array
    {
        if ($financialYearId === null || $financialYearId <= 0) {
            // Return basic list with zero counts when no current financial year
            $sql = "SELECT id, name, description, is_active, 0 AS configured_count, 0 AS total_entitlements FROM {$this->table} ORDER BY name ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        $sql = "SELECT lp.id, lp.name, lp.description, lp.is_active,
            (SELECT COUNT(*) FROM leave_policy_details lpd JOIN leave_entitlements le ON le.id = lpd.leave_entitlement_id WHERE lpd.leave_policy_id = lp.id AND le.financial_year_id = :fy) AS configured_count,
            (SELECT COUNT(*) FROM leave_entitlements WHERE financial_year_id = :fy) AS total_entitlements
            FROM {$this->table} lp
            ORDER BY lp.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['fy' => $financialYearId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function setActive(int $id, int $isActive): bool
    {
        $sql = "UPDATE {$this->table} SET is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return (bool) $stmt->execute(['is_active' => (int) $isActive, 'id' => $id]);
    }
}

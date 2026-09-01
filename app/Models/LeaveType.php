<?php
namespace App\Models;

use PDO;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? LIMIT 1");
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
        $sql = "INSERT INTO {$this->table}
                (name, annual_entitlement_value, calculation_method, carry_forward, carry_forward_limit, is_active)
                VALUES (:name, :annual_entitlement_value, :calculation_method, :carry_forward, :carry_forward_limit, :is_active)";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            'name' => $data['name'],
            'annual_entitlement_value' => $data['annual_entitlement_value'],
            'calculation_method' => $data['calculation_method'],
            'carry_forward' => $data['carry_forward'] ?? 0,
            'carry_forward_limit' => $data['carry_forward_limit'] ?? 0,
            'is_active' => $data['is_active'] ?? 1,
        ]);

        if (!$ok) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }
}

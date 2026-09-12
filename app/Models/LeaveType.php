<?php
namespace App\Models;

use PDO;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    public function all(): array
    {
        $sql = "SELECT id, name, calculation_method, is_active, created_at, updated_at FROM {$this->table} WHERE is_active = 1 ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare("SELECT id, name, calculation_method, is_active, created_at, updated_at FROM {$this->table} WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findActiveById(int $id)
    {
        $stmt = $this->db->prepare("SELECT id, name, calculation_method, is_active, created_at, updated_at FROM {$this->table} WHERE id = ? AND is_active = 1 LIMIT 1");
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
                (name, calculation_method, is_active)
                VALUES (:name, :calculation_method, :is_active)";

        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            'name' => trim((string) ($data['name'] ?? '')),
            'calculation_method' => trim((string) ($data['calculation_method'] ?? 'working_days')),
            'is_active' => (int) ($data['is_active'] ?? 1),
        ]);

        if (!$ok) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET name = :name, calculation_method = :calculation_method, is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => trim((string) ($data['name'] ?? '')),
            'calculation_method' => trim((string) ($data['calculation_method'] ?? 'working_days')),
            'is_active' => (int) ($data['is_active'] ?? 1),
        ]);
    }
}

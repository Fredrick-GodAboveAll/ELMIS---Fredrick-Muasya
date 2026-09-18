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
        $sql = "INSERT INTO {$this->table} (name, description, is_active) VALUES (:name, :description, :is_active)";
        $stmt = $this->db->prepare($sql);

        $ok = $stmt->execute([
            'name' => trim((string) ($data['name'] ?? '')),
            'description' => isset($data['description']) ? trim((string) $data['description']) : null,
            'is_active' => (int) ($data['is_active'] ?? 1),
        ]);

        if (!$ok) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }
}

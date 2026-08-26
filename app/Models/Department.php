<?php
namespace App\Models;

use PDO;

class Department extends Model
{
    protected $table = 'departments';

    public function all()
    {
        $sql = "SELECT
                    d.id,
                    d.name,
                    d.code,
                    d.head_of_department,
                    hod.full_name AS hod_name,
                    COUNT(emp.payroll_number) AS employee_count
                FROM {$this->table} d
                LEFT JOIN employees emp ON emp.department_id = d.id
                LEFT JOIN employees hod ON hod.payroll_number = d.head_of_department
                GROUP BY d.id, d.name, d.code, d.head_of_department, hod.full_name
                ORDER BY d.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function existsByNameCaseInsensitive(string $name): bool
    {
        $sql = "SELECT id FROM {$this->table} WHERE LOWER(name) = LOWER(?) LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return (bool) $stmt->fetchColumn();
    }

    public function codeExists(string $code): bool
    {
        $sql = "SELECT id FROM {$this->table} WHERE code = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$code]);
        return (bool) $stmt->fetchColumn();
    }

    public function generateCodeFromName(string $name): string
    {
        // Simple short code: first letter of name (uppercased) + random 3-digit number
        $first = strtoupper(mb_substr(trim($name), 0, 1));
        if ($first === '') {
            $first = 'D';
        }

        do {
            $rand = random_int(100, 999);
            $code = $first . $rand;
        } while ($this->codeExists($code));

        return $code;
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (name, code, head_of_department, created_at) VALUES (:name, :code, :head, CURRENT_TIMESTAMP)";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute([
            'name' => $data['name'],
            'code' => $data['code'],
            'head' => $data['head_of_department'] ?? null,
        ]);

        if ($res) {
            return (int) $this->db->lastInsertId();
        }

        return false;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return (bool) $stmt->execute([$id]);
    }
}

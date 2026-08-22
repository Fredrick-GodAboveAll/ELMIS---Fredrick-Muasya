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
}

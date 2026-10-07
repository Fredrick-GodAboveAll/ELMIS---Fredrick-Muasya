<?php
namespace App\Models;

use PDO;

class EmployeeCategoryModel extends Model
{
    protected $table = 'employees';

    public function allForCategories()
    {
        $sql = "SELECT
                    e.id,
                    e.payroll_number,
                    e.full_name,
                    e.gender,
                    e.job_group,
                    e.employment_status,
                    e.engagement_type,
                    e.special_need,
                    e.department_id,
                    d.name AS department_name
                FROM {$this->table} e
                LEFT JOIN departments d ON d.id = e.department_id
                WHERE e.employment_status NOT IN ('resigned', 'terminated')
                ORDER BY e.full_name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

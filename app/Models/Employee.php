<?php
namespace App\Models;

use PDO;

class Employee extends Model
{
    protected $table = 'employees';

    public function all()
    {
        $sql = "SELECT payroll_number, full_name, id_number, designation, job_group, employment_status, special_need
                FROM {$this->table}
                ORDER BY payroll_number ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

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

    public function insertEmployee(array $data): bool
    {
        $payrollNumber = (int) ($data['payroll_number'] ?? 0);

        if ($payrollNumber <= 0 || $this->findByPayrollNumber($payrollNumber)) {
            return false;
        }

        $sql = "INSERT INTO {$this->table} (
                    payroll_number, full_name, id_number, gender, age,
                    date_of_birth, designation, job_group, employment_status,
                    engagement_type, rod_date, special_need, department_id, created_at, updated_at
                ) VALUES (
                    :payroll_number, :full_name, :id_number, :gender, :age,
                    :date_of_birth, :designation, :job_group, :employment_status,
                    :engagement_type, :rod_date, :special_need, :department_id, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'payroll_number' => $payrollNumber,
            'full_name' => $data['full_name'],
            'id_number' => $data['id_number'],
            'gender' => $data['gender'],
            'age' => (int) $data['age'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'designation' => $data['designation'],
            'job_group' => $data['job_group'],
            'employment_status' => $data['employment_status'] ?? null,
            'engagement_type' => $data['engagement_type'] ?? null,
            'rod_date' => $data['rod_date'] ?? null,
            'special_need' => (int) ($data['special_need'] ?? 0),
            'department_id' => null,
        ]);
    }

    public function upsertEmployee(array $data): bool
    {
        return $this->insertEmployee($data);
    }

    public function findByPayrollNumber(int $payrollNumber)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE payroll_number = :payroll_number LIMIT 1");
        $stmt->execute(['payroll_number' => $payrollNumber]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

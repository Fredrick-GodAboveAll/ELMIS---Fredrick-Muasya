<?php
namespace App\Models;

use InvalidArgumentException;
use PDO;

class Employee extends Model
{
    protected $table = 'employees';

    public function all()
    {
        $sql = "SELECT
                    e.payroll_number,
                    e.full_name,
                    e.id_number,
                    e.designation,
                    jg.label AS job_group,
                    et.label AS employment_term,
                    CASE WHEN sn.code = 'pwd' THEN 4 ELSE 0 END AS special_need,
                    e.special_need_id,
                    e.department_id,
                    d.name AS department_name
                FROM {$this->table} e
                LEFT JOIN job_groups jg ON jg.id = e.job_group_id
                LEFT JOIN employment_terms et ON et.id = e.employment_term_id
                LEFT JOIN special_needs sn ON sn.id = e.special_need_id
                LEFT JOIN departments d ON d.id = e.department_id
                ORDER BY e.payroll_number ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Return all employees with their department name (if assigned).
     * department_name will be null when unassigned.
     */
    public function allWithDepartment()
    {
        $sql = "SELECT
                    e.payroll_number,
                    e.full_name,
                    e.id_number,
                    e.designation,
                    jg.label AS job_group,
                    et.label AS employment_term,
                    e.department_id,
                    d.name AS department_name
                FROM {$this->table} e
                    LEFT JOIN job_groups jg ON jg.id = e.job_group_id
                    LEFT JOIN employment_terms et ON et.id = e.employment_term_id
                    LEFT JOIN departments d ON d.id = e.department_id
                ORDER BY e.payroll_number ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertEmployee(array $data): bool
    {
        $payrollNumber = (string) ($data['payroll_number'] ?? '');

        if ($payrollNumber === '' || $this->findByPayrollNumber($payrollNumber)) {
            return false;
        }

        $genderId = $this->resolveLookupId('genders', $data['gender'] ?? $data['gender_id'] ?? null, 'code', 'label');
        $employmentTermId = $this->resolveLookupId('employment_terms', $data['employment_term'] ?? $data['employment_term_id'] ?? null, 'code', 'label');
        $employmentStatusId = $this->resolveLookupId('employment_statuses', $data['employment_status'] ?? $data['employment_status_id'] ?? null, 'code', 'label');
        $confirmationStatusId = $this->resolveLookupId('confirmation_statuses', $data['confirmation_status'] ?? $data['confirmation_status_id'] ?? null, 'code', 'label');
        $jobGroupId = $this->resolveLookupId('job_groups', $data['job_group'] ?? $data['job_group_id'] ?? null, 'code', 'label');
        $specialNeedId = $this->resolveLookupId('special_needs', $data['special_need'] ?? $data['special_need_id'] ?? null, 'code', 'label');
        $departmentId = (int) ($data['department_id'] ?? 0);

        $this->validateEmploymentTermStatusPair((int) $employmentTermId, (int) $employmentStatusId);

        $sql = "INSERT INTO {$this->table} (
                    payroll_number, full_name, id_number, date_of_birth,
                    designation, gender_id, employment_term_id, employment_status_id, confirmation_status_id,
                    job_group_id, special_need_id, department_id, rod_date,
                    created_at, updated_at
                ) VALUES (
                    :payroll_number, :full_name, :id_number, :date_of_birth,
                    :designation, :gender_id, :employment_term_id, :employment_status_id, :confirmation_status_id,
                    :job_group_id, :special_need_id, :department_id, :rod_date,
                    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'payroll_number' => $payrollNumber,
            'full_name' => $data['full_name'],
            'id_number' => $data['id_number'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'designation' => $data['designation'],
            'gender_id' => $genderId,
            'employment_term_id' => $employmentTermId,
            'employment_status_id' => $employmentStatusId,
            'confirmation_status_id' => $confirmationStatusId,
            'job_group_id' => $jobGroupId,
            'special_need_id' => $specialNeedId,
            'department_id' => $departmentId,
            'rod_date' => $data['rod_date'] ?? null,
        ]);
    }

    private function resolveLookupId(string $table, $value, string $codeField = 'code', string $labelField = 'label')
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        $value = trim((string) $value);

        $sql = "SELECT id FROM {$table} WHERE {$codeField} = :value OR {$labelField} = :value LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['value' => $value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int) $row['id'] : null;
    }

    public function updateEmployee(int $id, array $data): bool
    {
        $employee = $this->find($id);
        if (!$employee) {
            return false;
        }

        $genderId = $this->resolveLookupId('genders', $data['gender'] ?? $data['gender_id'] ?? $employee->gender_id ?? null, 'code', 'label');
        $employmentTermId = $this->resolveLookupId('employment_terms', $data['employment_term'] ?? $data['employment_term_id'] ?? $employee->employment_term_id ?? null, 'code', 'label');
        $employmentStatusId = $this->resolveLookupId('employment_statuses', $data['employment_status'] ?? $data['employment_status_id'] ?? $employee->employment_status_id ?? null, 'code', 'label');
        $confirmationStatusId = $this->resolveLookupId('confirmation_statuses', $data['confirmation_status'] ?? $data['confirmation_status_id'] ?? $employee->confirmation_status_id ?? null, 'code', 'label');
        $jobGroupId = $this->resolveLookupId('job_groups', $data['job_group'] ?? $data['job_group_id'] ?? $employee->job_group_id ?? null, 'code', 'label');
        $specialNeedId = $this->resolveLookupId('special_needs', $data['special_need'] ?? $data['special_need_id'] ?? $employee->special_need_id ?? null, 'code', 'label');
        $departmentId = (int) ($data['department_id'] ?? $employee->department_id ?? 0);

        $this->validateEmploymentTermStatusPair((int) $employmentTermId, (int) $employmentStatusId);

        $sql = "UPDATE {$this->table} SET
                    payroll_number = :payroll_number,
                    full_name = :full_name,
                    id_number = :id_number,
                    date_of_birth = :date_of_birth,
                    designation = :designation,
                    gender_id = :gender_id,
                    employment_term_id = :employment_term_id,
                    employment_status_id = :employment_status_id,
                    confirmation_status_id = :confirmation_status_id,
                    job_group_id = :job_group_id,
                    special_need_id = :special_need_id,
                    department_id = :department_id,
                    rod_date = :rod_date,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'payroll_number' => $data['payroll_number'] ?? $employee->payroll_number,
            'full_name' => $data['full_name'] ?? $employee->full_name,
            'id_number' => $data['id_number'] ?? $employee->id_number,
            'date_of_birth' => $data['date_of_birth'] ?? $employee->date_of_birth,
            'designation' => $data['designation'] ?? $employee->designation,
            'gender_id' => $genderId,
            'employment_term_id' => $employmentTermId,
            'employment_status_id' => $employmentStatusId,
            'confirmation_status_id' => $confirmationStatusId,
            'job_group_id' => $jobGroupId,
            'special_need_id' => $specialNeedId,
            'department_id' => $departmentId,
            'rod_date' => $data['rod_date'] ?? $employee->rod_date,
        ]);
    }

    // IMPORTANT: This rule is duplicated in config/database.sql (join table seed).
    // Update BOTH files when the validity rule changes.
    private function validateEmploymentTermStatusPair(int $employmentTermId, int $employmentStatusId): void
    {
        if ($employmentTermId <= 0 || $employmentStatusId <= 0) {
            return;
        }

        $validPairs = [
            'Permanent' => ['active', 'suspended', 'resigned', 'retired'],
            'Contract' => ['active', 'suspended', 'resigned', 'retired'],
            'Intern' => ['active', 'suspended', 'resigned', 'retired'],
            'Casual' => ['active', 'suspended', 'resigned', 'retired'],
        ];

        $termSql = 'SELECT code FROM employment_terms WHERE id = :id LIMIT 1';
        $termStmt = $this->db->prepare($termSql);
        $termStmt->execute(['id' => $employmentTermId]);
        $termCode = $termStmt->fetchColumn();

        $statusSql = 'SELECT code FROM employment_statuses WHERE id = :id LIMIT 1';
        $statusStmt = $this->db->prepare($statusSql);
        $statusStmt->execute(['id' => $employmentStatusId]);
        $statusCode = $statusStmt->fetchColumn();

        if ($termCode === false || $statusCode === false) {
            return;
        }

        $allowed = $validPairs[$termCode] ?? null;
        if ($allowed === null || !in_array((string) $statusCode, $allowed, true)) {
            $termLabel = (string) $termCode;
            $statusLabel = (string) $statusCode;
            throw new InvalidArgumentException(
                "Employment term '{$termLabel}' is not valid with status '{$statusLabel}'. Please choose a valid combination."
            );
        }
    }

    public function upsertEmployee(array $data): bool
    {
        return $this->insertEmployee($data);
    }

    public function findByPayrollNumber(string $payrollNumber)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE payroll_number = :payroll_number LIMIT 1");
        $stmt->execute(['payroll_number' => $payrollNumber]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

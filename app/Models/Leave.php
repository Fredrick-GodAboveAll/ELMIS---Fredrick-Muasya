<?php
namespace App\Models;

use PDO;

class Leave extends Model
{
    protected $table = 'financial_years';

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY start_date DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (label, start_date, end_date, is_current)
                VALUES (:label, :start_date, :end_date, :is_current)";

        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([
            'label' => $data['label'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'is_current' => $data['is_current'] ?? 0,
        ])) {
            return (int) $this->db->lastInsertId();
        }

        return false;
    }

    public function setCurrentPeriod($id)
    {
        $this->db->exec("UPDATE {$this->table} SET is_current = 0 WHERE is_current = 1");
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_current = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function setInactive($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_current = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function existsForRange($startDate, $endDate, $excludeId = null)
    {
        $sql = "SELECT id FROM {$this->table} WHERE start_date = ? AND end_date = ?";
        $params = [$startDate, $endDate];

        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public function existsByLabel($label, $excludeId = null)
    {
        $sql = "SELECT id FROM {$this->table} WHERE label = ?";
        $params = [$label];

        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getCurrentPeriod()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_current = 1 ORDER BY start_date DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function setCurrentPeriodByLatestStartDate()
    {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} ORDER BY start_date DESC LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$row) {
            $this->db->exec("UPDATE {$this->table} SET is_current = 0");
            return true;
        }

        $this->db->exec("UPDATE {$this->table} SET is_current = 0");
        $update = $this->db->prepare("UPDATE {$this->table} SET is_current = 1 WHERE id = ?");
        return $update->execute([$row->id]);
    }
}

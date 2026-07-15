<?php
namespace App\Models;
use App\Core\Database;
use PDO;
abstract class Model
{
 protected $db;
 protected $table;
 public function __construct()
 {
 $this->db = Database::getInstance();
 }
 public function find($id)
 {
 $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
 $stmt->execute([$id]);
 return $stmt->fetch(PDO::FETCH_OBJ);
 }
}
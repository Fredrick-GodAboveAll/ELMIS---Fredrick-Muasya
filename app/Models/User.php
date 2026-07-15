<?php
namespace App\Models;
use PDO;
class User extends Model
{
 protected $table = 'users';
 public function findByEmail($email)
 {
 $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
 $stmt->execute([$email]);
 return $stmt->fetch(PDO::FETCH_OBJ);
 }
 public function create($data)
 {
 $sql = "INSERT INTO {$this->table} (name, email, password, role)
 VALUES (:name, :email, :password, :role)";
 $stmt = $this->db->prepare($sql);
 return $stmt->execute([
 'name' => $data['name'],
 'email' => $data['email'],
 'password' => $data['password'],
 'role' => $data['role'] ?? 'user'
 ]);
 }
 public function deleteByEmail($email)
 {
     $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE email = ?");
     return $stmt->execute([$email]);
 }
 public function updateLastLogin($id)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET last_login = NOW(), session_started_at = NOW() WHERE id = ?"
 );
 return $stmt->execute([$id]);
 }
 public function updatePassword($email, $newPassword)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET password = ?, password_changed_at = NOW() WHERE email = ?"
 );
 return $stmt->execute([$newPassword, $email]);
 }
 
 // Increment failed login attempts
 public function incrementFailedAttempts($id)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET failed_login_attempts = failed_login_attempts + 1 WHERE id = ?"
 );
 return $stmt->execute([$id]);
 }
 
 // Reset failed login attempts to 0
 public function resetFailedAttempts($id)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET failed_login_attempts = 0 WHERE id = ?"
 );
 return $stmt->execute([$id]);
 }
 
 // Lock account until specified time
 public function lockAccount($id, $lockedUntil)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET locked_until = ? WHERE id = ?"
 );
 return $stmt->execute([$lockedUntil, $id]);
 }
 
 // Unlock account
 public function unlockAccount($id)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET locked_until = NULL, failed_login_attempts = 0 WHERE id = ?"
 );
 return $stmt->execute([$id]);
 }
 
 // Update password_changed_at timestamp
 public function updatePasswordChangedAt($id)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET password_changed_at = NOW() WHERE id = ?"
 );
 return $stmt->execute([$id]);
 }
 
 // Get database connection for direct queries
 public function getDb()
 {
 return $this->db;
 }
}
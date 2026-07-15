<?php
namespace App\Models;
use PDO;
class PasswordReset extends Model
{
 protected $table = 'password_resets';
 public function createToken($email, $token, $expires = null)
 {
 if ($expires === null) {
     $stmt = $this->db->prepare(
         "INSERT INTO {$this->table} (email, token, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))"
     );
     return $stmt->execute([$email, $token]);
 }

 $stmt = $this->db->prepare(
 "INSERT INTO {$this->table} (email, token, expires_at) VALUES (?, ?, ?)"
 );
 return $stmt->execute([$email, $token, $expires]);
 }
 public function findByToken($token)
 {
 $stmt = $this->db->prepare(
 "SELECT * FROM {$this->table} WHERE token = ? AND expires_at > NOW()"
 );
 $stmt->execute([$token]);
 return $stmt->fetch(PDO::FETCH_OBJ);
 }
 public function deleteByEmail($email)
 {
 $stmt = $this->db->prepare(
 "DELETE FROM {$this->table} WHERE email = ?"
 );
 return $stmt->execute([$email]);
 }
}
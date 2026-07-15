<?php
namespace App\Core;
class Session
{
 // Simple session helper used across the app for flash messages and login state.
 public static function start()
 {
 if (session_status() === PHP_SESSION_NONE) {
 session_start();
 }
 }
 public static function set($key, $value) { $_SESSION[$key] = $value; }
 public static function get($key, $default = null) { return $_SESSION[$key] ?? $default; }
 public static function has($key) { return isset($_SESSION[$key]); }
 public static function delete($key) { unset($_SESSION[$key]); }
 public static function destroy() { session_destroy(); }
 public static function flash($key, $value = null)
 {
 if ($value !== null) {
 $_SESSION['flash'][$key] = $value;
 } else {
 $val = $_SESSION['flash'][$key] ?? null;
 unset($_SESSION['flash'][$key]);
 return $val;
 }
 }
}

<?php
namespace App\Utils;
class Validator
{
 protected $errors = [];
 public function validate($data, $rules)
 {
 foreach ($rules as $field => $rule) {
 $value = $data[$field] ?? '';
 $rulesArray = explode('|', $rule);
 foreach ($rulesArray as $singleRule) {
 $this->applyRule($field, $value, $singleRule, $data);
 }
 }
 return empty($this->errors);
 }
 protected function applyRule($field, $value, $rule, $data)
 {
 if ($rule === 'required' && empty($value))
 $this->errors[$field][] = ucfirst($field) . ' is required';
 if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL))
 $this->errors[$field][] = ucfirst($field) . ' must be a valid email';
 if (strpos($rule, 'min:') === 0) {
 $min = explode(':', $rule)[1];
 if (strlen($value) < $min)
 $this->errors[$field][] = ucfirst($field) . " must be at least $min characters";
 }
 if ($rule === 'confirmed') {
 $confirmField = $field . '_confirm';
 if (!isset($data[$confirmField]) || $value !== $data[$confirmField])
 $this->errors[$field][] = ucfirst($field) . ' confirmation does not match';
 }
 }
 public function errors() { return $this->errors; }
}
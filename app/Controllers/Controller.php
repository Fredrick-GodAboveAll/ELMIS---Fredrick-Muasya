<?php
namespace App\Controllers;

class Controller
{
    protected function boolFromCheckbox(array $post, string $key): int
    {
        return isset($post[$key]) && $post[$key] == '1' ? 1 : 0;
    }
}

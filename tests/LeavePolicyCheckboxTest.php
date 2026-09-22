<?php

use App\Controllers\Controller;
use PHPUnit\Framework\TestCase;

class TestableController extends Controller
{
    public function callBoolFromCheckbox(array $post, string $key): int
    {
        return $this->boolFromCheckbox($post, $key);
    }
}

class LeavePolicyCheckboxTest extends TestCase
{
    public function testMissingIsActiveResolvesToZero(): void
    {
        $controller = new TestableController();

        $this->assertSame(0, $controller->callBoolFromCheckbox([], 'is_active'));
    }

    public function testSubmittedZeroResolvesToZero(): void
    {
        $controller = new TestableController();

        $this->assertSame(0, $controller->callBoolFromCheckbox(['is_active' => '0'], 'is_active'));
    }

    public function testSubmittedOneResolvesToOne(): void
    {
        $controller = new TestableController();

        $this->assertSame(1, $controller->callBoolFromCheckbox(['is_active' => '1'], 'is_active'));
    }
}

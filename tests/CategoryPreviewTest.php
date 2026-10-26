<?php

use App\Controllers\EmployeeController;
use PHPUnit\Framework\TestCase;

class CategoryPreviewTest extends TestCase
{
    public function testCategoryDefinitionsIncludeActualValuesForCards(): void
    {
        $controller = new EmployeeController();
        $method = new ReflectionMethod($controller, 'categoryDefinitions');
        $method->setAccessible(true);
        $definitions = $method->invoke($controller);

        $this->assertNotEmpty($definitions);
        $this->assertArrayHasKey('preview', $definitions[0]);
        $this->assertContains('Permanent', $definitions[0]['preview']);
        $this->assertContains('Contract', $definitions[0]['preview']);
        $this->assertContains('Casual', $definitions[0]['preview']);

        $employmentStatus = $definitions[1];
        $this->assertContains('Active', $employmentStatus['preview']);
        $this->assertContains('Retired', $employmentStatus['preview']);

        $confirmationStatus = $definitions[2];
        $this->assertContains('Probation', $confirmationStatus['preview']);
        $this->assertContains('Confirmed (P&P)', $confirmationStatus['preview']);
    }
}

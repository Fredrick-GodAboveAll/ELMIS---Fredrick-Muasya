<?php

namespace App\Services;

use App\Core\Database;
use App\Models\EmployeeCategoryModel;
use PDO;

class EmployeeCategoryService
{
    protected $db;
    protected $employeeCategoryModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->employeeCategoryModel = new EmployeeCategoryModel();
    }

    public function getPageData()
    {
        $categories = $this->loadCategories();
        $employees = $this->getEmployees();
        $members = $this->buildMembers($categories, $employees);

        foreach ($categories as $slug => &$category) {
            unset($category['field'], $category['map']);
        }
        unset($category);

        return [
            'categories' => $categories,
            'members'    => $members,
            'total'      => count($employees),
            'firstKey'   => array_key_first($categories) ?: null,
        ];
    }

    private function loadCategories()
    {
        $categorySql = "SELECT id, slug, title, icon, color, role, description, field, layout, sort_order
                        FROM employee_categories
                        WHERE is_active = 1
                        ORDER BY sort_order ASC";

        $valueSql = "SELECT category_id, label, employee_value, effect, sort_order
                     FROM employee_category_values
                     WHERE is_active = 1
                     ORDER BY category_id, sort_order ASC";

        $categoryRows = $this->db->query($categorySql)->fetchAll(PDO::FETCH_ASSOC);
        $valueRows = $this->db->query($valueSql)->fetchAll(PDO::FETCH_ASSOC);

        $valuesByCategory = [];
        foreach ($valueRows as $row) {
            $categoryId = (int) $row['category_id'];
            $valuesByCategory[$categoryId][] = $row;
        }

        $categories = [];
        foreach ($categoryRows as $row) {
            $slug = $row['slug'];
            $categoryId = (int) $row['id'];
            $values = [];
            $map = [];

            if (isset($valuesByCategory[$categoryId])) {
                foreach ($valuesByCategory[$categoryId] as $valueRow) {
                    $label = (string) $valueRow['label'];
                    $employeeValue = (string) $valueRow['employee_value'];
                    $effect = (string) ($valueRow['effect'] ?? '');

                    $values[$label] = $effect;
                    $map[$employeeValue] = $label;
                }
            }

            $categories[$slug] = [
                'id'          => $categoryId,
                'title'       => $row['title'],
                'icon'        => $row['icon'],
                'color'       => $row['color'],
                'role'        => $this->humanizeRole($row['role']),
                'description' => $row['description'],
                'field'       => $row['field'],
                'layout'      => $row['layout'],
                'values'      => $values,
                'map'         => $map,
            ];
        }

        return $categories;
    }

    private function getEmployees()
    {
        return $this->employeeCategoryModel->allForCategories();
    }

    private function buildMembers($categories, $employees)
    {
        $members = [];

        foreach ($categories as $slug => $category) {
            $members[$slug] = [];

            foreach ($category['map'] as $employeeValue => $label) {
                $members[$slug][$label] = [];
            }

            foreach ($employees as $employee) {
                $rawValue = $employee[$category['field']] ?? null;
                if ($rawValue === null) {
                    continue;
                }

                $lookup = (string) $rawValue;
                if (isset($category['map'][$lookup])) {
                    $label = $category['map'][$lookup];
                    if (isset($members[$slug][$label])) {
                        $members[$slug][$label][] = $employee;
                    }
                }
            }
        }

        return $members;
    }

    private function humanizeRole($role)
    {
        $roles = [
            'base'   => 'Base policy',
            'impact' => 'Impact only',
            'filter' => 'Filter only',
        ];

        return $roles[(string) $role] ?? ucfirst((string) $role);
    }
}

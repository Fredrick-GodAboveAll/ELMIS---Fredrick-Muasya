<?php
namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Session;
use App\Models\Employee;
use ZipArchive;

class BulkImportController extends Controller
{
    public function employeesTemplate()
    {
        $templatePath = __DIR__ . '/../../storage/templates/employees_import_template.xlsx';
        $directory = dirname($templatePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        if (!file_exists($templatePath)) {
            $this->writeEmployeeTemplate($templatePath);
        }

        $this->streamFile($templatePath, 'employees_import_template.xlsx');
    }

    public function importEmployees()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Session::flash('error', 'Invalid request method for employee import.');
            header('Location: /bulk-actions');
            exit;
        }

        try {
            Csrf::validate($_POST['csrf_token'] ?? '');
        } catch (\Exception $e) {
            Session::flash('error', 'Security validation failed. Please try again.');
            header('Location: /bulk-actions');
            exit;
        }

        if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
            Session::flash('error', 'Please upload a valid Excel file.');
            header('Location: /bulk-actions');
            exit;
        }

        $file = $_FILES['import_file'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, ['xlsx', 'csv'], true)) {
            Session::flash('error', 'Only .xlsx and .csv files are allowed for employee import.');
            header('Location: /bulk-actions');
            exit;
        }

        try {
            $rows = $this->readSpreadsheetRows($file['tmp_name'], $file['name']);
        } catch (\Throwable $e) {
            Session::flash('error', 'The uploaded file could not be read. Please check the file format and try again.');
            header('Location: /bulk-actions');
            exit;
        }

        if (count($rows) < 2) {
            Session::flash('error', 'The uploaded file does not contain any employee records.');
            header('Location: /bulk-actions');
            exit;
        }

        $headerMapping = $this->buildHeaderMapping($rows[0]);

        if (!isset($headerMapping['payroll_number']) && !isset($headerMapping['employee_no'])) {
            Session::flash('error', 'The uploaded file is missing the employee number column.');
            header('Location: /bulk-actions');
            exit;
        }

        $employeeModel = new Employee();
        $added = 0;
        $rejected = 0;
        $rejections = [];
        $total = max(0, count($rows) - 1);

        foreach (array_slice($rows, 1) as $idx => $row) {
            $rowNumber = $idx + 2; // account for header row being 1

            // attempt to read raw payroll value for reporting even if record invalid
            $payrollRaw = '';
            if (isset($headerMapping['payroll_number'])) {
                $col = $headerMapping['payroll_number'];
                $payrollRaw = $row[$col] ?? '';
            } elseif (isset($headerMapping['employee_no'])) {
                $col = $headerMapping['employee_no'];
                $payrollRaw = $row[$col] ?? '';
            }

            $record = $this->buildEmployeeRecord($row, $headerMapping);

            if ($record === null) {
                $rejected++;
                $rejections[] = ['row' => $rowNumber, 'payroll_number' => trim((string) $payrollRaw), 'reason' => 'Invalid or missing required fields'];
                continue;
            }

            if ($employeeModel->findByPayrollNumber((int) ($record['payroll_number'] ?? 0))) {
                $rejected++;
                $rejections[] = ['row' => $rowNumber, 'payroll_number' => $record['payroll_number'] ?? '', 'reason' => 'Duplicate payroll number'];
                continue;
            }

            if ($employeeModel->insertEmployee($record)) {
                $added++;
            } else {
                $rejected++;
                $rejections[] = ['row' => $rowNumber, 'payroll_number' => $record['payroll_number'] ?? '', 'reason' => 'Database insert failed'];
            }
        }

        $message = 'Employees import completed. ' . $added . ' record(s) added and ' . $rejected . ' record(s) rejected.';
        Session::flash('success', $message);

        // save a summary and the rejections for display in the UI offcanvas
        Session::set('last_import_summary', ['total' => $total, 'added' => $added, 'rejected' => $rejected]);
        Session::set('last_import_rejections', $rejections);
        header('Location: /bulk-actions');
        exit;
    }

    public function leaveTemplate()
    {
        Session::flash('info', 'Leave import is not wired yet.');
        header('Location: /bulk-actions');
        exit;
    }

    public function importLeave()
    {
        Session::flash('info', 'Leave import is not wired yet.');
        header('Location: /bulk-actions');
        exit;
    }

    public function allowancesTemplate()
    {
        Session::flash('info', 'Allowances import is not wired yet.');
        header('Location: /bulk-actions');
        exit;
    }

    public function importAllowances()
    {
        Session::flash('info', 'Allowances import is not wired yet.');
        header('Location: /bulk-actions');
        exit;
    }

    protected function writeEmployeeTemplate($path)
    {
        $headers = [
            'Payroll Number',
            'Full Name',
            'National ID',
            'Gender',
            'Age',
            'Date of Birth',
            'Designation',
            'Job Group',
            'Employment Status',
            'Engagement Type',
            'ROD Date',
            'Special Need',
        ];

        $sampleRows = [
            [
                '10737',
                'MR JULIUS ODHIAMBO MBOGAH',
                '19960091',
                'M',
                '63',
                '1963-04-15',
                'Deputy Director - HRM & Development',
                'R',
                'permanent',
                'Permanent',
                '2026-11-04',
                '0',
            ],
        ];

        $rows = [$headers, ...$sampleRows];
        $zip = new ZipArchive();

        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Could not create employee import template.');
        }

        $sheetXml = $this->buildSheetXml($rows);

        $zip->addFromString('[Content_Types].xml', $this->contentTypesXml());
        $zip->addFromString('_rels/.rels', $this->rootRelationsXml());
        $zip->addFromString('docProps/core.xml', $this->coreXml());
        $zip->addFromString('docProps/app.xml', $this->appXml());
        $zip->addFromString('xl/workbook.xml', $this->workbookXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelationsXml());
        $zip->addFromString('xl/styles.xml', $this->stylesXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

        $zip->close();
    }

    protected function buildSheetXml(array $rows): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $xml .= '<sheetData>';

        foreach ($rows as $rowIndex => $row) {
            $xml .= '<row r="' . ($rowIndex + 1) . '">';

            foreach ($row as $colIndex => $value) {
                $column = $this->columnLetter($colIndex);
                $cellRef = $column . ($rowIndex + 1);
                $safeValue = htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
                $xml .= '<c r="' . $cellRef . '" t="inlineStr"><is><t>' . $safeValue . '</t></is></c>';
            }

            $xml .= '</row>';
        }

        $xml .= '</sheetData>';
        $xml .= '</worksheet>';

        return $xml;
    }

    protected function columnLetter(int $index): string
    {
        $letter = '';
        $value = $index + 1;

        while ($value > 0) {
            $value--;
            $letter = chr(65 + ($value % 26)) . $letter;
            $value = intdiv($value, 26);
        }

        return $letter;
    }

    protected function contentTypesXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
  <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
  <Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>
</Types>
XML;
    }

    protected function rootRelationsXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
  <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>
</Relationships>
XML;
    }

    protected function coreXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <dc:creator>ELMIS</dc:creator>
  <cp:lastModifiedBy>ELMIS</cp:lastModifiedBy>
  <dcterms:created xsi:type="dcterms:W3CDTF">2026-08-23T00:00:00Z</dcterms:created>
  <dcterms:modified xsi:type="dcterms:W3CDTF">2026-08-23T00:00:00Z</dcterms:modified>
</cp:coreProperties>
XML;
    }

    protected function appXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
  <Application>ELMIS</Application>
</Properties>
XML;
    }

    protected function workbookXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets>
    <sheet name="Employees" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>
XML;
    }

    protected function workbookRelationsXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>
XML;
    }

    protected function stylesXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="1"><font><sz val="11"/><name val="Calibri"/></font></fonts>
  <fills count="1"><fill><patternFill patternType="none"/></fill></fills>
  <borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>
  <cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>
  <cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/></cellXfs>
  <cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>
</styleSheet>
XML;
    }

    protected function streamFile(string $path, string $downloadName): void
    {
        if (!file_exists($path)) {
            Session::flash('error', 'The template file could not be found.');
            header('Location: /bulk-actions');
            exit;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $downloadName . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    protected function readSpreadsheetRows(string $path, string $fileName): array
    {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($extension === 'csv') {
            $handle = fopen($path, 'r');
            if ($handle === false) {
                throw new \RuntimeException('CSV file could not be opened.');
            }

            $rows = [];
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = array_map(function ($value) {
                    return trim((string) $value);
                }, $data);
            }

            fclose($handle);

            return $this->convertArrayRowsToHeaderAssociative($rows);
        }

        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException('Excel file could not be opened.');
        }

        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXml !== false) {
            $sharedStringsXmlObject = simplexml_load_string($sharedStringsXml);
            if ($sharedStringsXmlObject !== false && isset($sharedStringsXmlObject->si)) {
                foreach ($sharedStringsXmlObject->si as $stringItem) {
                    $textParts = [];
                    foreach ($stringItem->t as $textNode) {
                        $textParts[] = (string) $textNode;
                    }
                    $sharedStrings[] = implode('', $textParts);
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if ($sheetXml === false) {
            $zip->close();
            throw new \RuntimeException('No worksheet found in the Excel file.');
        }

        $sheet = simplexml_load_string($sheetXml);
        $rows = [];

        foreach ($sheet->sheetData->row as $rowNode) {
            $cellsByColumn = [];

            foreach ($rowNode->c as $cellNode) {
                $cellReference = (string) $cellNode['r'];
                $column = preg_replace('/\d+/', '', $cellReference);
                $columnIndex = $this->columnIndex($column);
                $cellType = isset($cellNode['t']) ? (string) $cellNode['t'] : 'n';
                $value = '';

                if ($cellType === 'inlineStr' && isset($cellNode->is->t)) {
                    $value = (string) $cellNode->is->t;
                } elseif ($cellType === 's') {
                    $index = (int) ((string) $cellNode->v);
                    $value = $sharedStrings[$index] ?? '';
                } elseif ($cellType === 'b') {
                    $value = (string) $cellNode->v;
                } else {
                    $value = (string) $cellNode->v;
                }

                $cellsByColumn[$columnIndex] = trim((string) $value);
            }

            ksort($cellsByColumn);
            $rows[] = array_values($cellsByColumn);
        }

        $zip->close();

        return $this->convertArrayRowsToHeaderAssociative($rows);
    }

    protected function convertArrayRowsToHeaderAssociative(array $rows): array
    {
        if (empty($rows)) {
            return [];
        }

        $normalizedRows = [];
        foreach ($rows as $row) {
            $normalizedRow = [];
            foreach ($row as $cell) {
                $normalizedRow[] = trim((string) $cell);
            }
            $normalizedRows[] = $normalizedRow;
        }

        if (empty($normalizedRows[0])) {
            return [];
        }

        $header = array_map(function ($cell) {
            return $this->normalizeHeaderName((string) $cell);
        }, $normalizedRows[0]);

        $mappedRows = [$header];
        foreach (array_slice($normalizedRows, 1) as $row) {
            $record = [];
            foreach ($header as $index => $headerName) {
                $record[$headerName] = $row[$index] ?? '';
            }
            $mappedRows[] = $record;
        }

        return $mappedRows;
    }

    protected function buildHeaderMapping(array $headerRow): array
    {
        $mapping = [];

        foreach ($headerRow as $index => $headerValue) {
            $normalized = $this->normalizeHeaderName((string) $headerValue);
            if ($normalized !== '') {
                $mapping[$normalized] = $index;
            }
        }

        return $mapping;
    }

    protected function buildEmployeeRecord(array $row, array $headerMapping): ?array
    {
        $fullName = $this->valueFromAliases($row, $headerMapping, ['full_name', 'employee_name', 'name', 'employee']);
        $payrollNumber = $this->valueFromAliases($row, $headerMapping, ['payroll_number', 'employee_no', 'employee_number', 'payroll_no', 'payroll']);
        $idNumber = $this->valueFromAliases($row, $headerMapping, ['id_number', 'national_id', 'national_id_no', 'national_id_number', 'id_no']);
        $gender = $this->valueFromAliases($row, $headerMapping, ['gender']);
        $age = $this->valueFromAliases($row, $headerMapping, ['age']);
        $dateOfBirth = $this->valueFromAliases($row, $headerMapping, ['date_of_birth', 'dob', 'birth_date']);
        $designation = $this->valueFromAliases($row, $headerMapping, ['designation', 'job_title', 'title']);
        $jobGroup = $this->valueFromAliases($row, $headerMapping, ['job_group', 'jobgroup']);
        $employmentStatus = $this->valueFromAliases($row, $headerMapping, ['employment_status', 'status']);
        $engagementType = $this->valueFromAliases($row, $headerMapping, ['engagement_type', 'employee_type']);
        $rodDate = $this->valueFromAliases($row, $headerMapping, ['rod_date', 'retirement_date', 'rod']);
        $specialNeed = $this->valueFromAliases($row, $headerMapping, ['special_need', 'disability', 'special_need_flag']);

        $normalizedPayroll = (int) preg_replace('/[^0-9]/', '', $payrollNumber);
        $normalizedGender = $this->normalizeGender($gender);
        $normalizedAge = $this->normalizeAge($age);
        $normalizedBirthDate = $this->normalizeDate($dateOfBirth);
        $normalizedRodDate = $this->normalizeDate($rodDate);

        if ($payrollNumber === '' || $normalizedPayroll <= 0) {
            return null;
        }

        if ($fullName === '' || $idNumber === '' || $designation === '' || $jobGroup === '' || $employmentStatus === '' || $engagementType === '') {
            return null;
        }

        if ($normalizedGender === null || $normalizedAge <= 0 || $normalizedBirthDate === null || $normalizedRodDate === null) {
            return null;
        }

        return [
            'payroll_number' => $normalizedPayroll,
            'full_name' => trim($fullName),
            'id_number' => trim($idNumber),
            'gender' => $normalizedGender,
            'age' => $normalizedAge,
            'date_of_birth' => $normalizedBirthDate,
            'designation' => trim($designation),
            'job_group' => strtoupper(trim($jobGroup)),
            'employment_status' => trim($employmentStatus),
            'engagement_type' => trim($engagementType),
            'rod_date' => $normalizedRodDate,
            'special_need' => $this->normalizeSpecialNeed($specialNeed),
            'department_id' => null,
        ];
    }

    protected function valueFromAliases(array $row, array $headerMapping, array $aliases): string
    {
        foreach ($aliases as $alias) {
            if (isset($headerMapping[$alias])) {
                $value = $row[$alias] ?? '';
                return trim((string) $value);
            }
        }

        return '';
    }

    protected function normalizeHeaderName(string $header): string
    {
        $header = strtolower(trim($header));
        $header = preg_replace('/[^a-z0-9]+/', '_', $header);
        $header = trim((string) $header, '_');

        $replacements = [
            'employee_no' => 'employee_no',
            'employee_number' => 'employee_no',
            'payroll_no' => 'payroll_number',
            'national_id_no' => 'id_number',
            'national_id' => 'id_number',
            'full_name' => 'full_name',
            'employee_name' => 'full_name',
            'date_of_birth' => 'date_of_birth',
            'employment_status' => 'employment_status',
            'engagement_type' => 'engagement_type',
            'rod_date' => 'rod_date',
            'special_need' => 'special_need',
            'department' => 'department_id',
        ];

        foreach ($replacements as $key => $value) {
            if ($header === $key) {
                return $value;
            }
        }

        return $header;
    }

    protected function normalizeGender(string $value): ?string
    {
        $value = strtoupper(trim($value));

        if ($value === '' || $value === '0') {
            return null;
        }

        if (in_array($value, ['M', 'MALE'], true)) {
            return 'M';
        }

        if (in_array($value, ['F', 'FEMALE'], true)) {
            return 'F';
        }

        return null;
    }

    protected function normalizeAge(string $value): int
    {
        $value = preg_replace('/[^0-9]/', '', $value);
        return (int) ($value !== '' ? $value : 0);
    }

    protected function normalizeDate(string $value): ?string
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'];
        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            if ($date !== false) {
                return $date->format('Y-m-d');
            }
        }

        try {
            $date = new \DateTime($value);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function normalizeSpecialNeed(string $value): int
    {
        $value = trim((string) $value);

        if ($value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        $lower = strtolower($value);

        if (str_contains($lower, 'yes') || str_contains($lower, 'disabled') || str_contains($lower, 'disability')) {
            return 4;
        }

        return 0;
    }

    protected function columnIndex(string $column): int
    {
        $index = 0;
        $letters = str_split(strtoupper($column));

        foreach ($letters as $letter) {
            $index = ($index * 26) + (ord($letter) - 64);
        }

        return $index - 1;
    }
}

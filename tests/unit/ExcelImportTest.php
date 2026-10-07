<?php

use CodeIgniter\Test\CIUnitTestCase;

final class ExcelImportTest extends CIUnitTestCase
{
    public function testDashboardParseExcelRowsHandlesXlsxDefaultNamespace(): void
    {
        $dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'lablinesys_excel_test';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $path = $dir . DIRECTORY_SEPARATOR . 'namespace_test.xlsx';

        if (file_exists($path)) {
            unlink($path);
        }

        $zip = new ZipArchive();
        $openResult = $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->assertTrue($openResult === true, 'Unable to create the temporary XLSX fixture.');

        $sharedStringsXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="4" uniqueCount="4">
  <si><t>Clinic</t></si>
  <si><t>Province</t></si>
  <si><t>Alpha Clinic</t></si>
  <si><t>Metro</t></si>
</sst>
XML;

        $workbookXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
          xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets>
    <sheet name="Sheet1" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>
XML;

        $relsXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
</Relationships>
XML;

        $sheetXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <sheetData>
    <row r="1">
      <c r="A1" t="s"><v>0</v></c>
      <c r="B1" t="s"><v>1</v></c>
    </row>
    <row r="2">
      <c r="A2" t="s"><v>2</v></c>
      <c r="B2" t="s"><v>3</v></c>
    </row>
  </sheetData>
</worksheet>
XML;

        $zip->addFromString('xl/sharedStrings.xml', $sharedStringsXml);
        $zip->addFromString('xl/workbook.xml', $workbookXml);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $relsXml);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

        $zip->close();

        $controller = new \App\Controllers\Dashboard();
        $method = new \ReflectionMethod($controller, 'parseExcelRows');
        $method->setAccessible(true);

        $rows = $method->invoke($controller, $path);

        $this->assertCount(1, $rows);
        $this->assertSame('Alpha Clinic', $rows[0]['A']['value']);
        $this->assertSame('Metro', $rows[0]['B']['value']);

        unlink($path);
    }

    public function testMfsImportExtensionDetectionAcceptsCaseInsensitiveAndMimeBasedFiles(): void
    {
        $controller = new \App\Controllers\Mfs();
        $method = new \ReflectionMethod($controller, 'detectImportExtension');
        $method->setAccessible(true);

        $this->assertSame('xlsx', $method->invoke($controller, 'REPORT.XLSX', 'application/octet-stream'));
        $this->assertSame('csv', $method->invoke($controller, 'REPORT.CSV', 'application/octet-stream'));
        $this->assertSame('xlsx', $method->invoke($controller, 'report', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'));
        $this->assertSame('csv', $method->invoke($controller, 'report', 'text/csv'));
        $this->assertNull($method->invoke($controller, 'report.xls', 'application/vnd.ms-excel'));
    }

    public function testFsrImportParsesInlineStringXlsxTemplate(): void
    {
        $dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'lablinesys_fsr_inline_test';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $path = $dir . DIRECTORY_SEPARATOR . 'inline_template.xlsx';
        if (file_exists($path)) {
            unlink($path);
        }

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true, 'Unable to create the temporary FSR XLSX fixture.');

        $sheetXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <sheetData>
    <row r="1">
      <c r="A1" t="inlineStr"><is><t>FSR Number</t></is></c>
      <c r="B1" t="inlineStr"><is><t>Service Engineer</t></is></c>
      <c r="C1" t="inlineStr"><is><t>Account</t></is></c>
    </row>
    <row r="2">
      <c r="A2" t="inlineStr"><is><t>000001</t></is></c>
      <c r="B2" t="inlineStr"><is><t>John Smith</t></is></c>
      <c r="C2" t="inlineStr"><is><t>Alpha Clinic</t></is></c>
    </row>
  </sheetData>
</worksheet>
XML;

        $zip->addFromString('xl/workbook.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets><sheet name="Sheet1" sheetId="1" r:id="rId1"/></sheets>
</workbook>
XML);
        $zip->addFromString('xl/_rels/workbook.xml.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
</Relationships>
XML);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);
        $zip->addFromString('[Content_Types].xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
</Types>
XML);
        $zip->addFromString('_rels/.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>
XML);
        $zip->close();

        $controller = new \App\Controllers\Fsr();
        $method = new \ReflectionMethod($controller, 'parseExcelRows');
        $method->setAccessible(true);

        $rows = $method->invoke($controller, $path);

        $this->assertCount(1, $rows);
        $this->assertSame('000001', $rows[0]['A']['value']);
        $this->assertSame('John Smith', $rows[0]['B']['value']);
        $this->assertSame('Alpha Clinic', $rows[0]['C']['value']);

        unlink($path);
    }

    public function testPmsImportTreatsSamePmsNumberOnDifferentMachinesAsUnique(): void
    {
        $controller = new \App\Controllers\Pms();
        $method = new \ReflectionMethod($controller, 'isDuplicatePmsImportRow');
        $method->setAccessible(true);

        $firstRow = [
            'pms_number' => '000123',
            'service_tech' => 'John Smith',
            'clinic' => 'Alpha Clinic',
            'address' => '123 Main St',
            'date' => '2026-10-07',
            'machine' => 'X-Ray',
            'sn' => 'XR-001',
            'status' => 'Preventive Maintenance',
        ];

        $secondRow = [
            'pms_number' => '000123',
            'service_tech' => 'John Smith',
            'clinic' => 'Alpha Clinic',
            'address' => '123 Main St',
            'date' => '2026-10-07',
            'machine' => 'Ultrasound',
            'sn' => 'US-010',
            'status' => 'Cleaning and Inspection',
        ];

        $this->assertFalse($method->invoke($controller, $firstRow, $secondRow));
        $this->assertTrue($method->invoke($controller, $firstRow, $firstRow));
    }
}

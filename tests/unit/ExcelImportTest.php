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
}

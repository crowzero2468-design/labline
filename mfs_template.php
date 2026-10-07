<?php
$shared = [
    'MFS Number',
    'Employee',
    'Account',
    'Address',
    'Date Fill-up',
    'Unit',
    'Machine',
    'Serial Number',
    'Consumable Unit',
    'Consumables',
    'Lot Number',
    'Remarks',
    'Reason',
    'Date Status',
    'Personnel',
    'Acknowledged',
    'Returned',
];

$rows = [
    ['000001','John Smith','Alpha Clinic','123 Main St','2026-10-01','Unit A','X-Ray','XR-001','Consumable Unit A','Filter','LOT-001','Sample remarks','Routine service','2026-10-02','Support Team','Yes','0'],
    ['000002','Jane Doe','Beta Clinic','456 Pine Rd','2026-10-03','Unit B','Ultrasound','US-010','Consumable Unit B','Gel','LOT-002','Second sample','Inspection','2026-10-04','Support Team','No','1'],
];

$sheetRows = [$shared] + $rows;
$sheet = '<?xml version="1.0" encoding="UTF-8"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetData>';

foreach ($sheetRows as $rIndex => $row) {
    $sheet .= '<row r="' . ($rIndex + 1) . '">';

    foreach ($row as $cIndex => $value) {
        $cellCol = $cIndex;
        $col = '';
        while ($cellCol >= 0) {
            $col = chr(65 + ($cellCol % 26)) . $col;
            $cellCol = intdiv($cellCol, 26) - 1;
        }

        $cellRef = $col . ($rIndex + 1);
        $stringIndex = array_search((string) $value, $shared, true);
        if ($stringIndex === false) {
            $shared[] = (string) $value;
            $stringIndex = count($shared) - 1;
        }

        $sheet .= '<c r="' . $cellRef . '" t="s"><v>' . $stringIndex . '</v></c>';
    }

    $sheet .= '</row>';
}

$sheet .= '</sheetData></worksheet>';

$zip = new ZipArchive();
$path = 'F:\xampp\htdocs\lablinesys\public\templates\mfs_import_template.xlsx';

if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    exit('Failed to create zip\n');
}

$zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/><Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/><Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/><Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/></Types>');
$zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/></Relationships>');
$zip->addFromString('docProps/app.xml', '<?xml version="1.0" encoding="UTF-8"?><Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes"><Application>Microsoft Excel</Application></Properties>');
$zip->addFromString('docProps/core.xml', '<?xml version="1.0" encoding="UTF-8"?><cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><dc:creator>LablineSys</dc:creator><cp:lastModifiedBy>LablineSys</cp:lastModifiedBy></cp:coreProperties>');
$zip->addFromString('xl/styles.xml', '<?xml version="1.0" encoding="UTF-8"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="1"><font><sz val="11"/><name val="Calibri"/></font></fonts><fills count="1"><fill><patternFill patternType="none"/></fill></fills><borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>');
$zip->addFromString('xl/sharedStrings.xml', '<?xml version="1.0" encoding="UTF-8"?><sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . count($shared) . '" uniqueCount="' . count($shared) . '">' . implode('', array_map(function ($value) { return '<si><t>' . htmlspecialchars($value, ENT_XML1, 'UTF-8') . '</t></si>'; }, $shared)) . '</sst>');
$zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Sheet1" sheetId="1" r:id="rId1"/></sheets></workbook>');
$zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/></Relationships>');
$zip->addFromString('xl/worksheets/sheet1.xml', $sheet);
$zip->close();
echo 'created';
?>

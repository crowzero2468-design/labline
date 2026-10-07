<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Fsr extends BaseController
{
    public function index(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        $fsrRecords = [];
        $engineerList = [];
        $users = [];
        $accounts = [];

        $selectedEngineer = trim(
            (string) ($this->request->getGet('engineer') ?? '')
        );

        /*
         * ==========================================
         * GET SERVICE ENGINEERS FROM TB_USER
         * ==========================================
         */
        if ($database->tableExists('tb_user')) {
            $users = $database->table('tb_user')
                ->select('id,fname,lname,uname')
                ->orderBy('fname', 'ASC')
                ->get()
                ->getResultArray();
        }

        /*
         * ==========================================
         * GET ACCOUNT / MACHINE / SERIAL FROM TB_DATA
         * ==========================================
         */
        if ($database->tableExists('tb_data')) {
            $accounts = $database->table('tb_data')
                ->select('id,Clinic_name,Address,Machine,SN')
                ->where('status', 'A')
                ->orderBy('Clinic_name', 'ASC')
                ->get()
                ->getResultArray();
        }

        /*
         * ==========================================
         * GET FSR RECORDS
         * ==========================================
         */
        if ($database->tableExists('tb_fsr')) {

            /*
             * Service Engineer list
             */
            $engineerList = $database->query("
                SELECT
                    service_engineer,
                    COUNT(*) AS total
                FROM tb_fsr
                WHERE service_engineer IS NOT NULL
                  AND service_engineer != ''
                GROUP BY service_engineer
                ORDER BY service_engineer ASC
            ")->getResultArray();

            /*
             * Main FSR query
             */
            $sql = "
                SELECT
                    id,
                    fsr_number,
                    service_engineer,
                    account,
                    address,
                    date,
                    machine,
                    serial_number,
                    technical_concern,
                    remarks,
                    action_made,
                    acknowledge,
                    created_at,
                    updated_at
                FROM tb_fsr
            ";

            $params = [];

            if ($selectedEngineer !== '') {
                $sql .= " WHERE service_engineer = ?";
                $params[] = $selectedEngineer;
            }

            $sql .= " ORDER BY date DESC, id DESC";

            $fsrRecords = $database
                ->query($sql, $params)
                ->getResultArray();
        }

        /*
         * ==========================================
         * GENERATE NEXT FSR NUMBER
         * ==========================================
         */
        $nextFsrNumber = '000001';

        if ($database->tableExists('tb_fsr')) {

            $row = $database
                ->query("SELECT MAX(id) AS maxid FROM tb_fsr")
                ->getRow();

            $maxid = (int) ($row->maxid ?? 0);

            $nextFsrNumber = str_pad(
                (string) ($maxid + 1),
                6,
                '0',
                STR_PAD_LEFT
            );
        }

        /*
         * ==========================================
         * SEND DATA TO VIEW
         * ==========================================
         */
        return view('dashboard/fsr', [
            'user'              => session()->get('user'),
            'users'             => $users,
            'accounts'          => $accounts,
            'fsr_records'       => $fsrRecords,
            'engineer_list'     => $engineerList,
            'selected_engineer' => $selectedEngineer,
            'next_fsr_number'   => $nextFsrNumber,
        ]);
    }


    /*
     * ==========================================
     * SAVE FSR
     * ==========================================
     */
    public function save(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        if (!$database->tableExists('tb_fsr')) {
            return redirect()->back()
                ->with('error', 'tb_fsr table does not exist.');
        }

        /*
         * ==========================================
         * GET FORM VALUES
         * ==========================================
         */
        $fsrNumber = trim(
            (string) $this->request->getPost('fsr_number')
        );

        /*
         * Service Engineer ID
         *
         * The FSR view should use:
         * name="service_eng_id"
         */
        $serviceEngId = trim(
            (string) $this->request->getPost('service_eng_id')
        );

        /*
         * Also support old text input:
         * name="service_engineer"
         */
        $serviceEngineer = trim(
            (string) $this->request->getPost('service_engineer')
        );

        $account = trim(
            (string) $this->request->getPost('account')
        );

        $address = trim(
            (string) $this->request->getPost('address')
        );

        $date = trim(
            (string) $this->request->getPost('date')
        );

        $machine = trim(
            (string) $this->request->getPost('machine')
        );

        $serialNumber = trim(
            (string) $this->request->getPost('serial_number')
        );

        $technicalConcern = trim(
            (string) $this->request->getPost('technical_concern')
        );

        $remarks = trim(
            (string) $this->request->getPost('remarks')
        );

        $actionMade = trim(
            (string) $this->request->getPost('action_made')
        );

        $acknowledge = trim(
            (string) $this->request->getPost('acknowledge')
        );


        /*
         * ==========================================
         * GET SERVICE ENGINEER NAME FROM TB_USER
         * ==========================================
         */
        if ($serviceEngId !== '' && $database->tableExists('tb_user')) {

            $user = $database->table('tb_user')
                ->select('fname,lname,uname')
                ->where('id', $serviceEngId)
                ->get()
                ->getRowArray();

            if ($user) {

                $serviceEngineer = trim(
                    ($user['fname'] ?? '') . ' ' .
                    ($user['lname'] ?? '')
                );

                /*
                 * Fallback to username
                 */
                if ($serviceEngineer === '') {
                    $serviceEngineer = trim(
                        (string) ($user['uname'] ?? '')
                    );
                }
            }
        }


        /*
         * ==========================================
         * REQUIRED FIELDS
         * ==========================================
         */
        if (
            $serviceEngineer === '' ||
            $account === '' ||
            $machine === ''
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Please fill in Service Engineer, Account and Machine.'
                );
        }


        /*
         * ==========================================
         * MAP ACCOUNT + MACHINE + SERIAL
         * FROM TB_DATA
         * ==========================================
         */
        if ($database->tableExists('tb_data')) {

            $machineData = $database->table('tb_data')
                ->select(
                    'Clinic_name,Address,Machine,SN'
                )
                ->where(
                    'Clinic_name',
                    $account
                )
                ->where(
                    'Machine',
                    $machine
                )
                ->limit(1)
                ->get()
                ->getRowArray();

            /*
             * Account + Machine does not exist
             */
            if (!$machineData) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'The selected Account and Machine were not found in tb_data.'
                    );
            }

            /*
             * Use official values from TB_DATA
             */
            $account = trim(
                (string) (
                    $machineData['Clinic_name']
                    ?? $account
                )
            );

            $address = trim(
                (string) (
                    $machineData['Address']
                    ?? $address
                )
            );

            $machine = trim(
                (string) (
                    $machineData['Machine']
                    ?? $machine
                )
            );

            $serialNumber = trim(
                (string) (
                    $machineData['SN']
                    ?? ''
                )
            );
        }


        /*
         * ==========================================
         * GENERATE FSR NUMBER
         * ==========================================
         */
        if ($fsrNumber === '') {

            $row = $database
                ->query(
                    "SELECT MAX(id) AS maxid FROM tb_fsr"
                )
                ->getRow();

            $maxid = (int) ($row->maxid ?? 0);

            $fsrNumber = str_pad(
                (string) ($maxid + 1),
                6,
                '0',
                STR_PAD_LEFT
            );

        } elseif (preg_match('/^\d+$/', $fsrNumber)) {

            $fsrNumber = str_pad(
                $fsrNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
        }


        /*
         * ==========================================
         * INSERT FSR
         * ==========================================
         */
        $insert = [

            'fsr_number' =>
                $fsrNumber,

            'service_engineer' =>
                $serviceEngineer,

            'account' =>
                $account,

            'address' =>
                $address,

            'date' =>
                $date === ''
                    ? null
                    : $date,

            'machine' =>
                $machine,

            'serial_number' =>
                $serialNumber,

            'technical_concern' =>
                $technicalConcern,

            'remarks' =>
                $remarks,

            'action_made' =>
                $actionMade,

            'acknowledge' =>
                $acknowledge,
        ];


        /*
         * ==========================================
         * SAVE
         * ==========================================
         */
        $result = $database
            ->table('tb_fsr')
            ->insert($insert);


        if (!$result) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to save FSR record.'
                );
        }


        return redirect()
            ->to(site_url('fsr'))
            ->with(
                'success',
                'FSR record added successfully.'
            );
    }

    public function importExcel(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))->with('error', 'Please login first.');
        }

        $file = $this->request->getFile('excel_file');

        if ($file === null || !$file->isValid()) {
            return redirect()->to(site_url('fsr'))->with('error', 'Please choose an Excel file to import.');
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            return redirect()->to(site_url('fsr'))->with('error', 'Excel upload failed. Upload error code: ' . $file->getError());
        }

        $extension = $this->detectImportExtension(
            $file->getClientName(),
            $file->getClientMimeType()
        );

        if ($extension === null || !in_array($extension, ['xlsx', 'csv'], true)) {
            return redirect()->to(site_url('fsr'))->with('error', 'Only .xlsx and .csv files are allowed.');
        }

        if ($file->getSize() <= 0) {
            return redirect()->to(site_url('fsr'))->with('error', 'The uploaded Excel file is empty.');
        }

        $targetDir = WRITEPATH . 'upload';

        if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
            return redirect()->to(site_url('fsr'))->with('error', 'Unable to create temporary upload directory.');
        }

        try {
            $randomName = bin2hex(random_bytes(8));
        } catch (\Throwable $e) {
            $randomName = uniqid('', true);
        }

        $fileName = 'fsr_import_' . date('Ymd_His') . '_' . $randomName . '.' . $extension;
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        try {
            $file->move($targetDir, $fileName);
        } catch (\Throwable $e) {
            return redirect()->to(site_url('fsr'))->with('error', 'Unable to save uploaded Excel file: ' . $e->getMessage());
        }

        if (!is_file($targetPath)) {
            return redirect()->to(site_url('fsr'))->with('error', 'Uploaded Excel file could not be found after upload.');
        }

        try {
            $rows = $this->parseExcelRows($targetPath);
        } catch (\Throwable $e) {
            if (is_file($targetPath)) {
                @unlink($targetPath);
            }

            return redirect()->to(site_url('fsr'))->with('error', 'Excel import failed: ' . $e->getMessage());
        }

        if (empty($rows)) {
            if (is_file($targetPath)) {
                @unlink($targetPath);
            }

            return redirect()->to(site_url('fsr'))->with('error', 'No data rows were found in the Excel file.');
        }

        $database = db_connect();

        if (!$database->tableExists('tb_fsr')) {
            if (is_file($targetPath)) {
                @unlink($targetPath);
            }

            return redirect()->to(site_url('fsr'))->with('error', 'The tb_fsr table does not exist.');
        }

        $availableColumns = [];
        $columns = $database->query('SHOW COLUMNS FROM tb_fsr')->getResultArray();

        foreach ($columns as $column) {
            if (isset($column['Field'])) {
                $availableColumns[] = $column['Field'];
            }
        }

        $inserted = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($rows as $row) {
            $fsrNumber = trim((string) ($row['A']['value'] ?? ''));
            $serviceEngineer = trim((string) ($row['B']['value'] ?? ''));
            $account = trim((string) ($row['C']['value'] ?? ''));
            $address = trim((string) ($row['D']['value'] ?? ''));
            $date = trim((string) ($row['E']['value'] ?? ''));
            $machine = trim((string) ($row['F']['value'] ?? ''));
            $serialNumber = trim((string) ($row['G']['value'] ?? ''));
            $technicalConcern = trim((string) ($row['H']['value'] ?? ''));
            $remarks = trim((string) ($row['I']['value'] ?? ''));
            $actionMade = trim((string) ($row['J']['value'] ?? ''));
            $acknowledge = trim((string) ($row['K']['value'] ?? ''));

            $candidate = [
                $fsrNumber,
                $serviceEngineer,
                $account,
                $address,
                $date,
                $machine,
                $serialNumber,
                $technicalConcern,
                $remarks,
                $actionMade,
                $acknowledge,
            ];

            if (!$this->hasMeaningfulImportValue($candidate)) {
                $skipped++;
                continue;
            }

            if ($fsrNumber !== '' && preg_match('/^\d+$/', $fsrNumber)) {
                $fsrNumber = str_pad($fsrNumber, 6, '0', STR_PAD_LEFT);
            }

            $record = [
                'fsr_number' => $fsrNumber,
                'service_engineer' => $serviceEngineer,
                'account' => $account,
                'address' => $address,
                'date' => $this->normalizeExcelDate($date),
                'machine' => $machine,
                'serial_number' => $serialNumber,
                'technical_concern' => $technicalConcern,
                'remarks' => $remarks,
                'action_made' => $actionMade,
                'acknowledge' => ($acknowledge === '1' || strtolower($acknowledge) === 'yes') ? 1 : 0,
            ];

            $insert = [];

            foreach ($record as $column => $value) {
                if (in_array($column, $availableColumns, true)) {
                    $insert[$column] = $value;
                }
            }

            if (empty($insert)) {
                $failed++;
                continue;
            }

            $existing = null;

            if ($fsrNumber !== '' && in_array('fsr_number', $availableColumns, true)) {
                $existing = $database->table('tb_fsr')->where('fsr_number', $fsrNumber)->get()->getRowArray();
            } else {
                $duplicateBuilder = $database->table('tb_fsr');
                $duplicateFields = [
                    'service_engineer' => $serviceEngineer,
                    'account' => $account,
                    'address' => $address,
                    'date' => $this->normalizeExcelDate($date),
                    'machine' => $machine,
                    'serial_number' => $serialNumber,
                ];

                foreach ($duplicateFields as $column => $value) {
                    if (in_array($column, $availableColumns, true)) {
                        $duplicateBuilder->where($column, $value);
                    }
                }

                $existing = $duplicateBuilder->get()->getRowArray();
            }

            if ($existing) {
                $skipped++;
                continue;
            }

            try {
                $insertedResult = $database->table('tb_fsr')->insert($insert);

                if ($insertedResult) {
                    $inserted++;
                } else {
                    $failed++;
                }
            } catch (\Throwable $e) {
                $failed++;
            }
        }

        if (is_file($targetPath)) {
            @unlink($targetPath);
        }

        $message = 'FSR import completed. Imported: ' . $inserted . ', Skipped: ' . $skipped . ', Failed: ' . $failed . '.';

        if ($inserted > 0) {
            return redirect()->to(site_url('fsr'))->with('success', $message);
        }

        if ($failed > 0 || $skipped > 0) {
            return redirect()->to(site_url('fsr'))->with('error', $message);
        }

        return redirect()->to(site_url('fsr'))->with('error', 'No valid FSR records were imported.');
    }

    private function detectImportExtension(?string $fileName, ?string $mimeType = null): ?string
    {
        $normalizedName = strtolower(trim((string) $fileName));
        $extension = strtolower(pathinfo($normalizedName, PATHINFO_EXTENSION));

        if (in_array($extension, ['xlsx', 'csv'], true)) {
            return $extension;
        }

        $normalizedMime = strtolower(trim((string) $mimeType));

        if ($normalizedMime === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            return 'xlsx';
        }

        if (in_array($normalizedMime, ['text/csv', 'application/csv'], true)) {
            return 'csv';
        }

        return null;
    }

    private function hasMeaningfulImportValue(array $candidate): bool
    {
        foreach ($candidate as $value) {
            if (is_string($value) && trim($value) !== '') {
                return true;
            }

            if (is_numeric($value) && (string) $value !== '') {
                return true;
            }
        }

        return false;
    }

    private function normalizeExcelDate(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return '';
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return $value;
        }

        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{2,4}$/', $value)) {
            $timestamp = strtotime(str_replace('/', '-', $value));
            return $timestamp !== false ? date('Y-m-d', $timestamp) : '';
        }

        if (preg_match('/^\d{1,2}-\d{1,2}-\d{2,4}$/', $value)) {
            $timestamp = strtotime(str_replace('-', '/', $value));
            return $timestamp !== false ? date('Y-m-d', $timestamp) : '';
        }

        if (is_numeric($value)) {
            $timestamp = strtotime('1899-12-30 + ' . (int) $value . ' days');
            return $timestamp !== false ? date('Y-m-d', $timestamp) : '';
        }

        return $value;
    }

    private function parseExcelRows(string $path): array
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($extension === 'csv') {
            $rows = [];
            $handle = fopen($path, 'rb');

            if ($handle === false) {
                throw new \RuntimeException('Unable to read CSV file.');
            }

            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }

            fclose($handle);

            if (!empty($rows)) {
                array_shift($rows);
            }

            $mappedRows = [];
            $colLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];

            foreach ($rows as $row) {
                $mapped = [];

                foreach ($colLetters as $index => $letter) {
                    if (!isset($row[$index])) {
                        continue;
                    }

                    $mapped[$letter] = ['value' => $row[$index]];
                }

                if ($mapped !== []) {
                    $mappedRows[] = $mapped;
                }
            }

            return $mappedRows;
        }

        if ($extension !== 'xlsx') {
            throw new \RuntimeException('Only .xlsx and .csv files are supported.');
        }

        if (!class_exists('ZipArchive')) {
            throw new \RuntimeException('The ZipArchive extension is required for Excel upload support.');
        }

        $zip = new \ZipArchive();

        if ($zip->open($path) !== true) {
            throw new \RuntimeException('Unable to open Excel file.');
        }

        $mainNamespace = 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';
        $relationshipNamespace = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships';
        $packageRelationshipNamespace = 'http://schemas.openxmlformats.org/package/2006/relationships';

        $sharedStrings = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');

        if ($sharedXml !== false) {
            $sharedDocument = new \DOMDocument();
            $sharedDocument->preserveWhiteSpace = false;

            if (@$sharedDocument->loadXML($sharedXml)) {
                $sharedXPath = new \DOMXPath($sharedDocument);
                $sharedXPath->registerNamespace('x', $mainNamespace);
                $sharedItems = $sharedXPath->query('//x:si');

                if ($sharedItems !== false) {
                    foreach ($sharedItems as $si) {
                        $text = '';
                        $textNodes = $sharedXPath->query('.//x:t', $si);

                        if ($textNodes !== false) {
                            foreach ($textNodes as $textNode) {
                                $text .= $textNode->nodeValue;
                            }
                        }

                        $sharedStrings[] = $text;
                    }
                }
            }
        }

        $readCellValue = function (\DOMElement $cell) use ($sharedStrings, $mainNamespace): string {
            $cellType = $cell->getAttribute('t');

            if ($cellType === 'inlineStr') {
                $inlineTextNodes = $cell->getElementsByTagNameNS($mainNamespace, 't');
                $text = '';

                foreach ($inlineTextNodes as $inlineTextNode) {
                    $text .= $inlineTextNode->nodeValue;
                }

                return $text;
            }

            $valueNode = $cell->getElementsByTagNameNS($mainNamespace, 'v')->item(0);
            if ($valueNode === null) {
                return '';
            }

            $rawValue = trim((string) $valueNode->nodeValue);

            if ($cellType === 's') {
                return isset($sharedStrings[(int) $rawValue]) ? $sharedStrings[(int) $rawValue] : '';
            }

            return $rawValue;
        };

        $workbookContent = $zip->getFromName('xl/workbook.xml');
        if ($workbookContent === false) {
            $zip->close();
            throw new \RuntimeException('Unable to read workbook metadata from Excel file.');
        }

        $workbookDocument = new \DOMDocument();
        $workbookDocument->preserveWhiteSpace = false;

        if (!@$workbookDocument->loadXML($workbookContent)) {
            $zip->close();
            throw new \RuntimeException('Unable to parse workbook metadata from Excel file.');
        }

        $workbookXPath = new \DOMXPath($workbookDocument);
        $workbookXPath->registerNamespace('main', $mainNamespace);
        $workbookXPath->registerNamespace('rel', $relationshipNamespace);

        $sheetTargets = $workbookXPath->query('//main:sheets/main:sheet');
        $sheetTarget = null;

        if ($sheetTargets !== false && $sheetTargets->length > 0) {
            $sheet = $sheetTargets->item(0);
            if ($sheet && $sheet->hasAttribute('r:id')) {
                $sheetTarget = $sheet->getAttribute('r:id');
            }
        }

        if ($sheetTarget === null) {
            $zip->close();
            throw new \RuntimeException('Unable to determine worksheet target from Excel file.');
        }

        $relsContent = $zip->getFromName('xl/_rels/workbook.xml.rels');
        if ($relsContent === false) {
            $zip->close();
            throw new \RuntimeException('Unable to resolve worksheet relationship from Excel file.');
        }

        $relsDocument = new \DOMDocument();
        $relsDocument->preserveWhiteSpace = false;

        if (!@$relsDocument->loadXML($relsContent)) {
            $zip->close();
            throw new \RuntimeException('Unable to parse workbook relationships from Excel file.');
        }

        $relsXPath = new \DOMXPath($relsDocument);
        $relsXPath->registerNamespace('rel', $packageRelationshipNamespace);
        $sheetRelationship = $relsXPath->query('//rel:Relationship[@Id="' . $sheetTarget . '"]');

        if ($sheetRelationship === false || $sheetRelationship->length === 0) {
            $zip->close();
            throw new \RuntimeException('Unable to find worksheet relationship in Excel file.');
        }

        $target = $sheetRelationship->item(0)->getAttribute('Target');
        $sheetXml = $zip->getFromName('xl/' . ltrim($target, '/'));

        if ($sheetXml === false) {
            $zip->close();
            throw new \RuntimeException('Unable to open worksheet data from Excel file.');
        }

        $sheetDocument = new \DOMDocument();
        $sheetDocument->preserveWhiteSpace = false;

        if (!@$sheetDocument->loadXML($sheetXml)) {
            $zip->close();
            throw new \RuntimeException('Unable to parse worksheet data from Excel file.');
        }

        $sheetXPath = new \DOMXPath($sheetDocument);
        $sheetXPath->registerNamespace('main', $mainNamespace);

        $rows = [];
        $rowNodes = $sheetXPath->query('//main:sheetData/main:row');

        if ($rowNodes === false) {
            $zip->close();
            return [];
        }

        foreach ($rowNodes as $rowNode) {
            $values = [];
            $cellNodes = $rowNode->getElementsByTagNameNS($mainNamespace, 'c');

            foreach ($cellNodes as $cellNode) {
                $cellRef = $cellNode->getAttribute('r');
                $columnLetter = preg_replace('/\d+$/', '', $cellRef);
                $values[$columnLetter] = ['value' => $readCellValue($cellNode)];
            }

            $rowValues = [];
            foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'] as $letter) {
                $rowValues[$letter] = $values[$letter] ?? ['value' => ''];
            }

            $rows[] = $rowValues;
        }

        $zip->close();

        if (!empty($rows) && isset($rows[0]['A']['value']) && trim((string) $rows[0]['A']['value']) === 'FSR Number') {
            array_shift($rows);
        }

        return $rows;
    }


    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Please login first.'
            ]);
        }

        $record = db_connect()->table('tb_fsr')->where('id', (int) $id)->get()->getRowArray();

        if (!$record) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'FSR record not found.'
            ]);
        }

        $serviceEngId = 0;
        if (db_connect()->tableExists('tb_user')) {
            $users = db_connect()->table('tb_user')->select('id,fname,lname,uname')->get()->getResultArray();
            foreach ($users as $user) {
                $name = trim(($user['fname'] ?? '') . ' ' . ($user['lname'] ?? ''));
                $name = $name !== '' ? $name : trim((string) ($user['uname'] ?? ''));
                if (strcasecmp($name, (string) ($record['service_engineer'] ?? '')) === 0) {
                    $serviceEngId = (int) $user['id'];
                    break;
                }
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => array_merge($record, ['service_eng_id' => $serviceEngId])
        ]);
    }

    public function update($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Please login first.'
            ]);
        }

        $database = db_connect();
        $record = $database->table('tb_fsr')->where('id', (int) $id)->get()->getRowArray();

        if (!$record) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'FSR record not found.'
            ]);
        }

        $serviceEngineer = trim((string) $this->request->getPost('service_engineer'));
        $serviceEngId = (int) $this->request->getPost('service_eng_id');

        if ($serviceEngId > 0 && $database->tableExists('tb_user')) {
            $user = $database->table('tb_user')->where('id', $serviceEngId)->get()->getRowArray();

            if ($user) {
                $serviceEngineer = trim(($user['fname'] ?? '') . ' ' . ($user['lname'] ?? ''));
                $serviceEngineer = $serviceEngineer !== '' ? $serviceEngineer : trim((string) ($user['uname'] ?? ''));
            }
        }

        if ($serviceEngineer === '' || trim((string) $this->request->getPost('account')) === '' || trim((string) $this->request->getPost('machine')) === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'message' => 'Please fill in Service Engineer, Account and Machine.'
            ]);
        }

        $fsrNumber = trim((string) $this->request->getPost('fsr_number'));
        if (preg_match('/^\d+$/', $fsrNumber)) {
            $fsrNumber = str_pad($fsrNumber, 6, '0', STR_PAD_LEFT);
        }

        $updated = $database->table('tb_fsr')->where('id', (int) $id)->update([
            'fsr_number' => $fsrNumber,
            'service_engineer' => $serviceEngineer,
            'account' => trim((string) $this->request->getPost('account')),
            'address' => trim((string) $this->request->getPost('address')),
            'date' => trim((string) $this->request->getPost('date')) ?: null,
            'machine' => trim((string) $this->request->getPost('machine')),
            'serial_number' => trim((string) $this->request->getPost('serial_number')),
            'technical_concern' => trim((string) $this->request->getPost('technical_concern')),
            'remarks' => trim((string) $this->request->getPost('remarks')),
            'action_made' => trim((string) $this->request->getPost('action_made')),
            'acknowledge' => trim((string) $this->request->getPost('acknowledge'))
        ]);

        if (!$updated) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to update FSR record.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'FSR record updated successfully.'
        ]);
    }

    public function delete($id): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))->with('error', 'Please login first.');
        }

        $database = db_connect();
        $id = (int) $id;

        if (!$database->table('tb_fsr')->where('id', $id)->countAllResults()) {
            return redirect()->back()->with('error', 'FSR record not found.');
        }

        if ($database->tableExists('tb_pms')) {
            $database->table('tb_pms')->where('fsr', $id)->update(['fsr' => null]);
        }

        $deleted = $database->table('tb_fsr')->where('id', $id)->delete();

        return redirect()->back()->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'FSR record deleted successfully.' : 'Failed to delete FSR record.'
        );
    }

    /*
     * ==========================================
     * EXPORT FSR
     * ==========================================
     */
    public function export()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        if (!$database->tableExists('tb_fsr')) {
            return redirect()->back()
                ->with('error', 'No FSR data to export.');
        }

        $selectedEngineer = trim(
            (string) ($this->request->getGet('engineer') ?? '')
        );

        $sql = "
            SELECT
                fsr_number,
                service_engineer,
                account,
                address,
                date,
                machine,
                serial_number,
                technical_concern,
                remarks,
                action_made,
                acknowledge,
                created_at
            FROM tb_fsr
        ";

        $params = [];

        if ($selectedEngineer !== '') {

            $sql .= " WHERE service_engineer = ?";

            $params[] = $selectedEngineer;

            $filename =
                'fsr_' .
                preg_replace(
                    '/[^A-Za-z0-9_\-]/',
                    '_',
                    $selectedEngineer
                ) .
                '_' .
                date('Ymd_Hi') .
                '.csv';

        } else {

            $filename =
                'fsr_all_' .
                date('Ymd_Hi') .
                '.csv';
        }

        $rows = $database
            ->query($sql, $params)
            ->getResultArray();


        header(
            'Content-Type: text/csv; charset=utf-8'
        );

        header(
            'Content-Disposition: attachment; filename="' .
            $filename .
            '"'
        );

        echo "\xEF\xBB\xBF";

        $out = fopen('php://output', 'w');


        fputcsv($out, [
            'FSR Number',
            'Service Engineer',
            'Account',
            'Address',
            'Date',
            'Machine',
            'Serial Number',
            'Technical Concern',
            'Remarks',
            'Action Made',
            'Acknowledge',
            'Created At'
        ]);


        foreach ($rows as $r) {

            $fsrNumber =
                $r['fsr_number'] ?? '';

            if (preg_match('/^\d+$/', $fsrNumber)) {

                $fsrNumber = str_pad(
                    $fsrNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }


            fputcsv($out, [

                $fsrNumber,

                $r['service_engineer']
                    ?? '',

                $r['account']
                    ?? '',

                $r['address']
                    ?? '',

                $r['date']
                    ?? '',

                $r['machine']
                    ?? '',

                $r['serial_number']
                    ?? '',

                $r['technical_concern']
                    ?? '',

                $r['remarks']
                    ?? '',

                $r['action_made']
                    ?? '',

                $r['acknowledge']
                    ?? '',

                $r['created_at']
                    ?? '',
            ]);
        }


        fclose($out);

        exit;
    }
}
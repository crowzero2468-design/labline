<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Mfs extends BaseController
{
    public function index(): string|RedirectResponse
    {
        /*
         * LOGIN CHECK
         */
        if (!session()->get('logged_in')) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();


        /*
         * ============================
         * USERS / SERVICE ENGINEERS
         * ============================
         */
        $users = [];

        if ($database->tableExists('tb_user')) {

            $users = $database
                ->table('tb_user')
                ->select('id,fname,lname')
                ->orderBy('fname', 'ASC')
                ->get()
                ->getResultArray();
        }


        /*
         * ============================
         * ACCOUNTS / CLINICS
         *
         * SAME SOURCE AS PMS
         *
         * tb_data:
         * Clinic_name
         * Address
         * Machine
         * SN
         * ============================
         */
        $accounts = [];

        if ($database->tableExists('tb_data')) {

            $accounts = $database
                ->table('tb_data')
                ->select('id,Clinic_name,Address,Machine,SN')
                ->orderBy('Clinic_name', 'ASC')
                ->get()
                ->getResultArray();
        }


        /*
         * ============================
         * MFS RECORDS
         * ============================
         */
        $mfsRecords = [];
        $employeeList = [];

        $selectedEmployee = trim(
            (string) ($this->request->getGet('employee') ?? '')
        );


        if ($database->tableExists('tb_mfs')) {

            /*
             * Employee list with count
             */
            $employeeList = $database->query("
                SELECT
                    employee,
                    COUNT(*) AS total
                FROM tb_mfs
                WHERE employee IS NOT NULL
                  AND employee != ''
                GROUP BY employee
                ORDER BY employee ASC
            ")->getResultArray();


            /*
             * Main MFS records
             */
            $sql = "
                SELECT
                    id,
                    mfs_number,
                    employee,
                    accounts,
                    address,
                    date_fillup,
                    unit,
                    machine,
                    serial_number,
                    consumable_unit,
                    consumables,
                    lot_number,
                    remarks,
                    reason,
                    date_status,
                    personnel,
                    acknowledged,
                    returned
                FROM tb_mfs
            ";

            $params = [];


            /*
             * Employee filter
             */
            if ($selectedEmployee !== '') {

                $sql .= " WHERE employee = ?";

                $params[] = $selectedEmployee;
            }


            /*
             * Sort newest first
             */
            $sql .= "
                ORDER BY
                    date_fillup DESC,
                    id DESC
            ";


            $mfsRecords = $database
                ->query($sql, $params)
                ->getResultArray();
        }


        /*
         * ============================
         * NEXT MFS NUMBER
         * ============================
         */
        $nextMfsNumber = '000001';

        if ($database->tableExists('tb_mfs')) {

            $row = $database
                ->query("
                    SELECT MAX(id) AS maxid
                    FROM tb_mfs
                ")
                ->getRow();

            $maxid = (int) ($row->maxid ?? 0);

            $nextMfsNumber = str_pad(
                (string) ($maxid + 1),
                6,
                '0',
                STR_PAD_LEFT
            );
        }


        /*
         * ============================
         * SEND DATA TO VIEW
         * ============================
         */
        return view('dashboard/mfs', [

            'user' => session()->get('user'),

            'users' => $users,

            /*
             * IMPORTANT:
             * This is what allows mfs.php
             * to map Clinic -> Machine -> SN
             */
            'accounts' => $accounts,

            'mfs_records' => $mfsRecords,

            'employee_list' => $employeeList,

            'selected_employee' => $selectedEmployee,

            'next_mfs_number' => $nextMfsNumber,
        ]);
    }


    /**
     * ==========================================
     * SAVE MFS
     * ==========================================
     */
    public function save(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        if (!$database->tableExists('tb_mfs')) {
            return redirect()->back()
                ->with('error', 'tb_mfs table does not exist.');
        }

        // --------------------------------------------------
        // GET FORM VALUES
        // --------------------------------------------------
        $mfsNumber = trim((string) $this->request->getPost('mfs_number'));

        // Your MFS view uses service_eng_id
        $serviceEngId = trim((string) $this->request->getPost('service_eng_id'));

        $accounts = trim((string) $this->request->getPost('accounts'));
        $address = trim((string) $this->request->getPost('address'));

        $dateFillup = trim((string) $this->request->getPost('date_fillup'));
        $unit = trim((string) $this->request->getPost('unit'));

        $machine = trim((string) $this->request->getPost('machine'));
        $serialNumber = trim((string) $this->request->getPost('serial_number'));

        $consumableUnit = trim((string) $this->request->getPost('consumable_unit'));
        $consumables = trim((string) $this->request->getPost('consumables'));
        $lotNumber = trim((string) $this->request->getPost('lot_number'));

        $remarks = trim((string) $this->request->getPost('remarks'));
        $reason = trim((string) $this->request->getPost('reason'));

        $dateStatus = trim((string) $this->request->getPost('date_status'));
        $personnel = trim((string) $this->request->getPost('personnel'));

        $acknowledged = (int) ($this->request->getPost('acknowledged') ?: 0);
        $returned = (int) ($this->request->getPost('returned') ?: 0);


        // --------------------------------------------------
        // GET EMPLOYEE NAME FROM TB_USER
        // --------------------------------------------------
        $employee = '';

        if ($serviceEngId !== '' && $database->tableExists('tb_user')) {

            $user = $database->table('tb_user')
                ->select('fname,lname,uname')
                ->where('id', $serviceEngId)
                ->get()
                ->getRowArray();

            if ($user) {
                $employee = trim(
                    ($user['fname'] ?? '') . ' ' .
                    ($user['lname'] ?? '')
                );

                // fallback to username
                if ($employee === '') {
                    $employee = trim((string) ($user['uname'] ?? ''));
                }
            }
        }


        // --------------------------------------------------
        // VALIDATION
        // --------------------------------------------------
        if ($employee === '' || $accounts === '' || $machine === '') {

            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Please fill in Employee, Account and Machine.'
                );
        }


        // --------------------------------------------------
        // RESOLVE ACCOUNT / MACHINE / SERIAL FROM TB_DATA
        // --------------------------------------------------
        if ($database->tableExists('tb_data')) {

            $machineData = $database->table('tb_data')
                ->select('Clinic_name,Address,Machine,SN')
                ->where('status', 'A')
                ->where('Clinic_name', $accounts)
                ->where('Machine', $machine)
                ->limit(1)
                ->get()
                ->getRowArray();

            if (!$machineData) {

                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'The selected Account and Machine were not found in tb_data.'
                    );
            }

            // Use official data from tb_data
            $accounts = trim((string) ($machineData['Clinic_name'] ?? $accounts));
            $address = trim((string) ($machineData['Address'] ?? $address));
            $machine = trim((string) ($machineData['Machine'] ?? $machine));
            $serialNumber = trim((string) ($machineData['SN'] ?? ''));
        }


        // --------------------------------------------------
        // GENERATE MFS NUMBER
        // --------------------------------------------------
        if ($mfsNumber === '') {

            $row = $database->query(
                "SELECT MAX(id) AS maxid FROM tb_mfs"
            )->getRow();

            $maxid = (int) ($row->maxid ?? 0);

            $mfsNumber = str_pad(
                (string) ($maxid + 1),
                6,
                '0',
                STR_PAD_LEFT
            );

        } elseif (preg_match('/^\d+$/', $mfsNumber)) {

            $mfsNumber = str_pad(
                $mfsNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
        }


        // --------------------------------------------------
        // INSERT
        // --------------------------------------------------
        $insert = [
            'mfs_number'     => $mfsNumber,
            'employee'       => $employee,
            'accounts'       => $accounts,
            'address'        => $address,

            'date_fillup'    => $dateFillup === ''
                ? date('Y-m-d')
                : $dateFillup,

            'unit'           => $unit,
            'machine'        => $machine,
            'serial_number'  => $serialNumber,

            'consumable_unit'=> $consumableUnit,
            'consumables'    => $consumables,
            'lot_number'     => $lotNumber,

            'remarks'        => $remarks,
            'reason'         => $reason,

            'date_status'    => $dateStatus === ''
                ? null
                : $dateStatus,

            'personnel'      => $personnel,

            'acknowledged'   => $acknowledged,
            'returned'       => $returned,
        ];


        $result = $database
            ->table('tb_mfs')
            ->insert($insert);


        if (!$result) {

            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to save MFS record.'
                );
        }


        return redirect()
            ->to(site_url('mfs'))
            ->with(
                'success',
                'MFS record added successfully.'
            );
    }

    /**
     * ==========================================
     * IMPORT MFS EXCEL
     * ==========================================
     */
    public function importExcel(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))->with('error', 'Please login first.');
        }

        $file = $this->request->getFile('excel_file');

        if ($file === null || !$file->isValid()) {
            return redirect()->to(site_url('mfs'))->with('error', 'Please choose an Excel file to import.');
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            return redirect()->to(site_url('mfs'))->with('error', 'Excel upload failed. Upload error code: ' . $file->getError());
        }

        $allowedExtensions = ['xlsx', 'csv'];
        $extension = $this->detectImportExtension(
            $file->getClientName(),
            $file->getClientMimeType()
        );

        if ($extension === null || !in_array($extension, $allowedExtensions, true)) {
            return redirect()->to(site_url('mfs'))->with('error', 'Only .xlsx and .csv files are allowed.');
        }

        if ($file->getSize() <= 0) {
            return redirect()->to(site_url('mfs'))->with('error', 'The uploaded Excel file is empty.');
        }

        $targetDir = WRITEPATH . 'upload';

        if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
            return redirect()->to(site_url('mfs'))->with('error', 'Unable to create temporary upload directory.');
        }

        try {
            $randomName = bin2hex(random_bytes(8));
        } catch (\Throwable $e) {
            $randomName = uniqid('', true);
        }

        $fileName = 'mfs_import_' . date('Ymd_His') . '_' . $randomName . '.' . $extension;
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        try {
            $file->move($targetDir, $fileName);
        } catch (\Throwable $e) {
            return redirect()->to(site_url('mfs'))->with('error', 'Unable to save uploaded Excel file: ' . $e->getMessage());
        }

        if (!is_file($targetPath)) {
            return redirect()->to(site_url('mfs'))->with('error', 'Uploaded Excel file could not be found after upload.');
        }

        try {
            $rows = $this->parseExcelRows($targetPath);
        } catch (\Throwable $e) {
            if (is_file($targetPath)) {
                @unlink($targetPath);
            }

            return redirect()->to(site_url('mfs'))->with('error', 'Excel import failed: ' . $e->getMessage());
        }

        if (empty($rows)) {
            if (is_file($targetPath)) {
                @unlink($targetPath);
            }

            return redirect()->to(site_url('mfs'))->with('error', 'No data rows were found in the Excel file.');
        }

        $database = db_connect();

        if (!$database->tableExists('tb_mfs')) {
            if (is_file($targetPath)) {
                @unlink($targetPath);
            }

            return redirect()->to(site_url('mfs'))->with('error', 'The tb_mfs table does not exist.');
        }

        $availableColumns = [];
        $columns = $database->query('SHOW COLUMNS FROM tb_mfs')->getResultArray();

        foreach ($columns as $column) {
            if (isset($column['Field'])) {
                $availableColumns[] = $column['Field'];
            }
        }

        $inserted = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($rows as $row) {
            $mfsNumber = trim((string) ($row['A']['value'] ?? ''));
            $employee = trim((string) ($row['B']['value'] ?? ''));
            $accounts = trim((string) ($row['C']['value'] ?? ''));
            $address = trim((string) ($row['D']['value'] ?? ''));
            $dateFillup = trim((string) ($row['E']['value'] ?? ''));
            $unit = trim((string) ($row['F']['value'] ?? ''));
            $machine = trim((string) ($row['G']['value'] ?? ''));
            $serialNumber = trim((string) ($row['H']['value'] ?? ''));
            $consumableUnit = trim((string) ($row['I']['value'] ?? ''));
            $consumables = trim((string) ($row['J']['value'] ?? ''));
            $lotNumber = trim((string) ($row['K']['value'] ?? ''));
            $remarks = trim((string) ($row['L']['value'] ?? ''));
            $reason = trim((string) ($row['M']['value'] ?? ''));
            $dateStatus = trim((string) ($row['N']['value'] ?? ''));
            $personnel = trim((string) ($row['O']['value'] ?? ''));
            $acknowledged = trim((string) ($row['P']['value'] ?? ''));
            $returned = trim((string) ($row['Q']['value'] ?? ''));

            $candidate = [
                $mfsNumber,
                $employee,
                $accounts,
                $address,
                $dateFillup,
                $unit,
                $machine,
                $serialNumber,
                $consumableUnit,
                $consumables,
                $lotNumber,
                $remarks,
                $reason,
                $dateStatus,
                $personnel,
                $acknowledged,
                $returned,
            ];

            if (!$this->hasMeaningfulImportValue($candidate)) {
                $skipped++;
                continue;
            }

            if ($mfsNumber !== '' && preg_match('/^\d+$/', $mfsNumber)) {
                $mfsNumber = str_pad($mfsNumber, 6, '0', STR_PAD_LEFT);
            }

            $record = [
                'mfs_number' => $mfsNumber,
                'employee' => $employee,
                'accounts' => $accounts,
                'address' => $address,
                'date_fillup' => $this->normalizeExcelDate($dateFillup),
                'unit' => $unit,
                'machine' => $machine,
                'serial_number' => $serialNumber,
                'consumable_unit' => $consumableUnit,
                'consumables' => $consumables,
                'lot_number' => $lotNumber,
                'remarks' => $remarks,
                'reason' => $reason,
                'date_status' => $this->normalizeExcelDate($dateStatus),
                'personnel' => $personnel,
                'acknowledged' => ($acknowledged === '1' || strtolower($acknowledged) === 'yes') ? 1 : 0,
                'returned' => (int) preg_match('/\d+/', $returned) ? (int) preg_replace('/[^0-9]/', '', $returned) : 0,
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

            if ($mfsNumber !== '' && in_array('mfs_number', $availableColumns, true)) {
                $existing = $database->table('tb_mfs')->where('mfs_number', $mfsNumber)->get()->getRowArray();
            } else {
                $duplicateBuilder = $database->table('tb_mfs');
                $duplicateFields = [
                    'employee' => $employee,
                    'accounts' => $accounts,
                    'address' => $address,
                    'date_fillup' => $this->normalizeExcelDate($dateFillup),
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
                $insertedResult = $database->table('tb_mfs')->insert($insert);

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

        $message = 'MFS import completed. Imported: ' . $inserted . ', Skipped: ' . $skipped . ', Failed: ' . $failed . '.';

        if ($inserted > 0) {
            return redirect()->to(site_url('mfs'))->with('success', $message);
        }

        return redirect()->to(site_url('mfs'))->with('error', $message);
    }

    /**
     * ==========================================
     * EXPORT MFS
     * ==========================================
     */
    public function export()
    {
        /*
         * LOGIN CHECK
         */
        if (!session()->get('logged_in')) {

            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Please login first.');
        }


        $database = db_connect();


        /*
         * TABLE CHECK
         */
        if (!$database->tableExists('tb_mfs')) {

            return redirect()
                ->back()
                ->with('error', 'No MFS data to export.');
        }


        /*
         * SELECTED EMPLOYEE
         */
        $selectedEmployee = trim(
            (string) ($this->request->getGet('employee') ?? '')
        );


        /*
         * QUERY
         */
        $sql = "
            SELECT
                mfs_number,
                employee,
                accounts,
                address,
                date_fillup,
                unit,
                machine,
                serial_number,
                consumable_unit,
                consumables,
                lot_number,
                remarks,
                reason,
                date_status,
                personnel,
                acknowledged,
                returned
            FROM tb_mfs
        ";

        $params = [];


        /*
         * EMPLOYEE FILTER
         */
        if ($selectedEmployee !== '') {

            $sql .= " WHERE employee = ?";

            $params[] = $selectedEmployee;

            $safeEmployee = preg_replace(
                '/[^A-Za-z0-9_\-]/',
                '_',
                $selectedEmployee
            );

            $filename =
                'mfs_' .
                $safeEmployee .
                '_' .
                date('Ymd_Hi') .
                '.csv';

        } else {

            $filename =
                'mfs_all_' .
                date('Ymd_Hi') .
                '.csv';
        }


        /*
         * ORDER
         */
        $sql .= "
            ORDER BY
                date_fillup DESC,
                mfs_number DESC
        ";


        /*
         * GET DATA
         */
        $rows = $database
            ->query($sql, $params)
            ->getResultArray();


        /*
         * CSV HEADERS
         */
        header(
            'Content-Type: text/csv; charset=utf-8'
        );

        header(
            'Content-Disposition: attachment; filename="' .
            $filename .
            '"'
        );


        /*
         * UTF-8 BOM
         */
        echo "\xEF\xBB\xBF";


        $out = fopen(
            'php://output',
            'w'
        );


        /*
         * COLUMN HEADERS
         */
        fputcsv($out, [

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

        ]);


        /*
         * CSV DATA
         */
        foreach ($rows as $r) {

            $mfsNumber =
                $r['mfs_number'] ?? '';


            /*
             * Zero pad MFS number
             */
            if (preg_match('/^\d+$/', $mfsNumber)) {

                $mfsNumber = str_pad(
                    $mfsNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }


            fputcsv($out, [

                $mfsNumber,

                $r['employee'] ?? '',

                $r['accounts'] ?? '',

                $r['address'] ?? '',

                $r['date_fillup'] ?? '',

                $r['unit'] ?? '',

                $r['machine'] ?? '',

                $r['serial_number'] ?? '',

                $r['consumable_unit'] ?? '',

                $r['consumables'] ?? '',

                $r['lot_number'] ?? '',

                $r['remarks'] ?? '',

                $r['reason'] ?? '',

                $r['date_status'] ?? '',

                $r['personnel'] ?? '',

                (
                    (int) ($r['acknowledged'] ?? 0) === 1
                        ? 'Yes'
                        : 'No'
                ),

                $r['returned'] ?? 0,

            ]);
        }


        fclose($out);

        exit;
    }

    /**
 * ==========================================
 * GET MFS RECORD FOR EDIT
 * ==========================================
 */
public function edit($id)
{
    if (!session()->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Please login first.'
            ]);
    }

    $database = db_connect();

    if (!$database->tableExists('tb_mfs')) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'tb_mfs table does not exist.'
            ]);
    }

    $id = (int) $id;

    if ($id <= 0) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Invalid MFS record ID.'
            ]);
    }

    $mfs = $database
        ->table('tb_mfs')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$mfs) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'MFS record not found.'
            ]);
    }

    $serviceEngId = 0;

    if ($database->tableExists('tb_user')) {
        $users = $database
            ->table('tb_user')
            ->select('id,fname,lname,uname')
            ->get()
            ->getResultArray();

        foreach ($users as $user) {
            $name = trim(($user['fname'] ?? '') . ' ' . ($user['lname'] ?? ''));
            $name = $name !== '' ? $name : trim((string) ($user['uname'] ?? ''));

            if (strcasecmp($name, (string) ($mfs['employee'] ?? '')) === 0) {
                $serviceEngId = (int) $user['id'];
                break;
            }
        }
    }

    $mfs['service_eng_id'] = $serviceEngId;

    return $this->response->setJSON([
        'success' => true,
        'data' => $mfs
    ]);
}

/**
 * ==========================================
 * UPDATE MFS
 * ==========================================
 */
public function update($id)
{
    if (!session()->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Please login first.'
            ]);
    }

    $database = db_connect();

    if (!$database->tableExists('tb_mfs')) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'tb_mfs table does not exist.'
            ]);
    }

    $id = (int) $id;

    if ($id <= 0) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Invalid MFS record ID.'
            ]);
    }

    // --------------------------------------------------
    // CHECK RECORD
    // --------------------------------------------------

    $existing = $database
        ->table('tb_mfs')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$existing) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'MFS record not found.'
            ]);
    }

    // --------------------------------------------------
    // GET FORM VALUES
    // --------------------------------------------------

    $mfsNumber = trim(
        (string) $this->request->getPost('mfs_number')
    );

    $employee = trim(
        (string) $this->request->getPost('employee')
    );

    $serviceEngId = (int) ($this->request->getPost('service_eng_id') ?? 0);

    if ($serviceEngId > 0 && $database->tableExists('tb_user')) {
        $user = $database
            ->table('tb_user')
            ->select('fname,lname,uname')
            ->where('id', $serviceEngId)
            ->get()
            ->getRowArray();

        if ($user) {
            $employee = trim(($user['fname'] ?? '') . ' ' . ($user['lname'] ?? ''));
            $employee = $employee !== '' ? $employee : trim((string) ($user['uname'] ?? ''));
        }
    }

    $accounts = trim(
        (string) $this->request->getPost('accounts')
    );

    $address = trim(
        (string) $this->request->getPost('address')
    );

    $dateFillup = trim(
        (string) $this->request->getPost('date_fillup')
    );

    $unit = trim(
        (string) $this->request->getPost('unit')
    );

    $machine = trim(
        (string) $this->request->getPost('machine')
    );

    $serialNumber = trim(
        (string) $this->request->getPost('serial_number')
    );

    $consumableUnit = trim(
        (string) $this->request->getPost('consumable_unit')
    );

    $consumables = trim(
        (string) $this->request->getPost('consumables')
    );

    $lotNumber = trim(
        (string) $this->request->getPost('lot_number')
    );

    $reason = trim(
        (string) $this->request->getPost('reason')
    );

    $dateStatus = trim(
        (string) $this->request->getPost('date_status')
    );

    $personnel = trim(
        (string) $this->request->getPost('personnel')
    );

    $acknowledged = (int) (
        $this->request->getPost('acknowledged') ?: 0
    );

    $returned = (int) (
        $this->request->getPost('returned') ?: 0
    );

    $remarks = trim(
        (string) $this->request->getPost('remarks')
    );


    // --------------------------------------------------
    // VALIDATION
    // --------------------------------------------------

    if (
        $mfsNumber === '' ||
        $employee === '' ||
        $accounts === '' ||
        $machine === ''
    ) {
        return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'success' => false,
                'message' =>
                    'Please fill in MFS Number, Employee, Account and Machine.'
            ]);
    }


    // --------------------------------------------------
    // ZERO PAD MFS NUMBER
    // --------------------------------------------------

    if (preg_match('/^\d+$/', $mfsNumber)) {

        $mfsNumber = str_pad(
            $mfsNumber,
            6,
            '0',
            STR_PAD_LEFT
        );

    }


    // --------------------------------------------------
    // UPDATE DATA
    // --------------------------------------------------

    $update = [

        'mfs_number' =>
            $mfsNumber,

        'employee' =>
            $employee,

        'accounts' =>
            $accounts,

        'address' =>
            $address,

        'date_fillup' =>
            $dateFillup === ''
                ? ($existing['date_fillup'] ?? date('Y-m-d'))
                : $dateFillup,

        'unit' =>
            $unit,

        'machine' =>
            $machine,

        'serial_number' =>
            $serialNumber,

        'consumable_unit' =>
            $consumableUnit,

        'consumables' =>
            $consumables,

        'lot_number' =>
            $lotNumber,

        'reason' =>
            $reason,

        'date_status' =>
            $dateStatus === ''
                ? null
                : $dateStatus,

        'personnel' =>
            $personnel,

        'acknowledged' =>
            $acknowledged,

        'returned' =>
            $returned,

        'remarks' =>
            $remarks,

    ];


    // --------------------------------------------------
    // UPDATE DATABASE
    // --------------------------------------------------

    $result = $database
        ->table('tb_mfs')
        ->where('id', $id)
        ->update($update);


    if (!$result) {

        $error = $database->error();

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'message' =>
                    'Failed to update MFS record.'
                    . (
                        !empty($error['message'])
                            ? ' ' . $error['message']
                            : ''
                    )
            ]);
    }


    return $this->response->setJSON([
        'success' => true,
        'message' => 'MFS record updated successfully.'
    ]);
}

/**
 * ==========================================
 * DELETE MFS
 * ==========================================
 */
public function delete($id)
{
    if (!session()->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Please login first.'
            ]);
    }

    $database = db_connect();

    if (!$database->tableExists('tb_mfs')) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'tb_mfs table does not exist.'
            ]);
    }

    $id = (int) $id;

    if ($id <= 0) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Invalid MFS record ID.'
            ]);
    }


    // --------------------------------------------------
    // CHECK RECORD
    // --------------------------------------------------

    $existing = $database
        ->table('tb_mfs')
        ->where('id', $id)
        ->get()
        ->getRowArray();


    if (!$existing) {

        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'MFS record not found.'
            ]);

    }


    // --------------------------------------------------
    // DELETE
    // --------------------------------------------------

    $result = $database
        ->table('tb_mfs')
        ->where('id', $id)
        ->delete();


    if (!$result) {

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'message' => 'Failed to delete MFS record.'
            ]);

    }


    return $this->response->setJSON([
        'success' => true,
        'message' => 'MFS record deleted successfully.'
    ]);
}

    private function hasMeaningfulImportValue(array $values): bool
    {
        foreach ($values as $value) {
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
            $colLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];

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
            throw new \RuntimeException('The workbook could not be read.');
        }

        $workbookDocument = new \DOMDocument();
        $workbookDocument->preserveWhiteSpace = false;

        if (!@$workbookDocument->loadXML($workbookContent)) {
            $zip->close();
            throw new \RuntimeException('The workbook could not be read.');
        }

        $workbookXPath = new \DOMXPath($workbookDocument);
        $workbookXPath->registerNamespace('x', $mainNamespace);
        $workbookXPath->registerNamespace('r', $relationshipNamespace);

        $worksheetPath = null;
        $sheetNodes = $workbookXPath->query('//x:sheets/x:sheet');
        $relationshipId = '';

        if ($sheetNodes !== false && $sheetNodes->length > 0) {
            $firstSheet = $sheetNodes->item(0);
            $relationshipId = $firstSheet->getAttributeNS($relationshipNamespace, 'id');
        }

        if ($relationshipId === '') {
            $zip->close();
            throw new \RuntimeException('The worksheet could not be found in the workbook.');
        }

        $relsContent = $zip->getFromName('xl/_rels/workbook.xml.rels');
        if ($relsContent === false) {
            $zip->close();
            throw new \RuntimeException('The workbook relationships could not be read.');
        }

        $relsDocument = new \DOMDocument();
        $relsDocument->preserveWhiteSpace = false;

        if (!@$relsDocument->loadXML($relsContent)) {
            $zip->close();
            throw new \RuntimeException('The workbook relationships could not be read.');
        }

        $relsXPath = new \DOMXPath($relsDocument);
        $relsXPath->registerNamespace('rel', $packageRelationshipNamespace);
        $targetNode = $relsXPath->query("//rel:Relationship[@Id='{$relationshipId}']")->item(0);

        if ($targetNode === null) {
            $zip->close();
            throw new \RuntimeException('The worksheet target could not be resolved.');
        }

        $worksheetPath = 'xl/' . ltrim($targetNode->getAttribute('Target'), '/');
        $worksheetXml = $zip->getFromName($worksheetPath);

        if ($worksheetXml === false) {
            $zip->close();
            throw new \RuntimeException('The worksheet XML could not be read.');
        }

        $worksheetDocument = new \DOMDocument();
        $worksheetDocument->preserveWhiteSpace = false;

        if (!@$worksheetDocument->loadXML($worksheetXml)) {
            $zip->close();
            throw new \RuntimeException('The worksheet XML could not be read.');
        }

        $sheetXPath = new \DOMXPath($worksheetDocument);
        $sheetXPath->registerNamespace('x', $mainNamespace);
        $rows = $sheetXPath->query('//x:sheetData/x:row');

        $parsedRows = [];

        if ($rows !== false) {
            foreach ($rows as $rowNode) {
                $cells = $rowNode->getElementsByTagNameNS($mainNamespace, 'c');
                $mapped = [];

                foreach ($cells as $cell) {
                    $cellRef = $cell->getAttribute('r');
                    if ($cellRef === '') {
                        continue;
                    }

                    preg_match('/^([A-Z]+)(\d+)$/', $cellRef, $matches);
                    if (count($matches) < 3) {
                        continue;
                    }

                    $col = strtoupper($matches[1]);
                    $value = '';
                    $cellType = $cell->getAttribute('t');

                    $vNode = $cell->getElementsByTagNameNS($mainNamespace, 'v')->item(0);
                    if ($vNode !== null) {
                        $rawValue = $vNode->nodeValue;

                        if ($cellType === 's' && isset($sharedStrings[(int) $rawValue])) {
                            $value = $sharedStrings[(int) $rawValue];
                        } else {
                            $value = $rawValue;
                        }
                    }

                    $mapped[$col] = ['value' => $readCellValue($cell)];
                }

                if ($mapped !== []) {
                    $parsedRows[] = $mapped;
                }
            }
        }

        if (!empty($parsedRows)) {
            $headerRow = array_map(function (array $row): string {
                return strtolower(trim((string) ($row['A']['value'] ?? '')));
            }, [$parsedRows[0]])[0];

            $headerMatches = [
                'mfs number',
                'employee',
                'account',
                'address',
                'date fill-up',
                'date fillup'
            ];

            if (in_array($headerRow, $headerMatches, true)) {
                array_shift($parsedRows);
            }
        }

        $zip->close();

        return $parsedRows;
    }
}

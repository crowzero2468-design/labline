<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Pms extends BaseController
{

/**
 * ============================================================
 * VIEW MFS RECORD
 * ============================================================
 */
public function viewMfs($id)
{
    try {
        $db = \Config\Database::connect();

        $mfs = $db->table('tb_mfs m')
            ->select('m.*, r.file_location AS receipt_file, r.date_upload AS receipt_date')
            ->join('tb_receipt r', 'r.id = m.receipt', 'left')
            ->where('m.id', (int) $id)
            ->get()
            ->getRowArray();

        if (!$mfs) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success'   => false,
                    'message'   => 'MFS record not found. ID: ' . (int) $id,
                    'csrf_hash' => csrf_hash()
                ]);
        }

        return $this->response->setJSON([
            'success'   => true,
            'data'      => $mfs,
            'csrf_hash' => csrf_hash()
        ]);

    } catch (\Throwable $e) {

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success'   => false,
                'message'   => 'MFS database error: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
    }
}

/**
 * ============================================================
 * VIEW FSR RECORD
 * ============================================================
 */
public function viewFsr($id)
{
    try {
        $db = \Config\Database::connect();

        $fsr = $db->table('tb_fsr f')
            ->select('f.*, r.file_location AS receipt_file, r.date_upload AS receipt_date')
            ->join('tb_receipt r', 'r.id = f.receipt', 'left')
            ->where('f.id', (int) $id)
            ->get()
            ->getRowArray();

        if (!$fsr) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success'   => false,
                    'message'   => 'FSR record not found. ID: ' . (int) $id,
                    'csrf_hash' => csrf_hash()
                ]);
        }

        return $this->response->setJSON([
            'success'   => true,
            'data'      => $fsr,
            'csrf_hash' => csrf_hash()
        ]);

    } catch (\Throwable $e) {

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success'   => false,
                'message'   => 'FSR database error: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
    }
}

    /**
     * ============================================================
     * HELPER: CHECK IF REQUEST EXPECTS JSON
     * ============================================================
     */
    private function wantsJson(): bool
    {
        $accept = strtolower(
            (string) $this->request->getHeaderLine('Accept')
        );

        return $this->request->isAJAX()
            || str_contains($accept, 'application/json');
    }

    /**
     * ============================================================
     * HELPER: JSON SUCCESS RESPONSE
     * ============================================================
     */
    private function jsonSuccess(
        string $message,
        array $data = [],
        int $status = 200
    ) {
        return $this->response
            ->setStatusCode($status)
            ->setJSON(array_merge(
                [
                    'success'   => true,
                    'message'   => $message,
                    'csrf_hash' => csrf_hash(),
                ],
                $data
            ));
    }

    /**
     * ============================================================
     * HELPER: JSON ERROR RESPONSE
     * ============================================================
     */
    private function jsonError(
        string $message,
        int $status = 422
    ) {
        return $this->response
            ->setStatusCode($status)
            ->setJSON([
                'success'   => false,
                'message'   => $message,
                'csrf_hash' => csrf_hash(),
            ]);
    }

    /**
     * ============================================================
     * PMS INDEX
     * ============================================================
     */
    public function index(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        /*
        |--------------------------------------------------------------------------
        | USERS / SERVICE ENGINEERS
        |--------------------------------------------------------------------------
        */
        $users = [];

        if ($database->tableExists('tb_user')) {
            $users = $database
                ->table('tb_user')
                ->select('id,fname,lname,uname')
                ->orderBy('fname', 'ASC')
                ->get()
                ->getResultArray();
        }

        /*
        |--------------------------------------------------------------------------
        | ACCOUNTS / MACHINES
        |--------------------------------------------------------------------------
        */
        $accounts = [];

        if ($database->tableExists('tb_data')) {
            $accounts = $database
                ->table('tb_data')
                ->select('id,Clinic_name,Address,Machine,SN')
                ->orderBy('Clinic_name', 'ASC')
                ->where('status', 'A')
                ->get()
                ->getResultArray();
        }

        /*
        |--------------------------------------------------------------------------
        | PMS RECORDS
        |--------------------------------------------------------------------------
        */
        $pmsRecords = [];
        $techList = [];

        $selectedTech = trim(
            (string) ($this->request->getGet('tech') ?? '')
        );

        if ($database->tableExists('tb_pms')) {

            /*
            |--------------------------------------------------------------------------
            | MAKE SURE OPTIONAL COLUMNS EXIST
            |--------------------------------------------------------------------------
            */

            $pmsColumns = $database->getFieldNames('tb_pms');

            if (!in_array('mfs', $pmsColumns, true)) {
                $database->query("
                    ALTER TABLE tb_pms
                    ADD COLUMN mfs INT DEFAULT NULL
                ");
            }

            if (!in_array('fsr', $pmsColumns, true)) {
                $database->query("
                    ALTER TABLE tb_pms
                    ADD COLUMN fsr INT DEFAULT NULL
                ");
            }

            if (!in_array('receipt', $pmsColumns, true)) {
                $database->query("
                    ALTER TABLE tb_pms
                    ADD COLUMN receipt INT(11) DEFAULT NULL
                ");
            }

            /*
            |--------------------------------------------------------------------------
            | TECHNICIAN LIST
            |--------------------------------------------------------------------------
            */

            $techList = $database
                ->query("
                    SELECT
                        service_tech,
                        COUNT(*) AS total
                    FROM tb_pms
                    WHERE service_tech IS NOT NULL
                      AND service_tech != ''
                    GROUP BY service_tech
                    ORDER BY service_tech ASC
                ")
                ->getResultArray();

            /*
            |--------------------------------------------------------------------------
            | PMS RECORDS
            |--------------------------------------------------------------------------
            */

            $builder = $database
                ->table('tb_pms')
                ->select('
                    id,
                    pms_number,
                    service_tech,
                    clinic,
                    address,
                    sn,
                    date,
                    machine,
                    status,
                    receipt,
                    mfs,
                    fsr
                ');

            if ($selectedTech !== '') {
                $builder->where(
                    'service_tech',
                    $selectedTech
                );
            }

            $pmsRecords = $builder
                ->orderBy('date', 'DESC')
                ->orderBy('pms_number', 'DESC')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResultArray();
        }

        /*
        |--------------------------------------------------------------------------
        | NEXT PMS NUMBER
        |--------------------------------------------------------------------------
        */

        $nextPmsNumber = '000001';

        if ($database->tableExists('tb_pms')) {

            $row = $database
                ->query("
                    SELECT MAX(id) AS maxid
                    FROM tb_pms
                ")
                ->getRow();

            $maxId = (int) ($row->maxid ?? 0);

            $nextPmsNumber = str_pad(
                (string) ($maxId + 1),
                6,
                '0',
                STR_PAD_LEFT
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PENDING MODALS
        |--------------------------------------------------------------------------
        */

        $pendingMfs = session()->get('pending_mfs') ?? null;
        $pendingFsr = session()->get('pending_fsr') ?? null;

        if ($pendingMfs) {
            session()->remove('pending_mfs');
        }

        if ($pendingFsr) {
            session()->remove('pending_fsr');
        }

        return view('dashboard/pms', [
            'user'             => session()->get('user'),
            'users'            => $users,
            'accounts'         => $accounts,
            'pms_records'      => $pmsRecords,
            'tech_list'        => $techList,
            'selected_tech'    => $selectedTech,
            'next_pms_number'  => $nextPmsNumber,
            'pending_mfs'      => $pendingMfs,
            'pending_fsr'      => $pendingFsr,
        ]);
    }

    /**
     * ============================================================
     * EXPORT PMS
     * ============================================================
     */
    public function export()
    {
        if (!session()->get('logged_in')) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        if (!$database->tableExists('tb_pms')) {
            return redirect()
                ->back()
                ->with('error', 'No PMS data to export.');
        }

        $selectedTech = trim(
            (string) ($this->request->getGet('tech') ?? '')
        );

        $builder = $database
            ->table('tb_pms')
            ->select('
                pms_number,
                service_tech,
                clinic,
                address,
                sn,
                date,
                machine,
                status,
                mfs,
                fsr,
                receipt
            ');

        if ($selectedTech !== '') {

            $builder->where(
                'service_tech',
                $selectedTech
            );

            $safeTech = preg_replace(
                '/[^A-Za-z0-9_\-]/',
                '_',
                $selectedTech
            );

            $filename =
                'pms_' .
                $safeTech .
                '_' .
                date('Ymd_Hi') .
                '.csv';

        } else {

            $filename =
                'pms_all_' .
                date('Ymd_Hi') .
                '.csv';
        }

        $rows = $builder
            ->orderBy('date', 'DESC')
            ->orderBy('pms_number', 'DESC')
            ->get()
            ->getResultArray();

        /*
        |--------------------------------------------------------------------------
        | CSV HEADERS
        |--------------------------------------------------------------------------
        */

        header('Content-Type: text/csv; charset=utf-8');

        header(
            'Content-Disposition: attachment; filename="' .
            $filename .
            '"'
        );

        header('Pragma: no-cache');
        header('Expires: 0');

        /*
        |--------------------------------------------------------------------------
        | BOM FOR EXCEL
        |--------------------------------------------------------------------------
        */

        echo "\xEF\xBB\xBF";

        $out = fopen('php://output', 'w');

        fputcsv($out, [
            'PMS Number',
            'Service Tech',
            'Clinic',
            'Address',
            'SN',
            'Date',
            'Machine',
            'Technical Done',
            'MFS',
            'FSR',
            'Receipt'
        ]);

        foreach ($rows as $r) {

            $pmsVal = $r['pms_number'] ?? '';

            if (preg_match('/^\d+$/', $pmsVal)) {
                $pmsVal = str_pad(
                    $pmsVal,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }

            fputcsv($out, [
                $pmsVal,
                $r['service_tech'] ?? '',
                $r['clinic'] ?? '',
                $r['address'] ?? '',
                $r['sn'] ?? '',
                $r['date'] ?? '',
                $r['machine'] ?? '',
                $r['status'] ?? '',
                !empty($r['mfs'])
                    ? 'MFS #' . $r['mfs']
                    : 'No MFS',
                !empty($r['fsr'])
                    ? 'FSR #' . $r['fsr']
                    : 'No FSR',
                !empty($r['receipt'])
                    ? 'Uploaded'
                    : 'No Receipt'
            ]);
        }

        fclose($out);
        exit;
    }

    /**
     * ============================================================
     * SAVE PMS
     * ============================================================
     *
     * SUPPORTS MULTIPLE MACHINES.
     *
     * Example POST:
     *
     * machine_type[] = X-Ray
     * machine_type[] = Ultrasound
     *
     * technical_done[] = Preventive Maintenance
     * technical_done[] = Cleaning and Inspection
     *
     * Result:
     *
     * PMS 000123 | X-Ray       | Preventive Maintenance
     * PMS 000123 | Ultrasound  | Cleaning and Inspection
     *
     * Same PMS number.
     * Different PMS rows.
     * Different machine.
     * Different serial number.
     * Different technical done.
     */

/**
 * ============================================================
 * SAVE PMS
 * ============================================================
 *
 * IMPORTANT:
 * This method ONLY saves PMS records.
 *
 * It does NOT create MFS or FSR.
 *
 * MFS and FSR are created later by:
 *
 * save_mfs()
 * save_fsr()
 *
 * Their inserted IDs are then stored in:
 *
 * tb_pms.mfs
 * tb_pms.fsr
 *
 * ============================================================
 */
public function save()
{
    $db = db_connect();

    /*
     * ============================================================
     * GET BASIC PMS DATA
     * ============================================================
     */

    $pmsNumber = trim(
        (string) $this->request->getPost('pms_number')
    );

    $serviceEngId = trim(
        (string) $this->request->getPost('service_eng_id')
    );

    $dataId = trim(
        (string) $this->request->getPost('data_id')
    );

    $date = trim(
        (string) $this->request->getPost('date')
    );

    $address = trim(
        (string) $this->request->getPost('address')
    );

    /*
     * ============================================================
     * MFS / FSR CHECKBOXES
     *
     * These values are ONLY returned to JavaScript.
     *
     * They are NOT inserted into MFS/FSR here.
     * ============================================================
     */

    $createMfs = (
        $this->request->getPost('mfs') == '1'
    ) ? 1 : 0;

    $createFsr = (
        $this->request->getPost('fsr') == '1'
    ) ? 1 : 0;

    /*
     * ============================================================
     * GET MULTIPLE MACHINES
     * ============================================================
     */

    $machines = $this->request->getPost('machines');

    /*
     * ============================================================
     * VALIDATION
     * ============================================================
     */

    if ($pmsNumber === '') {
        return $this->jsonError(
            'PMS number is required.'
        );
    }

    if ($serviceEngId === '') {
        return $this->jsonError(
            'Please select a service engineer.'
        );
    }

    if ($dataId === '') {
        return $this->jsonError(
            'Please select an account.'
        );
    }

    if ($date === '') {
        return $this->jsonError(
            'Please select a date.'
        );
    }

    if (!is_array($machines) || empty($machines)) {
        return $this->jsonError(
            'Please select at least one machine.'
        );
    }

    /*
     * ============================================================
     * CHECK REQUIRED TABLES
     * ============================================================
     */

    if (!$db->tableExists('tb_pms')) {
        return $this->jsonError(
            'PMS table tb_pms does not exist.'
        );
    }

    if (!$db->tableExists('tb_data')) {
        return $this->jsonError(
            'Account table tb_data does not exist.'
        );
    }

    if (!$db->tableExists('tb_user')) {
        return $this->jsonError(
            'User table tb_user does not exist.'
        );
    }

    /*
     * ============================================================
     * GET ACCOUNT
     * ============================================================
     */

    $account = $db
        ->table('tb_data')
        ->where('id', $dataId)
        ->get()
        ->getRowArray();

    if (!$account) {
        return $this->jsonError(
            'Selected account was not found.'
        );
    }

    $clinic = trim(
        (string) ($account['Clinic_name'] ?? '')
    );

    /*
     * ============================================================
     * GET ADDRESS
     *
     * Database address has priority.
     * ============================================================
     */

    $accountAddress = trim(
        (string) ($account['Address'] ?? '')
    );

    if ($accountAddress !== '') {
        $address = $accountAddress;
    }

    /*
     * ============================================================
     * GET SERVICE ENGINEER
     * ============================================================
     */

    $engineer = $db
        ->table('tb_user')
        ->where('id', $serviceEngId)
        ->get()
        ->getRowArray();

    if (!$engineer) {
        return $this->jsonError(
            'Selected service engineer was not found.'
        );
    }

    $serviceTech = trim(
        ($engineer['fname'] ?? '') .
        ' ' .
        ($engineer['lname'] ?? '')
    );

    /*
     * ============================================================
     * VALIDATE MACHINE ROWS
     * ============================================================
     */

    $validMachines = [];

    foreach ($machines as $machineRow) {

        if (!is_array($machineRow)) {
            continue;
        }

        $machine = trim(
            (string) ($machineRow['machine'] ?? '')
        );

        $sn = trim(
            (string) ($machineRow['sn'] ?? '')
        );

        $technicalDone = trim(
            (string) ($machineRow['technical_done'] ?? '')
        );

        /*
         * Ignore completely empty rows.
         */

        if (
            $machine === '' &&
            $sn === '' &&
            $technicalDone === ''
        ) {
            continue;
        }

        /*
         * Machine required.
         */

        if ($machine === '') {
            return $this->jsonError(
                'Every machine row must have a machine selected.'
            );
        }

        /*
         * Technical Done required.
         */

        if ($technicalDone === '') {
            return $this->jsonError(
                'Please select Technical Done for machine: ' .
                $machine
            );
        }

        $validMachines[] = [
            'machine' => $machine,
            'sn' => $sn,
            'technical_done' => $technicalDone
        ];
    }

    if (empty($validMachines)) {
        return $this->jsonError(
            'Please select at least one machine.'
        );
    }

    /*
     * ============================================================
     * GET PMS COLUMNS
     * ============================================================
     */

    $pmsColumns = $db->getFieldNames('tb_pms');

    /*
     * ============================================================
     * RECEIPT
     *
     * tb_pms.receipt stores the ID of tb_receipt.
     * ============================================================
     */

    $receiptId = null;

    $receiptFile = $this->request->getFile('receipt');

    if (
        $receiptFile &&
        $receiptFile->getError() !== UPLOAD_ERR_NO_FILE
    ) {

        if (!$receiptFile->isValid()) {
            return $this->jsonError(
                'Invalid receipt upload.'
            );
        }

        /*
         * Maximum 5MB
         */

        if (
            $receiptFile->getSize() >
            5 * 1024 * 1024
        ) {
            return $this->jsonError(
                'Receipt file must not exceed 5MB.'
            );
        }

        /*
         * Allowed MIME types
         */

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'application/pdf'
        ];

        $mimeType = $receiptFile->getMimeType();

        if (
            !in_array(
                $mimeType,
                $allowedMimeTypes,
                true
            )
        ) {
            return $this->jsonError(
                'Invalid receipt file type. Allowed: JPG, JPEG, PNG, WEBP and PDF.'
            );
        }

        /*
         * Upload directory
         */

        $uploadPath =
            FCPATH . 'uploads/receipts';

        if (!is_dir($uploadPath)) {
            mkdir(
                $uploadPath,
                0777,
                true
            );
        }

        /*
         * Generate random name
         */

        $newName =
            $receiptFile->getRandomName();

        /*
         * Move file
         */

        if (
            !$receiptFile->move(
                $uploadPath,
                $newName
            )
        ) {
            return $this->jsonError(
                'Unable to upload receipt.'
            );
        }

        /*
         * Create receipt table if needed.
         */

        if (!$db->tableExists('tb_receipt')) {

            $db->query("
                CREATE TABLE IF NOT EXISTS tb_receipt (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    file_location VARCHAR(500) NOT NULL,
                    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
                ENGINE=InnoDB
                DEFAULT CHARSET=utf8mb4
            ");
        }

        $relativePath =
            'uploads/receipts/' . $newName;

        /*
         * Insert receipt information.
         */

        $receiptInserted = $db
            ->table('tb_receipt')
            ->insert([
                'file_location' => $relativePath
            ]);

        if (!$receiptInserted) {

            $uploadedPath =
                $uploadPath .
                DIRECTORY_SEPARATOR .
                $newName;

            if (is_file($uploadedPath)) {
                @unlink($uploadedPath);
            }

            return $this->jsonError(
                'Unable to save receipt information.'
            );
        }

        $receiptId =
            (int) $db->insertID();
    }

    /*
     * ============================================================
     * START TRANSACTION
     * ============================================================
     */

    $db->transStart();

    $insertedRows = [];

    /*
     * ============================================================
     * INSERT ONE PMS ROW PER MACHINE
     *
     * IMPORTANT:
     *
     * NO MFS INSERT HERE
     * NO FSR INSERT HERE
     *
     * ============================================================
     */

    foreach ($validMachines as $machineData) {

        $pmsData = [
            'pms_number' =>
                $pmsNumber,

            'service_tech' =>
                $serviceTech,

            'clinic' =>
                $clinic,

            'address' =>
                $address,

            'date' =>
                $date,

            'machine' =>
                $machineData['machine'],

            'sn' =>
                $machineData['sn'],

            'status' =>
                $machineData['technical_done']
        ];

        /*
         * Receipt
         */

        if (
            $receiptId !== null &&
            in_array(
                'receipt',
                $pmsColumns,
                true
            )
        ) {
            $pmsData['receipt'] =
                $receiptId;
        }

        /*
         * Data ID
         */

        if (
            in_array(
                'data_id',
                $pmsColumns,
                true
            )
        ) {
            $pmsData['data_id'] =
                $dataId;
        }

        /*
         * IMPORTANT:
         *
         * Do NOT set:
         *
         * mfs = 1
         * fsr = 1
         *
         * Those columns will later contain
         * the REAL MFS/FSR IDs.
         */

        /*
         * Insert PMS
         */

        $inserted = $db
            ->table('tb_pms')
            ->insert($pmsData);

        if (!$inserted) {

            $error = $db->error();

            $db->transRollback();

            /*
             * Remove uploaded receipt if PMS failed.
             */

            if ($receiptId !== null) {

                $receiptRecord = $db
                    ->table('tb_receipt')
                    ->where(
                        'id',
                        $receiptId
                    )
                    ->get()
                    ->getRowArray();

                if ($receiptRecord) {

                    $receiptPath =
                        FCPATH .
                        ltrim(
                            str_replace(
                                [
                                    '/',
                                    '\\'
                                ],
                                DIRECTORY_SEPARATOR,
                                $receiptRecord['file_location']
                            ),
                            DIRECTORY_SEPARATOR
                        );

                    if (is_file($receiptPath)) {
                        @unlink($receiptPath);
                    }
                }

                $db
                    ->table('tb_receipt')
                    ->where(
                        'id',
                        $receiptId
                    )
                    ->delete();
            }

            return $this->jsonError(
                'Failed to save PMS record for machine: ' .
                $machineData['machine'] .
                (
                    !empty($error['message'])
                        ? ' — ' . $error['message']
                        : ''
                ),
                500
            );
        }

        /*
         * Get PMS ID
         */

        $insertedId =
            (int) $db->insertID();

        /*
         * Add returned record.
         *
         * MFS and FSR are NULL for now.
         */

        $insertedRows[] = [
            'id' =>
                $insertedId,

            'pms_number' =>
                $pmsNumber,

            'service_tech' =>
                $serviceTech,

            'clinic' =>
                $clinic,

            'address' =>
                $address,

            'date' =>
                $date,

            'machine' =>
                $machineData['machine'],

            'sn' =>
                $machineData['sn'],

            'technical_done' =>
                $machineData['technical_done'],

            'mfs' =>
                null,

            'fsr' =>
                null
        ];
    }

    /*
     * ============================================================
     * COMPLETE TRANSACTION
     * ============================================================
     */

    $db->transComplete();

    if (
        $db->transStatus() === false ||
        empty($insertedRows)
    ) {
        return $this->jsonError(
            'PMS was not saved. Please check the database.',
            500
        );
    }

    /*
     * ============================================================
     * SUCCESS
     * ============================================================
     *
     * The JavaScript will use:
     *
     * records[0].id
     *
     * as pms_id when saving MFS/FSR.
     *
     * ============================================================
     */

    return $this->jsonSuccess(
        count($insertedRows) .
        ' PMS machine record(s) saved successfully.',
        [
            'pms' =>
                $insertedRows[0],

            'records' =>
                $insertedRows,

            'create_mfs' =>
                $createMfs,

            'create_fsr' =>
                $createFsr
        ]
    );
}

    /**
     * ============================================================
     * SAVE MFS MANUALLY / AJAX
     * ============================================================
     */
/**
 * ============================================================
 * SAVE MFS
 * ============================================================
 *
 * Creates ONE MFS record.
 *
 * Then saves the generated MFS ID into:
 *
 * tb_pms.mfs
 *
 * using:
 *
 * POST pms_id
 *
 * ============================================================
 */
public function save_mfs()
{
    $wantsJson = $this->wantsJson();

    /*
     * ============================================================
     * LOGIN CHECK
     * ============================================================
     */

    if (!session()->get('logged_in')) {

        if ($wantsJson) {
            return $this->jsonError(
                'Your session has expired. Please login again.',
                401
            );
        }

        return redirect()
            ->to(site_url('login'))
            ->with(
                'error',
                'Please login first.'
            );
    }

    $database = db_connect();

    /*
     * ============================================================
     * PMS ID
     *
     * This comes from JavaScript.
     * ============================================================
     */

    $pmsId = (int) (
        $this->request->getPost('pms_id') ?? 0
    );

    if ($pmsId <= 0) {

        if ($wantsJson) {
            return $this->jsonError(
                'PMS ID is required.',
                422
            );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'PMS ID is required.'
            );
    }

    /*
     * ============================================================
     * CHECK PMS TABLE
     * ============================================================
     */

    if (!$database->tableExists('tb_pms')) {

        if ($wantsJson) {
            return $this->jsonError(
                'PMS table does not exist.',
                500
            );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'PMS table does not exist.'
            );
    }

    /*
     * ============================================================
     * FIND PMS RECORD
     * ============================================================
     */

    $pmsRecord = $database
        ->table('tb_pms')
        ->where(
            'id',
            $pmsId
        )
        ->get()
        ->getRowArray();

    if (!$pmsRecord) {

        if ($wantsJson) {
            return $this->jsonError(
                'The selected PMS record was not found.',
                404
            );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'The selected PMS record was not found.'
            );
    }

    /*
     * ============================================================
     * CREATE MFS TABLE IF NEEDED
     * ============================================================
     */

    if (!$database->tableExists('tb_mfs')) {

        $database->query("
            CREATE TABLE IF NOT EXISTS tb_mfs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                mfs_number VARCHAR(255) DEFAULT NULL,
                employee VARCHAR(255) DEFAULT NULL,
                accounts VARCHAR(255) DEFAULT NULL,
                address VARCHAR(255) DEFAULT NULL,
                date_fillup DATE DEFAULT NULL,
                unit VARCHAR(255) DEFAULT NULL,
                machine VARCHAR(255) DEFAULT NULL,
                serial_number VARCHAR(255) DEFAULT NULL,
                consumable_unit VARCHAR(255) DEFAULT NULL,
                consumables VARCHAR(255) DEFAULT NULL,
                lot_number VARCHAR(255) DEFAULT NULL,
                remarks TEXT DEFAULT NULL,
                reason VARCHAR(255) DEFAULT NULL,
                date_status DATE DEFAULT NULL,
                personnel VARCHAR(255) DEFAULT NULL,
                acknowledged TINYINT(1) DEFAULT 0,
                returned INT DEFAULT 0,
                receipt INT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
        ");
    }

    /*
     * ============================================================
     * MAKE SURE RECEIPT COLUMN EXISTS
     * ============================================================
     */

    $mfsColumns =
        $database->getFieldNames('tb_mfs');

    if (
        !in_array(
            'receipt',
            $mfsColumns,
            true
        )
    ) {

        $database->query("
            ALTER TABLE tb_mfs
            ADD COLUMN receipt INT(11) DEFAULT NULL
        ");
    }

    /*
     * ============================================================
     * FORM VALUES
     * ============================================================
     */

    $mfsNumber = trim(
        (string) $this->request->getPost('mfs_number')
    );

    $employee = trim(
        (string) $this->request->getPost('employee')
    );

    $accounts = trim(
        (string) $this->request->getPost('accounts')
    );

    $address = trim(
        (string) $this->request->getPost('address')
    );

    $dateFill = trim(
        (string) $this->request->getPost('date_fillup')
    );

    $unit = trim(
        (string) $this->request->getPost('unit')
    );

    $machine = trim(
        (string) $this->request->getPost('machine')
    );

    $serial = trim(
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

    $remarks = trim(
        (string) $this->request->getPost('remarks')
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
        $this->request->getPost('acknowledged') ?? 0
    );

    $returned = (int) (
        $this->request->getPost('returned') ?? 0
    );

    /*
     * ============================================================
     * VALIDATION
     * ============================================================
     */

    if (
        $mfsNumber === '' ||
        $employee === '' ||
        $accounts === '' ||
        $machine === ''
    ) {

        $message =
            'Please fill required MFS fields: MFS Number, Employee, Account and Machine.';

        if ($wantsJson) {
            return $this->jsonError(
                $message,
                422
            );
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                $message
            );
    }

    /*
     * ============================================================
     * RECEIPT
     * ============================================================
     */

    $receiptId = null;

    $receiptFile =
        $this->request->getFile('receipt');

    if (
        $receiptFile &&
        $receiptFile->getError() !== UPLOAD_ERR_NO_FILE
    ) {

        if (!$receiptFile->isValid()) {

            $message =
                'Invalid receipt upload.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    422
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Maximum 5MB
         */

        if (
            $receiptFile->getSize() >
            5 * 1024 * 1024
        ) {

            $message =
                'Receipt file must not exceed 5MB.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    422
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Allowed types
         */

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'application/pdf'
        ];

        $mimeType =
            $receiptFile->getMimeType();

        if (
            !in_array(
                $mimeType,
                $allowedMimeTypes,
                true
            )
        ) {

            $message =
                'Invalid receipt file type. Allowed: JPG, JPEG, PNG, WEBP and PDF.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    422
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Upload directory
         */

        $uploadPath =
            FCPATH . 'uploads/receipts';

        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0777,
                true
            );
        }

        /*
         * Random filename
         */

        $newName =
            $receiptFile->getRandomName();

        /*
         * Move file
         */

        if (
            !$receiptFile->move(
                $uploadPath,
                $newName
            )
        ) {

            $message =
                'Unable to upload receipt.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    500
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Create receipt table if needed
         */

        if (
            !$database->tableExists(
                'tb_receipt'
            )
        ) {

            $database->query("
                CREATE TABLE IF NOT EXISTS tb_receipt (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    file_location VARCHAR(500) NOT NULL,
                    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
                ENGINE=InnoDB
                DEFAULT CHARSET=utf8mb4
            ");
        }

        $relativePath =
            'uploads/receipts/' .
            $newName;

        /*
         * Save receipt record
         */

        $receiptInserted =
            $database
                ->table('tb_receipt')
                ->insert([
                    'file_location' =>
                        $relativePath
                ]);

        if (!$receiptInserted) {

            $uploadedPath =
                $uploadPath .
                DIRECTORY_SEPARATOR .
                $newName;

            if (is_file($uploadedPath)) {
                @unlink($uploadedPath);
            }

            $message =
                'Unable to save receipt information.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    500
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        $receiptId =
            (int) $database->insertID();
    }

    /*
     * ============================================================
     * INSERT MFS
     * ============================================================
     */

    $insert = [

        'mfs_number' =>
            $mfsNumber,

        'employee' =>
            $employee,

        'accounts' =>
            $accounts,

        'address' =>
            $address,

        'date_fillup' =>
            $dateFill === ''
                ? date('Y-m-d')
                : $dateFill,

        'unit' =>
            $unit,

        'machine' =>
            $machine,

        'serial_number' =>
            $serial,

        'consumable_unit' =>
            $consumableUnit,

        'consumables' =>
            $consumables,

        'lot_number' =>
            $lotNumber,

        'remarks' =>
            $remarks,

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

        'receipt' =>
            $receiptId
    ];

    /*
     * ============================================================
     * SAVE MFS
     * ============================================================
     */

    $inserted =
        $database
            ->table('tb_mfs')
            ->insert($insert);

    if (!$inserted) {

        /*
         * Remove receipt if MFS failed.
         */

        if ($receiptId !== null) {

            $receiptRecord =
                $database
                    ->table('tb_receipt')
                    ->where(
                        'id',
                        $receiptId
                    )
                    ->get()
                    ->getRowArray();

            if ($receiptRecord) {

                $receiptPath =
                    FCPATH .
                    ltrim(
                        str_replace(
                            [
                                '/',
                                '\\'
                            ],
                            DIRECTORY_SEPARATOR,
                            $receiptRecord['file_location']
                        ),
                        DIRECTORY_SEPARATOR
                    );

                if (is_file($receiptPath)) {
                    @unlink($receiptPath);
                }
            }

            $database
                ->table('tb_receipt')
                ->where(
                    'id',
                    $receiptId
                )
                ->delete();
        }

        $message =
            'Failed to save MFS.';

        if ($wantsJson) {
            return $this->jsonError(
                $message,
                500
            );
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                $message
            );
    }

    /*
     * ============================================================
     * GET NEW MFS ID
     * ============================================================
     */

    $mfsId =
        (int) $database->insertID();

    /*
     * ============================================================
     * SAVE MFS ID INTO PMS
     *
     * tb_pms.mfs = tb_mfs.id
     * ============================================================
     */

    $pmsColumns =
        $database->getFieldNames('tb_pms');

    if (
        in_array(
            'mfs',
            $pmsColumns,
            true
        )
    ) {

        $updated =
            $database
                ->table('tb_pms')
                ->where(
                    'id',
                    $pmsId
                )
                ->update([
                    'mfs' => $mfsId
                ]);

        if (!$updated) {

            /*
             * MFS exists but relationship failed.
             */

            return $this->jsonError(
                'MFS was saved, but the MFS ID could not be linked to PMS.',
                500
            );
        }
    }

    /*
     * ============================================================
     * SUCCESS
     * ============================================================
     */

    if ($wantsJson) {

        return $this->jsonSuccess(
            'MFS saved successfully.',
            [

                'mfs_id' =>
                    $mfsId,

                'mfs_number' =>
                    $mfsNumber,

                'pms_id' =>
                    $pmsId,

                'receipt_id' =>
                    $receiptId
            ]
        );
    }

    return redirect()
        ->to(site_url('pms'))
        ->with(
            'success',
            'MFS saved successfully.'
        );
}

    /**
     * ============================================================
     * SAVE FSR MANUALLY / AJAX
     * ============================================================
     */
/**
 * ============================================================
 * SAVE FSR
 * ============================================================
 *
 * Creates ONE FSR record.
 *
 * Then saves the generated FSR ID into:
 *
 * tb_pms.fsr
 *
 * using:
 *
 * POST pms_id
 *
 * ============================================================
 */
public function save_fsr()
{
    $wantsJson = $this->wantsJson();

    /*
     * ============================================================
     * LOGIN CHECK
     * ============================================================
     */

    if (!session()->get('logged_in')) {

        if ($wantsJson) {
            return $this->jsonError(
                'Your session has expired. Please login again.',
                401
            );
        }

        return redirect()
            ->to(site_url('login'))
            ->with(
                'error',
                'Please login first.'
            );
    }

    $database = db_connect();

    /*
     * ============================================================
     * PMS ID
     * ============================================================
     */

    $pmsId = (int) (
        $this->request->getPost('pms_id') ?? 0
    );

    if ($pmsId <= 0) {

        if ($wantsJson) {
            return $this->jsonError(
                'PMS ID is required.',
                422
            );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'PMS ID is required.'
            );
    }

    /*
     * ============================================================
     * CHECK PMS TABLE
     * ============================================================
     */

    if (!$database->tableExists('tb_pms')) {

        if ($wantsJson) {
            return $this->jsonError(
                'PMS table does not exist.',
                500
            );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'PMS table does not exist.'
            );
    }

    /*
     * ============================================================
     * FIND PMS
     * ============================================================
     */

    $pmsRecord =
        $database
            ->table('tb_pms')
            ->where(
                'id',
                $pmsId
            )
            ->get()
            ->getRowArray();

    if (!$pmsRecord) {

        if ($wantsJson) {
            return $this->jsonError(
                'The selected PMS record was not found.',
                404
            );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'The selected PMS record was not found.'
            );
    }

    /*
     * ============================================================
     * CREATE FSR TABLE IF NEEDED
     * ============================================================
     */

    if (!$database->tableExists('tb_fsr')) {

        $database->query("
            CREATE TABLE IF NOT EXISTS tb_fsr (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fsr_number VARCHAR(255) DEFAULT NULL,
                service_engineer VARCHAR(255) DEFAULT NULL,
                account VARCHAR(255) DEFAULT NULL,
                address VARCHAR(255) DEFAULT NULL,
                date DATE DEFAULT NULL,
                machine VARCHAR(255) DEFAULT NULL,
                serial_number VARCHAR(255) DEFAULT NULL,
                technical_concern TEXT DEFAULT NULL,
                remarks TEXT DEFAULT NULL,
                action_made TEXT DEFAULT NULL,
                acknowledge TINYINT(1) DEFAULT 0,
                receipt INT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
        ");
    }

    /*
     * ============================================================
     * MAKE SURE RECEIPT COLUMN EXISTS
     * ============================================================
     */

    $fsrColumns =
        $database->getFieldNames('tb_fsr');

    if (
        !in_array(
            'receipt',
            $fsrColumns,
            true
        )
    ) {

        $database->query("
            ALTER TABLE tb_fsr
            ADD COLUMN receipt INT(11) DEFAULT NULL
        ");
    }

    /*
     * ============================================================
     * FORM VALUES
     * ============================================================
     */

    $fsrNumber = trim(
        (string) $this->request->getPost('fsr_number')
    );

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

    $serial = trim(
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

    $acknowledge = (int) (
        $this->request->getPost('acknowledge') ?? 0
    );

    /*
     * ============================================================
     * VALIDATION
     * ============================================================
     */

    if (
        $fsrNumber === '' ||
        $serviceEngineer === '' ||
        $account === '' ||
        $machine === ''
    ) {

        $message =
            'Please fill required FSR fields: FSR Number, Service Engineer, Account and Machine.';

        if ($wantsJson) {
            return $this->jsonError(
                $message,
                422
            );
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                $message
            );
    }

    /*
     * ============================================================
     * RECEIPT
     * ============================================================
     */

    $receiptId = null;

    $receiptFile =
        $this->request->getFile('receipt');

    if (
        $receiptFile &&
        $receiptFile->getError() !== UPLOAD_ERR_NO_FILE
    ) {

        if (!$receiptFile->isValid()) {

            $message =
                'Invalid receipt upload.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    422
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Maximum 5MB
         */

        if (
            $receiptFile->getSize() >
            5 * 1024 * 1024
        ) {

            $message =
                'Receipt file must not exceed 5MB.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    422
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Allowed MIME types
         */

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'application/pdf'
        ];

        $mimeType =
            $receiptFile->getMimeType();

        if (
            !in_array(
                $mimeType,
                $allowedMimeTypes,
                true
            )
        ) {

            $message =
                'Invalid receipt file type. Allowed: JPG, JPEG, PNG, WEBP and PDF.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    422
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Upload directory
         */

        $uploadPath =
            FCPATH . 'uploads/receipts';

        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0777,
                true
            );
        }

        /*
         * Random file name
         */

        $newName =
            $receiptFile->getRandomName();

        /*
         * Move file
         */

        if (
            !$receiptFile->move(
                $uploadPath,
                $newName
            )
        ) {

            $message =
                'Unable to upload receipt.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    500
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        /*
         * Create receipt table if needed
         */

        if (
            !$database->tableExists(
                'tb_receipt'
            )
        ) {

            $database->query("
                CREATE TABLE IF NOT EXISTS tb_receipt (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    file_location VARCHAR(500) NOT NULL,
                    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
                ENGINE=InnoDB
                DEFAULT CHARSET=utf8mb4
            ");
        }

        $relativePath =
            'uploads/receipts/' .
            $newName;

        /*
         * Save receipt information
         */

        $receiptInserted =
            $database
                ->table('tb_receipt')
                ->insert([
                    'file_location' =>
                        $relativePath
                ]);

        if (!$receiptInserted) {

            $uploadedPath =
                $uploadPath .
                DIRECTORY_SEPARATOR .
                $newName;

            if (is_file($uploadedPath)) {
                @unlink($uploadedPath);
            }

            $message =
                'Unable to save receipt information.';

            if ($wantsJson) {
                return $this->jsonError(
                    $message,
                    500
                );
            }

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $message
                );
        }

        $receiptId =
            (int) $database->insertID();
    }

    /*
     * ============================================================
     * INSERT FSR
     * ============================================================
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
                ? date('Y-m-d')
                : $date,

        'machine' =>
            $machine,

        'serial_number' =>
            $serial,

        'technical_concern' =>
            $technicalConcern,

        'remarks' =>
            $remarks,

        'action_made' =>
            $actionMade,

        'acknowledge' =>
            $acknowledge,

        'receipt' =>
            $receiptId
    ];

    /*
     * ============================================================
     * SAVE FSR
     * ============================================================
     */

    $inserted =
        $database
            ->table('tb_fsr')
            ->insert($insert);

    if (!$inserted) {

        /*
         * Remove receipt if FSR failed.
         */

        if ($receiptId !== null) {

            $receiptRecord =
                $database
                    ->table('tb_receipt')
                    ->where(
                        'id',
                        $receiptId
                    )
                    ->get()
                    ->getRowArray();

            if ($receiptRecord) {

                $receiptPath =
                    FCPATH .
                    ltrim(
                        str_replace(
                            [
                                '/',
                                '\\'
                            ],
                            DIRECTORY_SEPARATOR,
                            $receiptRecord['file_location']
                        ),
                        DIRECTORY_SEPARATOR
                    );

                if (is_file($receiptPath)) {
                    @unlink($receiptPath);
                }
            }

            $database
                ->table('tb_receipt')
                ->where(
                    'id',
                    $receiptId
                )
                ->delete();
        }

        $message =
            'Failed to save FSR.';

        if ($wantsJson) {
            return $this->jsonError(
                $message,
                500
            );
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                $message
            );
    }

    /*
     * ============================================================
     * GET NEW FSR ID
     * ============================================================
     */

    $fsrId =
        (int) $database->insertID();

    /*
     * ============================================================
     * SAVE FSR ID INTO PMS
     *
     * tb_pms.fsr = tb_fsr.id
     * ============================================================
     */

    $pmsColumns =
        $database->getFieldNames('tb_pms');

    if (
        in_array(
            'fsr',
            $pmsColumns,
            true
        )
    ) {

        $updated =
            $database
                ->table('tb_pms')
                ->where(
                    'id',
                    $pmsId
                )
                ->update([
                    'fsr' => $fsrId
                ]);

        if (!$updated) {

            return $this->jsonError(
                'FSR was saved, but the FSR ID could not be linked to PMS.',
                500
            );
        }
    }

    /*
     * ============================================================
     * SUCCESS
     * ============================================================
     */

    if ($wantsJson) {

        return $this->jsonSuccess(
            'FSR saved successfully.',
            [

                'fsr_id' =>
                    $fsrId,

                'fsr_number' =>
                    $fsrNumber,

                'pms_id' =>
                    $pmsId,

                'receipt_id' =>
                    $receiptId
            ]
        );
    }

    return redirect()
        ->to(site_url('pms'))
        ->with(
            'success',
            'FSR saved successfully.'
        );
}

    /**
     * ============================================================
     * UPLOAD RECEIPT FOR EXISTING PMS
     * ============================================================
     */
    public function uploadReceipt($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $db = db_connect();
        $pmsId = (int) $id;
        $pms = $db->table('tb_pms')->where('id', $pmsId)->get()->getRowArray();

        if (!$pms) {
            return redirect()->back()->with('error', 'PMS record not found.');
        }

        if (!empty($pms['receipt'])) {
            return redirect()->back()->with('error', 'This PMS record already has a receipt.');
        }

        $file = $this->request->getFile('receipt');
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'application/pdf'
        ];

        if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please select a valid receipt file.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Receipt file must not exceed 5MB.');
        }

        if (!in_array($file->getMimeType(), $allowedMimeTypes, true)) {
            return redirect()->back()->with('error', 'Invalid receipt file type. Allowed: JPG, JPEG, PNG, WEBP and PDF.');
        }

        $uploadPath = FCPATH . 'uploads/receipts';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $newName = $file->getRandomName();

        if (!$file->move($uploadPath, $newName)) {
            return redirect()->back()->with('error', 'Unable to upload receipt.');
        }

        if (!$db->tableExists('tb_receipt')) {
            $db->query("CREATE TABLE IF NOT EXISTS tb_receipt (
                id INT AUTO_INCREMENT PRIMARY KEY,
                file_location VARCHAR(500) NOT NULL,
                date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        }

        $relativePath = 'uploads/receipts/' . $newName;
        $inserted = $db->table('tb_receipt')->insert([
            'file_location' => $relativePath
        ]);

        if (!$inserted) {
            @unlink($uploadPath . DIRECTORY_SEPARATOR . $newName);
            return redirect()->back()->with('error', 'Unable to save receipt information.');
        }

        $receiptId = (int) $db->insertID();
        $updated = $db->table('tb_pms')->where('id', $pmsId)->update([
            'receipt' => $receiptId
        ]);

        if (!$updated) {
            @unlink($uploadPath . DIRECTORY_SEPARATOR . $newName);
            $db->table('tb_receipt')->where('id', $receiptId)->delete();
            return redirect()->back()->with('error', 'Receipt uploaded but could not be connected to PMS.');
        }

        return redirect()->back()->with('success', 'Receipt uploaded and connected to PMS.');
    }

    /**
     * ============================================================
     * SERVE RECEIPT IMAGE
     * ============================================================
     *
     * URL:
     *
     * /pms/receipt/{receipt_id}
     *
     */
    public function receipt($id)
    {
        if (!session()->get('logged_in')) {

            return $this->response
                ->setStatusCode(403)
                ->setBody('Unauthorized');
        }

        $db = db_connect();

        if (!$db->tableExists('tb_receipt')) {

            return $this->response
                ->setStatusCode(404)
                ->setBody(
                    'Receipt table not found.'
                );
        }

        $receipt = $db
            ->table('tb_receipt')
            ->where(
                'id',
                (int) $id
            )
            ->get()
            ->getRowArray();

        if (!$receipt) {

            return $this->response
                ->setStatusCode(404)
                ->setBody(
                    'Receipt record not found.'
                );
        }

        $relativePath = trim(
            (string) (
                $receipt['file_location'] ?? ''
            )
        );

        if ($relativePath === '') {

            return $this->response
                ->setStatusCode(404)
                ->setBody(
                    'Receipt file path is empty.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALIZE PATH
        |--------------------------------------------------------------------------
        */

        $relativePath = str_replace(
            ['/', '\\'],
            DIRECTORY_SEPARATOR,
            $relativePath
        );

        $relativePath = ltrim(
            $relativePath,
            DIRECTORY_SEPARATOR
        );

        /*
        |--------------------------------------------------------------------------
        | BUILD SERVER PATH
        |--------------------------------------------------------------------------
        */

        $filePath =
            FCPATH . $relativePath;

        if (!is_file($filePath)) {

            return $this->response
                ->setStatusCode(404)
                ->setBody(
                    'Receipt file not found: ' .
                    $relativePath
                );
        }

        /*
        |--------------------------------------------------------------------------
        | DETECT MIME TYPE
        |--------------------------------------------------------------------------
        */

        $mimeType =
            mime_content_type($filePath);

        $allowedMimeTypes = [

            'image/jpeg',

            'image/png',

            'image/webp',

            'application/pdf'
        ];

        if (
            !in_array(
                $mimeType,
                $allowedMimeTypes,
                true
            )
        ) {

            return $this->response
                ->setStatusCode(403)
                ->setBody(
                    'Invalid receipt file type.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | OUTPUT IMAGE
        |--------------------------------------------------------------------------
        */

        return $this->response

            ->setHeader(
                'Content-Type',
                $mimeType
            )

            ->setHeader(
                'Content-Length',
                (string) filesize($filePath)
            )

            ->setHeader(
                'Content-Disposition',
                'inline; filename="' .
                basename($filePath) .
                '"'
            )

            ->setBody(
                file_get_contents($filePath)
            );
    }


/**
 * ============================================================
 * EDIT PMS
 * ============================================================
 *
 * Returns one PMS record as JSON.
 *
 * GET:
 *     /pms/edit/{id}
 *
 * ============================================================
 */
public function edit($id)
{
    if (!session()->get('logged_in')) {

        return $this->jsonError(
            'Your session has expired. Please login again.',
            401
        );
    }

    $db = db_connect();

    $id = (int) $id;

    if ($id <= 0) {

        return $this->jsonError(
            'Invalid PMS ID.',
            422
        );
    }

    /*
     * ========================================================
     * CHECK PMS TABLE
     * ========================================================
     */

    if (!$db->tableExists('tb_pms')) {

        return $this->jsonError(
            'PMS table does not exist.',
            500
        );
    }

    /*
     * ========================================================
     * GET PMS RECORD
     * ========================================================
     */

    $pms = $db
        ->table('tb_pms')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$pms) {

        return $this->jsonError(
            'PMS record not found.',
            404
        );
    }

    /*
     * ========================================================
     * CHECK PMS COLUMNS
     * ========================================================
     */

    $pmsColumns = $db->getFieldNames('tb_pms');

    /*
     * ========================================================
     * FIND ACCOUNT ID
     * ========================================================
     *
     * If tb_pms has data_id, use it.
     *
     * Otherwise find the active tb_data record using
     * the stored clinic name.
     * ========================================================
     */

    $dataId = 0;

    if (
        in_array('data_id', $pmsColumns, true) &&
        !empty($pms['data_id'])
    ) {

        $dataId = (int) $pms['data_id'];
    }

    if (
        $dataId <= 0 &&
        $db->tableExists('tb_data')
    ) {

        $clinicName = trim(
            (string) ($pms['clinic'] ?? '')
        );

        if ($clinicName !== '') {

            $accountQuery = $db
                ->table('tb_data')
                ->select('id')
                ->where('Clinic_name', $clinicName)
                ->where('status', 'A')
                ->orderBy('id', 'ASC')
                ->limit(1)
                ->get()
                ->getRowArray();

            if ($accountQuery) {

                $dataId = (int) $accountQuery['id'];
            }
        }
    }

    /*
     * ========================================================
     * FIND SERVICE ENGINEER ID
     * ========================================================
     *
     * tb_pms stores the engineer name.
     *
     * tb_user stores:
     *     id
     *     fname
     *     lname
     * ========================================================
     */

    $serviceEngId = 0;

    $engineerName = trim(
        (string) ($pms['service_tech'] ?? '')
    );

    if (
        $engineerName !== '' &&
        $db->tableExists('tb_user')
    ) {

        $users = $db
            ->table('tb_user')
            ->select('id,fname,lname')
            ->get()
            ->getResultArray();

        foreach ($users as $user) {

            $fullName = trim(
                ($user['fname'] ?? '') .
                ' ' .
                ($user['lname'] ?? '')
            );

            if (
                strcasecmp(
                    $fullName,
                    $engineerName
                ) === 0
            ) {

                $serviceEngId = (int) $user['id'];

                break;
            }
        }
    }

    /*
     * ========================================================
     * GET MFS
     * ========================================================
     */

    $mfs = null;

    if (
        !empty($pms['mfs']) &&
        $db->tableExists('tb_mfs')
    ) {

        $mfs = $db
            ->table('tb_mfs')
            ->select('id,mfs_number')
            ->where(
                'id',
                (int) $pms['mfs']
            )
            ->get()
            ->getRowArray();
    }

    /*
     * ========================================================
     * GET FSR
     * ========================================================
     */

    $fsr = null;

    if (
        !empty($pms['fsr']) &&
        $db->tableExists('tb_fsr')
    ) {

        $fsr = $db
            ->table('tb_fsr')
            ->select('id,fsr_number')
            ->where(
                'id',
                (int) $pms['fsr']
            )
            ->get()
            ->getRowArray();
    }

    $mfsOptions = [];

    if ($db->tableExists('tb_mfs')) {
        $mfsOptions = $db
            ->table('tb_mfs')
            ->select('id,mfs_number')
            ->where('mfs_number IS NOT NULL', null, false)
            ->where('mfs_number !=', '')
            ->orderBy('mfs_number', 'ASC')
            ->get()
            ->getResultArray();
    }

    $fsrOptions = [];

    if ($db->tableExists('tb_fsr')) {
        $fsrOptions = $db
            ->table('tb_fsr')
            ->select('id,fsr_number')
            ->where('fsr_number IS NOT NULL', null, false)
            ->where('fsr_number !=', '')
            ->orderBy('fsr_number', 'ASC')
            ->get()
            ->getResultArray();
    }

    /*
     * ========================================================
     * GET RECEIPT
     * ========================================================
     */

    $receipt = null;

    if (
        !empty($pms['receipt']) &&
        $db->tableExists('tb_receipt')
    ) {

        $receipt = $db
            ->table('tb_receipt')
            ->select(
                'id,file_location,date_upload'
            )
            ->where(
                'id',
                (int) $pms['receipt']
            )
            ->get()
            ->getRowArray();
    }

    /*
     * ========================================================
     * RETURN JSON
     * ========================================================
     */

    return $this->jsonSuccess(
        'PMS record loaded successfully.',
        [
            'data' => [

                'id' =>
                    (int) ($pms['id'] ?? 0),

                'pms_number' =>
                    (string) ($pms['pms_number'] ?? ''),

                'service_tech' =>
                    (string) ($pms['service_tech'] ?? ''),

                'service_eng_id' =>
                    $serviceEngId,

                'data_id' =>
                    $dataId,

                'clinic' =>
                    (string) ($pms['clinic'] ?? ''),

                'address' =>
                    (string) ($pms['address'] ?? ''),

                'date' =>
                    (string) ($pms['date'] ?? ''),

                'machine' =>
                    (string) ($pms['machine'] ?? ''),

                'sn' =>
                    (string) ($pms['sn'] ?? ''),

                'status' =>
                    (string) ($pms['status'] ?? ''),

                'mfs' =>
                    $mfs,

                'fsr' =>
                    $fsr,

                'mfs_options' =>
                    $mfsOptions,

                'fsr_options' =>
                    $fsrOptions,

                'receipt' =>
                    $receipt
            ]
        ]
    );
}


/**
 * ============================================================
 * UPDATE PMS
 * ============================================================
 *
 * Updates ONE PMS machine record.
 *
 * IMPORTANT:
 *
 * Existing:
 *     MFS
 *     FSR
 *     Receipt
 *
 * are NOT changed.
 *
 * ============================================================
 */
public function update($id)
{
    $wantsJson = $this->wantsJson();

    /*
     * ========================================================
     * LOGIN CHECK
     * ========================================================
     */

    if (!session()->get('logged_in')) {

        if ($wantsJson) {

            return $this->jsonError(
                'Your session has expired. Please login again.',
                401
            );
        }

        return redirect()
            ->to(site_url('login'))
            ->with(
                'error',
                'Please login first.'
            );
    }

    $db = db_connect();

    $id = (int) $id;

    /*
     * ========================================================
     * VALIDATE ID
     * ========================================================
     */

    if ($id <= 0) {

        return $this->jsonError(
            'Invalid PMS ID.',
            422
        );
    }

    /*
     * ========================================================
     * CHECK TABLE
     * ========================================================
     */

    if (!$db->tableExists('tb_pms')) {

        return $this->jsonError(
            'PMS table does not exist.',
            500
        );
    }

    /*
     * ========================================================
     * GET EXISTING PMS RECORD
     * ========================================================
     */

    $pms = $db
        ->table('tb_pms')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$pms) {

        return $this->jsonError(
            'PMS record not found.',
            404
        );
    }

    /*
     * ========================================================
     * GET FORM VALUES
     * ========================================================
     */

    $pmsNumber = trim(
        (string) $this->request->getPost('pms_number')
    );

    $serviceEngId = (int) (
        $this->request->getPost('service_eng_id') ?? 0
    );

    $dataId = (int) (
        $this->request->getPost('data_id') ?? 0
    );

    $date = trim(
        (string) $this->request->getPost('date')
    );

    $address = trim(
        (string) $this->request->getPost('address')
    );

    $machine = trim(
        (string) $this->request->getPost('machine')
    );

    $sn = trim(
        (string) $this->request->getPost('sn')
    );

    $status = trim(
        (string) $this->request->getPost('status')
    );

    $mfsId = (int) ($this->request->getPost('mfs_id') ?? 0);
    $fsrId = (int) ($this->request->getPost('fsr_id') ?? 0);

    /*
     * ========================================================
     * VALIDATION
     * ========================================================
     */

    if ($pmsNumber === '') {

        return $this->jsonError(
            'PMS number is required.',
            422
        );
    }

    if ($serviceEngId <= 0) {

        return $this->jsonError(
            'Please select a service engineer.',
            422
        );
    }

    if ($dataId <= 0) {

        return $this->jsonError(
            'Please select an account.',
            422
        );
    }

    if ($date === '') {

        return $this->jsonError(
            'Please select a date.',
            422
        );
    }

    if ($machine === '') {

        return $this->jsonError(
            'Machine is required.',
            422
        );
    }

    if ($status === '') {

        return $this->jsonError(
            'Please select Technical Done.',
            422
        );
    }

    /*
     * ========================================================
     * GET ACCOUNT
     * ========================================================
     */

    if (!$db->tableExists('tb_data')) {

        return $this->jsonError(
            'Account table does not exist.',
            500
        );
    }

    $account = $db
        ->table('tb_data')
        ->where('id', $dataId)
        ->get()
        ->getRowArray();

    if (!$account) {

        return $this->jsonError(
            'Selected account was not found.',
            404
        );
    }

    /*
     * ========================================================
     * CLINIC
     * ========================================================
     */

    $clinic = trim(
        (string) ($account['Clinic_name'] ?? '')
    );

    if ($clinic === '') {

        return $this->jsonError(
            'Selected account has no clinic name.',
            422
        );
    }

    /*
     * ========================================================
     * ADDRESS
     * ========================================================
     *
     * Address from tb_data has priority.
     * ========================================================
     */

    $accountAddress = trim(
        (string) ($account['Address'] ?? '')
    );

    if ($accountAddress !== '') {

        $address = $accountAddress;
    }

    /*
     * ========================================================
     * GET SERVICE ENGINEER
     * ========================================================
     */

    if (!$db->tableExists('tb_user')) {

        return $this->jsonError(
            'User table does not exist.',
            500
        );
    }

    $engineer = $db
        ->table('tb_user')
        ->where('id', $serviceEngId)
        ->get()
        ->getRowArray();

    if (!$engineer) {

        return $this->jsonError(
            'Selected service engineer was not found.',
            404
        );
    }

    $serviceTech = trim(
        ($engineer['fname'] ?? '') .
        ' ' .
        ($engineer['lname'] ?? '')
    );

    if ($serviceTech === '') {

        return $this->jsonError(
            'Selected service engineer has no name.',
            422
        );
    }

    /*
     * ========================================================
     * PREPARE UPDATE DATA
     * ========================================================
     *
    * MFS, FSR, and receipt are included below when the edit form
    * supplies replacement links or a replacement file.
     * ========================================================
     */

    $pmsColumns = $db->getFieldNames('tb_pms');

    $updateData = [

        'pms_number' =>
            $pmsNumber,

        'service_tech' =>
            $serviceTech,

        'clinic' =>
            $clinic,

        'address' =>
            $address,

        'date' =>
            $date,

        'machine' =>
            $machine,

        'sn' =>
            $sn,

        'status' =>
            $status
    ];

    if (in_array('mfs', $pmsColumns, true)) {
        if ($mfsId > 0 && (!$db->tableExists('tb_mfs') || !$db->table('tb_mfs')->where('id', $mfsId)->countAllResults())) {
            return $this->jsonError('Selected MFS record was not found.', 404);
        }

        $updateData['mfs'] = $mfsId > 0 ? $mfsId : null;
    }

    if (in_array('fsr', $pmsColumns, true)) {
        if ($fsrId > 0 && (!$db->tableExists('tb_fsr') || !$db->table('tb_fsr')->where('id', $fsrId)->countAllResults())) {
            return $this->jsonError('Selected FSR record was not found.', 404);
        }

        $updateData['fsr'] = $fsrId > 0 ? $fsrId : null;
    }

    $replacementReceipt = $this->request->getFile('receipt');

    if ($replacementReceipt && $replacementReceipt->getError() !== UPLOAD_ERR_NO_FILE) {
        $allowedReceiptTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'application/pdf'
        ];

        if (!$replacementReceipt->isValid()) {
            return $this->jsonError('Invalid receipt upload.', 422);
        }

        if ($replacementReceipt->getSize() > 5 * 1024 * 1024) {
            return $this->jsonError('Receipt file must not exceed 5MB.', 422);
        }

        if (!in_array($replacementReceipt->getMimeType(), $allowedReceiptTypes, true)) {
            return $this->jsonError('Invalid receipt file type. Allowed: JPG, JPEG, PNG, WEBP and PDF.', 422);
        }

        $receiptPath = FCPATH . 'uploads/receipts';

        if (!is_dir($receiptPath)) {
            mkdir($receiptPath, 0777, true);
        }

        $receiptName = $replacementReceipt->getRandomName();

        if (!$replacementReceipt->move($receiptPath, $receiptName)) {
            return $this->jsonError('Unable to upload replacement receipt.', 500);
        }

        if (!$db->tableExists('tb_receipt')) {
            $db->query("CREATE TABLE IF NOT EXISTS tb_receipt (
                id INT AUTO_INCREMENT PRIMARY KEY,
                file_location VARCHAR(500) NOT NULL,
                date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        }

        $receiptInserted = $db->table('tb_receipt')->insert([
            'file_location' => 'uploads/receipts/' . $receiptName
        ]);

        if (!$receiptInserted) {
            @unlink($receiptPath . DIRECTORY_SEPARATOR . $receiptName);
            return $this->jsonError('Unable to save replacement receipt information.', 500);
        }

        $updateData['receipt'] = (int) $db->insertID();
    }

    /*
     * ========================================================
     * SAVE data_id IF COLUMN EXISTS
     * ========================================================
     */

    if (
        in_array(
            'data_id',
            $pmsColumns,
            true
        )
    ) {

        $updateData['data_id'] = $dataId;
    }

    /*
     * ========================================================
     * UPDATE DATABASE
     * ========================================================
     */

    $builder = $db
        ->table('tb_pms')
        ->where('id', $id);

    $updated = $builder->update($updateData);

    /*
     * ========================================================
     * CHECK DATABASE RESULT
     * ========================================================
     */

    if (!$updated) {

        $error = $db->error();

        $message = 'Failed to update PMS record.';

        if (!empty($error['message'])) {

            $message .=
                ' — ' .
                $error['message'];
        }

        return $this->jsonError(
            $message,
            500
        );
    }

    /*
     * ========================================================
     * JSON RESPONSE
     * ========================================================
     */

    if ($wantsJson) {

        return $this->jsonSuccess(
            'PMS record updated successfully.',
            [
                'id' => $id
            ]
        );
    }

    /*
     * ========================================================
     * NORMAL FORM SUBMISSION
     * ========================================================
     */

    return redirect()
        ->to(site_url('pms'))
        ->with(
            'success',
            'PMS record updated successfully.'
        );
}


/**
 * ============================================================
 * DELETE PMS
 * ============================================================
 *
 * Deletes ONLY the selected PMS record.
 *
 * IMPORTANT:
 *
 * The following are NOT deleted:
 *
 *     tb_mfs
 *     tb_fsr
 *     tb_receipt
 *
 * This prevents accidental deletion of documents/history.
 *
 * ============================================================
 */
public function delete($id)
{
    $wantsJson = $this->wantsJson();

    /*
     * ========================================================
     * LOGIN CHECK
     * ========================================================
     */

    if (!session()->get('logged_in')) {

        if ($wantsJson) {

            return $this->jsonError(
                'Your session has expired. Please login again.',
                401
            );
        }

        return redirect()
            ->to(site_url('login'))
            ->with(
                'error',
                'Please login first.'
            );
    }

    $db = db_connect();

    $id = (int) $id;

    /*
     * ========================================================
     * VALIDATE ID
     * ========================================================
     */

    if ($id <= 0) {

        return $this->jsonError(
            'Invalid PMS ID.',
            422
        );
    }

    /*
     * ========================================================
     * CHECK TABLE
     * ========================================================
     */

    if (!$db->tableExists('tb_pms')) {

        return $this->jsonError(
            'PMS table does not exist.',
            500
        );
    }

    /*
     * ========================================================
     * CHECK RECORD
     * ========================================================
     */

    $pms = $db
        ->table('tb_pms')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$pms) {

        return $this->jsonError(
            'PMS record not found.',
            404
        );
    }

    /*
     * ========================================================
     * DELETE ONLY PMS RECORD
     * ========================================================
     */

    $deleted = $db
        ->table('tb_pms')
        ->where('id', $id)
        ->delete();

    /*
     * ========================================================
     * CHECK DELETE RESULT
     * ========================================================
     */

    if (!$deleted) {

        $error = $db->error();

        $message = 'Failed to delete PMS record.';

        if (!empty($error['message'])) {

            $message .=
                ' — ' .
                $error['message'];
        }

        return $this->jsonError(
            $message,
            500
        );
    }

    /*
     * ========================================================
     * SUCCESS
     * ========================================================
     */

    if ($wantsJson) {

        return $this->jsonSuccess(
            'PMS record deleted successfully.',
            [
                'id' => $id
            ]
        );
    }

    return redirect()
        ->to(site_url('pms'))
        ->with(
            'success',
            'PMS record deleted successfully.'
        );
}


// ==============================================================
// IMPORT EXCEL
// ==============================================================

public function importExcel(): RedirectResponse
{
    // ----------------------------------------------------------
    // LOGIN CHECK
    // ----------------------------------------------------------
    if (!session()->get('logged_in')) {
        return redirect()
            ->to(site_url('login'))
            ->with(
                'error',
                'Please login first.'
            );
    }

    // ----------------------------------------------------------
    // GET UPLOADED FILE
    // ----------------------------------------------------------
    $file = $this->request->getFile('excel_file');

    if ($file === null || !$file->isValid()) {
        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'Please choose an Excel file to import.'
            );
    }

    // ----------------------------------------------------------
    // CHECK UPLOAD ERROR
    // ----------------------------------------------------------
    if ($file->getError() !== UPLOAD_ERR_OK) {
        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'Excel upload failed. Upload error code: ' .
                $file->getError()
            );
    }

    // ----------------------------------------------------------
    // ALLOWED EXTENSIONS
    // ----------------------------------------------------------
    $allowedExtensions = [
        'xlsx',
        'csv'
    ];

    $extension = strtolower(
        $file->getExtension()
    );

    if (!in_array(
        $extension,
        $allowedExtensions,
        true
    )) {
        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'Only .xlsx and .csv files are allowed.'
            );
    }

    // ----------------------------------------------------------
    // CHECK FILE SIZE
    // ----------------------------------------------------------
    if ($file->getSize() <= 0) {
        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'The uploaded Excel file is empty.'
            );
    }

    // ----------------------------------------------------------
    // CREATE TEMP DIRECTORY
    // ----------------------------------------------------------
    $targetDir = WRITEPATH . 'upload';

    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            return redirect()
                ->to(site_url('pms'))
                ->with(
                    'error',
                    'Unable to create temporary upload directory.'
                );
        }
    }

    // ----------------------------------------------------------
    // CREATE UNIQUE FILE NAME
    // ----------------------------------------------------------
    try {
        $randomName = bin2hex(
            random_bytes(8)
        );
    } catch (\Throwable $e) {
        $randomName = uniqid('', true);
    }

    $fileName =
        'pms_import_' .
        date('Ymd_His') .
        '_' .
        $randomName .
        '.' .
        $extension;

    $targetPath =
        $targetDir .
        DIRECTORY_SEPARATOR .
        $fileName;

    // ----------------------------------------------------------
    // MOVE UPLOADED FILE
    // ----------------------------------------------------------
    try {
        $file->move(
            $targetDir,
            $fileName
        );
    } catch (\Throwable $e) {
        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'Unable to save uploaded Excel file: ' .
                $e->getMessage()
            );
    }

    // ----------------------------------------------------------
    // VERIFY FILE EXISTS
    // ----------------------------------------------------------
    if (!is_file($targetPath)) {
        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'Uploaded Excel file could not be found after upload.'
            );
    }

    // ----------------------------------------------------------
    // PARSE EXCEL
    // ----------------------------------------------------------
    try {
        $rows = $this->parseExcelRows(
            $targetPath
        );
    } catch (\Throwable $e) {

        if (is_file($targetPath)) {
            @unlink($targetPath);
        }

        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'Excel import failed: ' .
                $e->getMessage()
            );
    }

    // ----------------------------------------------------------
    // CHECK IF ROWS WERE FOUND
    // ----------------------------------------------------------
    if (empty($rows)) {

        if (is_file($targetPath)) {
            @unlink($targetPath);
        }

        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'No data rows were found in the Excel file.'
            );
    }

    // ----------------------------------------------------------
    // CONNECT DATABASE
    // ----------------------------------------------------------
    $database = db_connect();

    // ----------------------------------------------------------
    // CHECK TB_PMS
    // ----------------------------------------------------------
    if (!$database->tableExists('tb_pms')) {

        if (is_file($targetPath)) {
            @unlink($targetPath);
        }

        return redirect()
            ->to(site_url('pms'))
            ->with(
                'error',
                'The tb_pms table does not exist.'
            );
    }

    // ----------------------------------------------------------
    // GET ACTUAL TB_PMS COLUMNS
    // ----------------------------------------------------------
    $availableColumns = [];

    $columns = $database
        ->query(
            'SHOW COLUMNS FROM tb_pms'
        )
        ->getResultArray();

    foreach ($columns as $column) {

        if (isset($column['Field'])) {
            $availableColumns[] =
                $column['Field'];
        }
    }

    // ----------------------------------------------------------
    // IMPORT COUNTERS
    // ----------------------------------------------------------
    $inserted = 0;
    $skipped  = 0;
    $failed   = 0;

    // ----------------------------------------------------------
    // PROCESS EXCEL ROWS
    //
    // EXCEL FORMAT:
    //
    // A = PMS Number
    // B = Service Technician
    // C = Clinic
    // D = Address
    // H = Date
    // E = Machine
    // F = Serial Number
    // G = Status / Technical Done
    // ----------------------------------------------------------

    foreach ($rows as $row) {

        // ------------------------------------------------------
        // READ VALUES
        // ------------------------------------------------------

        $pmsNumber = trim(
            (string) (
                $row['A']['value'] ?? ''
            )
        );

        $serviceTech = trim(
            (string) (
                $row['B']['value'] ?? ''
            )
        );

        $clinic = trim(
            (string) (
                $row['C']['value'] ?? ''
            )
        );

        $address = trim(
            (string) (
                $row['D']['value'] ?? ''
            )
        );

        $date = $this->normalizeExcelDate(
            (string) (
                $row['E']['value'] ?? ''
            )
        );

        $machine = trim(
            (string) (
                $row['F']['value'] ?? ''
            )
        );

        $serialNumber = trim(
            (string) (
                $row['G']['value'] ?? ''
            )
        );

        $status = trim(
            (string) (
                $row['H']['value'] ?? ''
            )
        );

        // $remarks = trim(
        //     (string) (
        //         $row['I']['value'] ?? ''
        //     )
        // );

        // ------------------------------------------------------
        // SKIP EMPTY ROW
        // ------------------------------------------------------

        $candidate = [
            $pmsNumber,
            $serviceTech,
            $clinic,
            $address,
            $date,
            $machine,
            $serialNumber,
            $status
        ];

        if (!$this->hasMeaningfulImportValue($candidate)) {
            $skipped++;
            continue;
        }

        // ------------------------------------------------------
        // PMS NUMBER
        //
        // Convert numeric PMS numbers to 6 digits.
        //
        // Example:
        // 1      -> 000001
        // 25     -> 000025
        // 123456 -> 123456
        // ------------------------------------------------------

        if (
            $pmsNumber !== '' &&
            preg_match('/^\d+$/', $pmsNumber)
        ) {
            $pmsNumber = str_pad(
                $pmsNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
        }

        // ------------------------------------------------------
        // BUILD RECORD
        // ------------------------------------------------------

        $record = [
            'pms_number' => $pmsNumber,
            'service_tech' => $serviceTech,
            'clinic' => $clinic,
            'address' => $address,
            'date' => $date,
            'machine' => $machine,
            'sn' => $serialNumber,
            'status' => $status,

        ];

        // ------------------------------------------------------
        // ONLY INSERT EXISTING DATABASE COLUMNS
        // ------------------------------------------------------

        $insert = [];

        foreach ($record as $column => $value) {

            if (in_array(
                $column,
                $availableColumns,
                true
            )) {
                $insert[$column] = $value;
            }
        }

        // ------------------------------------------------------
        // NO VALID COLUMNS
        // ------------------------------------------------------

        if (empty($insert)) {
            $failed++;
            continue;
        }

        // ------------------------------------------------------
        // DUPLICATE CHECK
        //
        // First check PMS number.
        // ------------------------------------------------------

        $existing = null;

        if (
            $pmsNumber !== '' &&
            in_array(
                'pms_number',
                $availableColumns,
                true
            )
        ) {

            $existing = $database
                ->table('tb_pms')
                ->where(
                    'pms_number',
                    $pmsNumber
                )
                ->get()
                ->getRowArray();

        } else {

            // --------------------------------------------------
            // FALLBACK DUPLICATE CHECK
            // --------------------------------------------------

            $duplicateBuilder =
                $database->table('tb_pms');

            $duplicateFields = [
                'clinic' => $clinic,
                'address' => $address,
                'date' => $date,
                'machine' => $machine,
                'sn' => $serialNumber
            ];

            foreach (
                $duplicateFields as $column => $value
            ) {

                if (
                    in_array(
                        $column,
                        $availableColumns,
                        true
                    )
                ) {
                    $duplicateBuilder->where(
                        $column,
                        $value
                    );
                }
            }

            $existing = $duplicateBuilder
                ->get()
                ->getRowArray();
        }

        // ------------------------------------------------------
        // SKIP DUPLICATE
        // ------------------------------------------------------

        if ($existing) {
            $skipped++;
            continue;
        }

        // ------------------------------------------------------
        // INSERT
        // ------------------------------------------------------

        try {

            $insertedResult =
                $database
                    ->table('tb_pms')
                    ->insert($insert);

            if ($insertedResult) {
                $inserted++;
            } else {
                $failed++;
            }

        } catch (\Throwable $e) {

            $failed++;
        }
    }

    // ----------------------------------------------------------
    // DELETE TEMP FILE
    // ----------------------------------------------------------

    if (is_file($targetPath)) {
        @unlink($targetPath);
    }

    // ----------------------------------------------------------
    // RESULT
    // ----------------------------------------------------------

    $message =
        'PMS import completed. ' .
        'Imported: ' . $inserted .
        ', Skipped: ' . $skipped .
        ', Failed: ' . $failed .
        '.';

    // ----------------------------------------------------------
    // SUCCESS
    // ----------------------------------------------------------

    if ($inserted > 0) {

        return redirect()
            ->to(site_url('pms'))
            ->with(
                'success',
                $message
            );
    }

    // ----------------------------------------------------------
    // NOTHING IMPORTED
    // ----------------------------------------------------------

    return redirect()
        ->to(site_url('pms'))
        ->with(
            'error',
            $message
        );
}


// ==============================================================
// PARSE EXCEL / CSV
//
// Supports:
//   - XLSX
//   - CSV
//
// XLSX is read directly using:
//   - ZipArchive
//   - DOMDocument
//   - DOMXPath
//
// No PhpSpreadsheet required.
// No SimpleXMLElement::xpath() is used.
// ==============================================================

private function parseExcelRows(
    string $path
): array {

    $extension = strtolower(
        pathinfo(
            $path,
            PATHINFO_EXTENSION
        )
    );

    // ==========================================================
    // CSV
    // ==========================================================

    if ($extension === 'csv') {

        $rows = [];

        $handle = fopen(
            $path,
            'rb'
        );

        if ($handle === false) {
            throw new \RuntimeException(
                'Unable to read CSV file.'
            );
        }

        while (
            ($data = fgetcsv($handle)) !== false
        ) {
            $rows[] = $data;
        }

        fclose($handle);

        // ------------------------------------------------------
        // REMOVE HEADER
        // ------------------------------------------------------

        if (!empty($rows)) {
            array_shift($rows);
        }

        // ------------------------------------------------------
        // MAP CSV COLUMNS
        // ------------------------------------------------------

        $columnLetters = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T'
        ];

        $mappedRows = [];

        foreach ($rows as $row) {

            $mapped = [];

            foreach (
                $columnLetters as $index => $letter
            ) {

                if (
                    !array_key_exists(
                        $index,
                        $row
                    )
                ) {
                    continue;
                }

                $mapped[$letter] = [
                    'value' => trim(
                        (string) $row[$index]
                    )
                ];
            }

            if (!empty($mapped)) {
                $mappedRows[] = $mapped;
            }
        }

        return $mappedRows;
    }

    // ==========================================================
    // XLSX
    // ==========================================================

    if ($extension !== 'xlsx') {

        throw new \RuntimeException(
            'Only .xlsx and .csv files are supported.'
        );
    }

    // ==========================================================
    // CHECK ZIPARCHIVE
    // ==========================================================

    if (!class_exists('ZipArchive')) {

        throw new \RuntimeException(
            'PHP ZipArchive is not enabled. ' .
            'Please enable the ZIP extension in php.ini.'
        );
    }

    // ==========================================================
    // OPEN XLSX
    // ==========================================================

    $zip = new \ZipArchive();

    $opened = $zip->open($path);

    if ($opened !== true) {

        throw new \RuntimeException(
            'Unable to open the Excel XLSX file.'
        );
    }

    // ==========================================================
    // XML NAMESPACES
    // ==========================================================

    $mainNamespace =
        'http://schemas.openxmlformats.org/spreadsheetml/2006/main';

    $relationshipNamespace =
        'http://schemas.openxmlformats.org/officeDocument/2006/relationships';

    $packageRelationshipNamespace =
        'http://schemas.openxmlformats.org/package/2006/relationships';

    // ==========================================================
    // READ SHARED STRINGS
    // ==========================================================

    $sharedStrings = [];

    $sharedXml = $zip->getFromName(
        'xl/sharedStrings.xml'
    );

    if ($sharedXml !== false) {

        $sharedDocument = new \DOMDocument();

        $sharedDocument->preserveWhiteSpace = false;

        if (
            !@$sharedDocument->loadXML(
                $sharedXml
            )
        ) {
            $zip->close();

            throw new \RuntimeException(
                'Unable to read Excel shared strings.'
            );
        }

        $sharedXPath = new \DOMXPath(
            $sharedDocument
        );

        // IMPORTANT:
        // Register namespace before using it.
        $sharedXPath->registerNamespace(
            'x',
            $mainNamespace
        );

        $sharedItems = $sharedXPath->query(
            '//x:si'
        );

        if ($sharedItems !== false) {

            foreach ($sharedItems as $si) {

                $text = '';

                $textNodes = $sharedXPath->query(
                    './/x:t',
                    $si
                );

                if ($textNodes !== false) {

                    foreach ($textNodes as $textNode) {

                        $text .=
                            $textNode->nodeValue;
                    }
                }

                $sharedStrings[] = $text;
            }
        }
    }

    // ==========================================================
    // READ WORKBOOK.XML
    // ==========================================================

    $workbookContent =
        $zip->getFromName(
            'xl/workbook.xml'
        );

    if ($workbookContent === false) {

        $zip->close();

        throw new \RuntimeException(
            'The Excel workbook.xml file could not be found.'
        );
    }

    $workbookDocument = new \DOMDocument();

    $workbookDocument->preserveWhiteSpace = false;

    if (
        !@$workbookDocument->loadXML(
            $workbookContent
        )
    ) {

        $zip->close();

        throw new \RuntimeException(
            'The Excel workbook could not be read.'
        );
    }

    $workbookXPath = new \DOMXPath(
        $workbookDocument
    );

    // IMPORTANT:
    // Register namespaces.
    $workbookXPath->registerNamespace(
        'x',
        $mainNamespace
    );

    $workbookXPath->registerNamespace(
        'r',
        $relationshipNamespace
    );

    // ==========================================================
    // FIND FIRST SHEET
    // ==========================================================

    $sheetNodes = $workbookXPath->query(
        '//x:sheets/x:sheet'
    );

    $relationshipId = '';

    if (
        $sheetNodes !== false &&
        $sheetNodes->length > 0
    ) {

        $firstSheet =
            $sheetNodes->item(0);

        $relationshipId =
            $firstSheet->getAttributeNS(
                $relationshipNamespace,
                'id'
            );
    }

    // ==========================================================
    // FIND SHEET PATH
    // ==========================================================

    $sheetPath = null;

    if ($relationshipId !== '') {

        $relsContent =
            $zip->getFromName(
                'xl/_rels/workbook.xml.rels'
            );

        if ($relsContent !== false) {

            $relsDocument =
                new \DOMDocument();

            $relsDocument->preserveWhiteSpace = false;

            if (
                @$relsDocument->loadXML(
                    $relsContent
                )
            ) {

                $relsXPath =
                    new \DOMXPath(
                        $relsDocument
                    );

                $relsXPath->registerNamespace(
                    'pr',
                    $packageRelationshipNamespace
                );

                $relationshipNodes =
                    $relsXPath->query(
                        '//pr:Relationship'
                    );

                if (
                    $relationshipNodes !== false
                ) {

                    foreach (
                        $relationshipNodes as $relationship
                    ) {

                        $id =
                            $relationship->getAttribute(
                                'Id'
                            );

                        if (
                            $id !==
                            $relationshipId
                        ) {
                            continue;
                        }

                        $target =
                            $relationship->getAttribute(
                                'Target'
                            );

                        $target =
                            ltrim(
                                $target,
                                '/'
                            );

                        if (
                            strpos(
                                $target,
                                'xl/'
                            ) === 0
                        ) {

                            $sheetPath =
                                $target;

                        } else {

                            $sheetPath =
                                'xl/' .
                                $target;
                        }

                        break;
                    }
                }
            }
        }
    }

    // ==========================================================
    // FALLBACK SHEET1
    // ==========================================================

    if ($sheetPath === null) {

        $fallbackSheets = [
            'xl/worksheets/sheet1.xml',
            'xl/worksheets/sheet.xml'
        ];

        foreach (
            $fallbackSheets as $candidate
        ) {

            if (
                $zip->locateName(
                    $candidate
                ) !== false
            ) {

                $sheetPath =
                    $candidate;

                break;
            }
        }
    }

    // ==========================================================
    // FALLBACK: SEARCH ALL SHEETS
    // ==========================================================

    if ($sheetPath === null) {

        for (
            $i = 0;
            $i < $zip->numFiles;
            $i++
        ) {

            $entry =
                $zip->getNameIndex(
                    $i
                );

            if (
                preg_match(
                    '#^xl/worksheets/sheet\d+\.xml$#',
                    $entry
                ) === 1
            ) {

                $sheetPath =
                    $entry;

                break;
            }
        }
    }

    // ==========================================================
    // VERIFY WORKSHEET
    // ==========================================================

    if (
        $sheetPath === null ||
        $zip->locateName($sheetPath) === false
    ) {

        $zip->close();

        throw new \RuntimeException(
            'Unable to locate the worksheet inside the Excel file.'
        );
    }

    // ==========================================================
    // READ WORKSHEET
    // ==========================================================

    $sheetContent =
        $zip->getFromName(
            $sheetPath
        );

    $zip->close();

    if ($sheetContent === false) {

        throw new \RuntimeException(
            'Unable to read worksheet data.'
        );
    }

    // ==========================================================
    // LOAD WORKSHEET WITH DOM
    // ==========================================================

    $sheetDocument =
        new \DOMDocument();

    $sheetDocument->preserveWhiteSpace = false;

    if (
        !@$sheetDocument->loadXML(
            $sheetContent
        )
    ) {

        throw new \RuntimeException(
            'Unable to parse worksheet XML.'
        );
    }

    // ==========================================================
    // DOM XPATH
    // ==========================================================

    $sheetXPath =
        new \DOMXPath(
            $sheetDocument
        );

    // IMPORTANT:
    // This prevents:
    //
    // SimpleXMLElement::xpath():
    // Undefined namespace prefix
    //
    $sheetXPath->registerNamespace(
        'x',
        $mainNamespace
    );

    // ==========================================================
    // GET ROWS
    // ==========================================================

    $rowNodes =
        $sheetXPath->query(
            '//x:sheetData/x:row'
        );

    if (
        $rowNodes === false ||
        $rowNodes->length === 0
    ) {

        throw new \RuntimeException(
            'The Excel worksheet does not contain any rows.'
        );
    }

    // ==========================================================
    // PARSE ROWS
    // ==========================================================

    $rows = [];

    $physicalRowNumber = 0;

    foreach (
        $rowNodes as $rowNode
    ) {

        $physicalRowNumber++;

        // ------------------------------------------------------
        // SKIP HEADER ROW
        // ------------------------------------------------------

        if ($physicalRowNumber === 1) {
            continue;
        }

        $parsedRow = [];

        // ------------------------------------------------------
        // GET CELLS
        // ------------------------------------------------------

        $cellNodes =
            $sheetXPath->query(
                './x:c',
                $rowNode
            );

        if (
            $cellNodes === false
        ) {
            continue;
        }

        foreach (
            $cellNodes as $cellNode
        ) {

            // --------------------------------------------------
            // CELL REFERENCE
            // --------------------------------------------------

            $cellReference =
                $cellNode->getAttribute('r');

            if (
                $cellReference === ''
            ) {
                continue;
            }

            // Example:
            //
            // A2
            // B2
            // C2
            //
            // Convert:
            //
            // A
            // B
            // C

            $column =
                preg_replace(
                    '/\d+$/',
                    '',
                    $cellReference
                );

            if (
                $column === null ||
                $column === ''
            ) {
                continue;
            }

            $column =
                strtoupper(
                    $column
                );

            // --------------------------------------------------
            // CELL TYPE
            // --------------------------------------------------

            $cellType =
                $cellNode->getAttribute('t');

            $value = '';

            // --------------------------------------------------
            // GET <v>
            // --------------------------------------------------

            $valueNodes =
                $sheetXPath->query(
                    './x:v',
                    $cellNode
                );

            $rawValue = '';

            if (
                $valueNodes !== false &&
                $valueNodes->length > 0
            ) {

                $rawValue =
                    trim(
                        $valueNodes
                            ->item(0)
                            ->nodeValue
                    );
            }

            // --------------------------------------------------
            // SHARED STRING
            // --------------------------------------------------

            if ($cellType === 's') {

                $index =
                    (int) $rawValue;

                $value =
                    $sharedStrings[$index]
                    ?? '';

            // --------------------------------------------------
            // INLINE STRING
            // --------------------------------------------------

            } elseif (
                $cellType === 'inlineStr'
            ) {

                $textNodes =
                    $sheetXPath->query(
                        './/x:t',
                        $cellNode
                    );

                if (
                    $textNodes !== false
                ) {

                    foreach (
                        $textNodes as $textNode
                    ) {

                        $value .=
                            $textNode->nodeValue;
                    }
                }

            // --------------------------------------------------
            // BOOLEAN
            // --------------------------------------------------

            } elseif (
                $cellType === 'b'
            ) {

                $value =
                    $rawValue === '1'
                        ? 'TRUE'
                        : 'FALSE';

            // --------------------------------------------------
            // FORMULA / NUMBER / DATE / NORMAL TEXT
            // --------------------------------------------------

            } else {

                $value =
                    $rawValue;
            }

            // --------------------------------------------------
            // STORE CELL
            // --------------------------------------------------

            $parsedRow[$column] = [
                'value' => trim(
                    (string) $value
                )
            ];
        }

        // ------------------------------------------------------
        // STORE ROW
        // ------------------------------------------------------

        if (!empty($parsedRow)) {
            $rows[] =
                $parsedRow;
        }
    }

    return $rows;
}


// ==============================================================
// NORMALIZE EXCEL DATE
// ==============================================================

private function normalizeExcelDate(
    string $value
): string {

    $value = trim($value);

    if ($value === '') {
        return '';
    }

    // ----------------------------------------------------------
    // ALREADY YYYY-MM-DD
    // ----------------------------------------------------------

    $date =
        \DateTime::createFromFormat(
            'Y-m-d',
            $value
        );

    if (
        $date !== false &&
        $date->format('Y-m-d') === $value
    ) {

        return $value;
    }

    // ----------------------------------------------------------
    // COMMON DATE FORMATS
    // ----------------------------------------------------------

    $formats = [
        'm/d/Y',
        'd/m/Y',
        'm-d-Y',
        'd-m-Y',
        'Y/m/d',
        'Y.m.d',
        'm/d/y',
        'd/m/y',
        'm.d.Y',
        'd.m.Y'
    ];

    foreach (
        $formats as $format
    ) {

        $date =
            \DateTime::createFromFormat(
                $format,
                $value
            );

        if (
            $date !== false &&
            $date->format($format) === $value
        ) {

            return $date->format(
                'Y-m-d'
            );
        }
    }

    // ----------------------------------------------------------
    // EXCEL SERIAL DATE
    // ----------------------------------------------------------

    if (
        preg_match(
            '/^\d+(?:\.\d+)?$/',
            $value
        )
    ) {

        $serial =
            (float) $value;

        /*
         * Excel Windows date system.
         *
         * 1 = 1900-01-01
         *
         * 1899-12-30 is used because of
         * Excel's historical leap-year bug.
         */

        if (
            $serial > 0 &&
            $serial < 100000
        ) {

            $baseDate =
                new \DateTime(
                    '1899-12-30'
                );

            $days =
                (int) floor(
                    $serial
                );

            $baseDate->modify(
                '+' .
                $days .
                ' days'
            );

            return $baseDate->format(
                'Y-m-d'
            );
        }
    }

    // ----------------------------------------------------------
    // TRY PHP DATE PARSER
    // ----------------------------------------------------------

    try {

        $timestamp =
            strtotime($value);

        if (
            $timestamp !== false
        ) {

            return date(
                'Y-m-d',
                $timestamp
            );
        }

    } catch (\Throwable $e) {

        // Continue to fallback.
    }

    // ----------------------------------------------------------
    // FALLBACK
    // ----------------------------------------------------------

    return $value;
}


// ==============================================================
// CHECK MEANINGFUL IMPORT VALUE
// ==============================================================

private function hasMeaningfulImportValue(
    array $record
): bool {

    $emptyValues = [
        '',
        '0',
        '0000-00-00',
        '0000-00-00 00:00:00',
        '0000-00',
        'null',
        'none',
        'n/a',
        '-'
    ];

    foreach (
        $record as $value
    ) {

        $trimmed =
            trim(
                (string) $value
            );

        if ($trimmed === '') {
            continue;
        }

        $lower =
            strtolower(
                $trimmed
            );

        if (
            in_array(
                $lower,
                $emptyValues,
                true
            )
        ) {
            continue;
        }

        // ------------------------------------------------------
        // ZERO-LIKE DATE
        // ------------------------------------------------------

        if (
            preg_match(
                '/^0{2,4}[-\/ ]0{2}[-\/ ]0{2}.*$/',
                $trimmed
            ) === 1
        ) {
            continue;
        }

        return true;
    }

    return false;
}
}


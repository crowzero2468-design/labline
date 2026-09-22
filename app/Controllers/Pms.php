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

            'image/webp'
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
}

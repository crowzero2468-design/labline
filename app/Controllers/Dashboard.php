<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Dashboard extends BaseController
{
    // ==============================================================
    // DASHBOARD
    // ==============================================================

    public function index(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        // ==========================================================
        // DELETE RECORD
        // ==========================================================

        $deleteId = $this->request->getGet('delete');

        if ($deleteId !== null && $deleteId !== '') {

            $database->table('tb_data')
                ->where('id', $deleteId)
                ->delete();

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'success',
                    'Record deleted successfully.'
                );
        }

        // ==========================================================
        // EDIT RECORD
        // ==========================================================

        $editId = $this->request->getGet('edit');

        $editingRow = null;

        if ($editId !== null && $editId !== '') {

            $editingRow = $database->table('tb_data')
                ->where('id', $editId)
                ->get()
                ->getRowArray();
        }

        // ==========================================================
        // SEARCH / DATE FILTER / PAGINATION
        // ==========================================================

        $search = trim(
            (string) ($this->request->getGet('search') ?? '')
        );

        $startDate = trim(
            (string) ($this->request->getGet('start_date') ?? '')
        );

        $endDate = trim(
            (string) ($this->request->getGet('end_date') ?? '')
        );

        $page = max(
            1,
            (int) ($this->request->getGet('page') ?? 1)
        );

        $perPage = 10;

        // ==========================================================
        // BASE FILTERED QUERY
        //
        // IMPORTANT:
        // Search + Date Filter are applied here FIRST.
        //
        // The same filter is then used for:
        // - Total Province
        // - Total Clinic
        // - Machine Counts
        // - Table Records
        // ==========================================================

        $filterBuilder = $database->table('tb_data');

        // Only active records
        $filterBuilder->where('status', 'A');

        // ==========================================================
        // SEARCH FILTER
        // ==========================================================

        if ($search !== '') {

            $filterBuilder->groupStart()

                ->like('Clinic_name', $search)
                ->orLike('Address', $search)
                ->orLike('Province', $search)
                ->orLike('Machine', $search)
                ->orLike('Model', $search)
                ->orLike('SN', $search)
                ->orLike('DR_Number', $search)

                ->groupEnd();
        }

        // ==========================================================
        // DATE FILTER
        //
        // Installed_date
        // ==========================================================

        if ($startDate !== '' && $endDate !== '') {

            $filterBuilder
                ->where('Installed_date >=', $startDate)
                ->where('Installed_date <=', $endDate);

        } elseif ($startDate !== '') {

            $filterBuilder
                ->where('Installed_date >=', $startDate);

        } elseif ($endDate !== '') {

            $filterBuilder
                ->where('Installed_date <=', $endDate);
        }

        // ==========================================================
        // TOTAL PROVINCES
        //
        // THIS NOW USES THE ACTIVE SEARCH + DATE FILTER
        // ==========================================================

        $totalData = 0;

        if ($database->tableExists('tb_data')) {

            $provinceBuilder = clone $filterBuilder;

            $provinceBuilder
                ->select(
                    'COUNT(DISTINCT LOWER(TRIM(Province))) AS total',
                    false
                )
                ->where('Province IS NOT NULL')
                ->where("TRIM(Province) !=", '');

            $provinceResult = $provinceBuilder
                ->get()
                ->getRow();

            $totalData = (int) (
                $provinceResult->total ?? 0
            );
        }

        // ==========================================================
        // TOTAL CLINICS
        //
        // THIS NOW USES THE ACTIVE SEARCH + DATE FILTER
        // ==========================================================

        $totalMachine = 0;

        if ($database->tableExists('tb_data')) {

            $clinicBuilder = clone $filterBuilder;

            $clinicBuilder
                ->select(
                    'COUNT(DISTINCT LOWER(TRIM(Clinic_name))) AS total',
                    false
                )
                ->where('Clinic_name IS NOT NULL')
                ->where("TRIM(Clinic_name) !=", '');

            $clinicResult = $clinicBuilder
                ->get()
                ->getRow();

            $totalMachine = (int) (
                $clinicResult->total ?? 0
            );
        }

        // ==========================================================
        // MACHINE COUNTS
        //
        // THIS NOW USES THE ACTIVE SEARCH + DATE FILTER
        // ==========================================================

        $machineCounts = [];

        if ($database->tableExists('tb_data')) {

            $machineBuilder = clone $filterBuilder;

            $machineCounts = $machineBuilder
                ->select(
                    'Machine, COUNT(*) AS total',
                    false
                )
                ->where('Machine IS NOT NULL')
                ->where("TRIM(Machine) !=", '')
                ->groupBy('Machine')
                ->orderBy('total', 'DESC')
                ->get()
                ->getResultArray();
        }

        // ==========================================================
        // TOTAL FILTERED ROWS
        // ==========================================================

        $countBuilder = clone $filterBuilder;

        $totalRows = $countBuilder->countAllResults();

        $totalPages = max(
            1,
            (int) ceil($totalRows / $perPage)
        );

        $page = min(
            $page,
            $totalPages
        );

        // ==========================================================
        // GET FILTERED TABLE RECORDS
        // ==========================================================

        $tableBuilder = clone $filterBuilder;

        $records = $tableBuilder
            ->orderBy('Clinic_name', 'ASC')
            ->orderBy('id', 'DESC')
            ->limit(
                $perPage,
                ($page - 1) * $perPage
            )
            ->get()
            ->getResultArray();

        // ==========================================================
        // CLINIC MAP
        //
        // Used by:
        // - Cancel Account modal
        // - Account dropdown
        // - Automatic address filling
        //
        // IMPORTANT:
        // This remains based on ALL active accounts,
        // not the current date filter.
        // ==========================================================

        $clinicMap = [];

        if ($database->tableExists('tb_data')) {

            $clinicRecords = $database->table('tb_data')
                ->select(
                    'id, Clinic_name, Address, Province, Machine, Model, SN'
                )
                ->where('Clinic_name IS NOT NULL')
                ->where("TRIM(Clinic_name) !=", '')
                ->where('status', 'A')
                ->orderBy('Clinic_name', 'ASC')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResultArray();

            foreach ($clinicRecords as $row) {

                $clinicName = trim(
                    (string) ($row['Clinic_name'] ?? '')
                );

                if ($clinicName === '') {
                    continue;
                }

                // --------------------------------------------------
                // CREATE CLINIC ENTRY ONLY ONCE
                // --------------------------------------------------

                if (!isset($clinicMap[$clinicName])) {

                    $clinicMap[$clinicName] = [
                        'id'       => $row['id'] ?? '',
                        'address'  => $row['Address'] ?? '',
                        'province' => $row['Province'] ?? '',
                        'machines' => [],
                    ];
                }

                // --------------------------------------------------
                // ADD MACHINE INFORMATION
                // --------------------------------------------------

                $machine = trim(
                    (string) ($row['Machine'] ?? '')
                );

                if ($machine !== '') {

                    $clinicMap[$clinicName]['machines'][] = [
                        'id'      => $row['id'] ?? '',
                        'machine' => $row['Machine'] ?? '',
                        'model'   => $row['Model'] ?? '',
                        'sn'      => $row['SN'] ?? '',
                    ];
                }
            }
        }

        // ==========================================================
        // DASHBOARD VIEW
        // ==========================================================

        return view('dashboard/index', [

            'user' => session()->get('user'),

            // ======================================================
            // FILTERED DASHBOARD TOTALS
            // ======================================================

            'total_data'     => $totalData,
            'total_machine'  => $totalMachine,
            'machine_counts' => $machineCounts,

            // ======================================================
            // FILTERED TABLE
            // ======================================================

            'records' => $records,

            // ======================================================
            // FILTER VALUES
            // ======================================================

            'search'     => $search,
            'start_date' => $startDate,
            'end_date'   => $endDate,

            // ======================================================
            // PAGINATION
            // ======================================================

            'page'        => $page,
            'per_page'    => $perPage,
            'total_pages' => $totalPages,
            'total_rows'  => $totalRows,

            // ======================================================
            // EDIT
            // ======================================================

            'editing_row' => $editingRow,

            // ======================================================
            // CLINIC MAP
            // ======================================================

            'clinicMap' => $clinicMap,
        ]);
    }


    // ==============================================================
    // MAP
    // ==============================================================

    public function map(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {

            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        $provinceTotals = [];

        if ($database->tableExists('tb_data')) {

            $provinceTotals = $database->query(
                "SELECT
                    Province,
                    COUNT(*) AS total
                 FROM tb_data
                 WHERE Province IS NOT NULL
                 AND TRIM(Province) != ''
                 GROUP BY Province
                 ORDER BY total DESC, Province ASC"
            )->getResultArray();
        }

        return view('dashboard/map', [

            'user' => session()->get('user'),

            'province_totals' => $provinceTotals,
        ]);
    }


    // ==============================================================
    // SAVE RECORD
    // ==============================================================

    public function saveRecord(): RedirectResponse
    {
        if (!session()->get('logged_in')) {

            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        $data = [

            'Clinic_name' => trim(
                (string) $this->request->getPost('Clinic_name')
            ),

            'Address' => trim(
                (string) $this->request->getPost('Address')
            ),

            'Province' => trim(
                (string) $this->request->getPost('Province')
            ),

            'Machine' => trim(
                (string) $this->request->getPost('Machine')
            ),

            'Model' => trim(
                (string) $this->request->getPost('Model')
            ),

            'Installed_date' => $this->normalizeExcelDate(
                trim(
                    (string) $this->request->getPost('Installed_date')
                )
            ),

            'SN' => trim(
                (string) $this->request->getPost('SN')
            ),

            'DR_Number' => $this->normalizeDrNumber(
                trim(
                    (string) $this->request->getPost('DR_Number')
                )
            ),

            'status' => 'A',
        ];

        if (!$this->hasMeaningfulImportValue($data)) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Please provide at least one valid field for the machine record.'
                );
        }

        $database->table('tb_data')->insert($data);

        return redirect()->to(site_url('dashboard'))
            ->with(
                'success',
                'Machine record added successfully.'
            );
    }


    // ==============================================================
    // UPDATE RECORD
    // ==============================================================

    public function updateRecord(): RedirectResponse
    {
        if (!session()->get('logged_in')) {

            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $id = (int) $this->request->getPost('id');

        if ($id <= 0) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Invalid record selected for update.'
                );
        }

        $database = db_connect();

        $data = [

            'Clinic_name' => trim(
                (string) $this->request->getPost('Clinic_name')
            ),

            'Address' => trim(
                (string) $this->request->getPost('Address')
            ),

            'Province' => trim(
                (string) $this->request->getPost('Province')
            ),

            'Machine' => trim(
                (string) $this->request->getPost('Machine')
            ),

            'Model' => trim(
                (string) $this->request->getPost('Model')
            ),

            'Installed_date' => $this->normalizeExcelDate(
                trim(
                    (string) $this->request->getPost('Installed_date')
                )
            ),

            'SN' => trim(
                (string) $this->request->getPost('SN')
            ),

            'DR_Number' => $this->normalizeDrNumber(
                trim(
                    (string) $this->request->getPost('DR_Number')
                )
            ),
        ];

        if (!$this->hasMeaningfulImportValue($data)) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Please provide valid values before saving the edit.'
                );
        }

        $database->table('tb_data')
            ->where('id', $id)
            ->update($data);

        return redirect()->to(site_url('dashboard'))
            ->with(
                'success',
                'Machine record updated successfully.'
            );
    }


    // ==============================================================
    // ATTACH CONTRACT
    // ==============================================================

    public function attachContract(): RedirectResponse
    {
        if (!session()->get('logged_in')) {

            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        $id = (int) $this->request->getPost('id');

        if ($id <= 0) {

            return redirect()->to(site_url('dashboard'))
                ->with('error', 'Invalid record selected.');
        }

        $record = $database->table('tb_data')
            ->select('id, contract_id')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$record) {

            return redirect()->to(site_url('dashboard'))
                ->with('error', 'Record not found.');
        }

        $file = $this->request->getFile('contract_file');

        if ($file === null || !$file->isValid()) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Please select a valid contract file.'
                );
        }

        $allowedExtensions = [
            'pdf',
            'jpg',
            'jpeg',
            'png',
        ];

        $extension = strtolower(
            $file->getExtension()
        );

        if (!in_array($extension, $allowedExtensions, true)) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Only PDF, JPG, JPEG, and PNG files are allowed.'
                );
        }

        $allowedMimeTypes = [
            'application/pdf',
            'image/jpeg',
            'image/png',
        ];

        if (!in_array($file->getMimeType(), $allowedMimeTypes, true)) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Invalid contract file type.'
                );
        }

        $targetDir =
            FCPATH .
            'upload' .
            DIRECTORY_SEPARATOR .
            'contract';

        if (!is_dir($targetDir)) {

            if (!mkdir($targetDir, 0775, true)) {

                return redirect()->to(site_url('dashboard'))
                    ->with(
                        'error',
                        'Unable to create contract upload directory.'
                    );
            }
        }

        $database->transBegin();

        $fullPath = null;
        $contractId = 0;

        try {

            // ------------------------------------------------------
            // CREATE CONTRACT RECORD
            // ------------------------------------------------------

            $database->table('tb_contract')->insert([
                'location' => '',
            ]);

            $contractId = (int) $database->insertID();

            if ($contractId <= 0) {

                throw new \RuntimeException(
                    'Unable to create contract record.'
                );
            }

            // ------------------------------------------------------
            // FILE NAME
            // ------------------------------------------------------

            $fileName =
                'contract_' .
                $contractId .
                '.' .
                $extension;

            $relativeLocation =
                'upload/contract/' .
                $fileName;

            $fullPath =
                $targetDir .
                DIRECTORY_SEPARATOR .
                $fileName;

            // ------------------------------------------------------
            // SAVE FILE
            // ------------------------------------------------------

            if (!$file->move(
                $targetDir,
                $fileName,
                true
            )) {

                throw new \RuntimeException(
                    'Unable to save the contract file.'
                );
            }

            if (!is_file($fullPath)) {

                throw new \RuntimeException(
                    'Contract file was not saved.'
                );
            }

            // ------------------------------------------------------
            // UPDATE CONTRACT LOCATION
            // ------------------------------------------------------

            $updatedContract =
                $database->table('tb_contract')
                    ->where('id', $contractId)
                    ->update([
                        'location' => $relativeLocation,
                    ]);

            if (!$updatedContract) {

                throw new \RuntimeException(
                    'Unable to update contract location.'
                );
            }

            // ------------------------------------------------------
            // UPDATE TB_DATA CONTRACT ID
            // ------------------------------------------------------

            $updatedData =
                $database->table('tb_data')
                    ->where('id', $id)
                    ->update([
                        'contract_id' => $contractId,
                    ]);

            if (!$updatedData) {

                throw new \RuntimeException(
                    'Unable to update tb_data contract_id.'
                );
            }

            // ------------------------------------------------------
            // CHECK TRANSACTION
            // ------------------------------------------------------

            if (!$database->transStatus()) {

                throw new \RuntimeException(
                    'Database transaction failed.'
                );
            }

            $database->transCommit();

            return redirect()
                ->to(site_url('dashboard'))
                ->with(
                    'success',
                    'Contract attached successfully.'
                );

        } catch (\Throwable $e) {

            $database->transRollback();

            if (
                $fullPath !== null &&
                is_file($fullPath)
            ) {
                @unlink($fullPath);
            }

            return redirect()
                ->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Unable to save the contract: ' .
                    $e->getMessage()
                );
        }
    }


    // ==============================================================
    // IMPORT EXCEL
    // ==============================================================

    public function importExcel(): RedirectResponse
    {
        if (!session()->get('logged_in')) {

            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $file = $this->request->getFile('excel_file');

        if ($file === null || !$file->isValid()) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Please choose an Excel file to import.'
                );
        }

        $allowedExtensions = [
            'xlsx',
            'csv',
        ];

        $extension = strtolower(
            $file->getExtension()
        );

        if (!in_array($extension, $allowedExtensions, true)) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    'Only .xlsx and .csv files are allowed.'
                );
        }

        $targetDir = WRITEPATH . 'upload';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName =
            'import_' .
            time() .
            '_' .
            bin2hex(random_bytes(4)) .
            '.' .
            $extension;

        $targetPath =
            $targetDir .
            DIRECTORY_SEPARATOR .
            $fileName;

        $file->move(
            $targetDir,
            $fileName
        );

        try {

            $rows = $this->parseExcelRows(
                $targetPath
            );

        } catch (\RuntimeException $e) {

            return redirect()->to(site_url('dashboard'))
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        $database = db_connect();

        $inserted = 0;

        foreach ($rows as $row) {

            $record = [

                'Clinic_name' => trim(
                    (string) ($row['F']['value'] ?? '')
                ),

                'Address' => trim(
                    (string) ($row['G']['value'] ?? '')
                ),

                'Province' => trim(
                    (string) ($row['H']['value'] ?? '')
                ),

                'Machine' => trim(
                    (string) ($row['K']['value'] ?? '')
                ),

                'Model' => trim(
                    (string) ($row['L']['value'] ?? '')
                ),

                'Installed_date' =>
                    $this->normalizeExcelDate(
                        (string) ($row['C']['value'] ?? '')
                    ),

                'SN' => trim(
                    (string) ($row['N']['value'] ?? '')
                ),

                'DR_Number' =>
                    $this->normalizeDrNumber(
                        (string) ($row['D']['value'] ?? '')
                    ),

                'status' => 'A',
            ];

            if (!$this->hasMeaningfulImportValue($record)) {
                continue;
            }

            $existing = $database->table('tb_data')

                ->where(
                    'Clinic_name',
                    $record['Clinic_name']
                )

                ->where(
                    'Address',
                    $record['Address']
                )

                ->where(
                    'Province',
                    $record['Province']
                )

                ->where(
                    'Machine',
                    $record['Machine']
                )

                ->where(
                    'Model',
                    $record['Model']
                )

                ->where(
                    'Installed_date',
                    $record['Installed_date']
                )

                ->where(
                    'SN',
                    $record['SN']
                )

                ->where(
                    'DR_Number',
                    $record['DR_Number']
                )

                ->get()
                ->getRowArray();

            if ($existing) {
                continue;
            }

            $database->table('tb_data')
                ->insert($record);

            $inserted++;
        }

        return redirect()->to(site_url('dashboard'))
            ->with(
                'success',
                'Imported ' .
                $inserted .
                ' record(s) successfully.'
            );
    }


    // ==============================================================
    // PMS
    // ==============================================================

    public function pms(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {

            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        // ----------------------------------------------------------
        // USERS
        // ----------------------------------------------------------

        $users = [];

        if ($database->tableExists('tb_user')) {

            $users = $database->table('tb_user')
                ->select('id,fname,lname')
                ->orderBy('fname', 'ASC')
                ->get()
                ->getResultArray();
        }

        // ----------------------------------------------------------
        // ACCOUNTS
        // ----------------------------------------------------------

        $accounts = [];

        if ($database->tableExists('tb_data')) {

            $accounts = $database->table('tb_data')
                ->select(
                    'id,Clinic_name,Address,Machine'
                )
                ->orderBy(
                    'Clinic_name',
                    'ASC'
                )
                ->get()
                ->getResultArray();
        }

        // ----------------------------------------------------------
        // PMS RECORDS
        // ----------------------------------------------------------

        $pmsRecords = [];

        if ($database->tableExists('tb_pms')) {

            $pmsRecords = $database->query(
                "SELECT
                    p.id,
                    p.pms_number,
                    p.service_eng_id,
                    p.data_id,
                    p.address,
                    p.date,
                    p.machine_type,
                    p.technical_done,
                    u.fname,
                    u.lname,
                    d.Clinic_name

                 FROM tb_pms p

                 LEFT JOIN tb_user u
                    ON u.id = p.service_eng_id

                 LEFT JOIN tb_data d
                    ON d.id = p.data_id

                 ORDER BY
                    p.date DESC,
                    p.id DESC"
            )->getResultArray();
        }

        return view('dashboard/pms', [

            'user' => session()->get('user'),

            'users' => $users,

            'accounts' => $accounts,

            'pms_records' => $pmsRecords,
        ]);
    }


    // ==============================================================
    // SAVE PMS
    // ==============================================================

    public function savePms(): RedirectResponse
    {
        if (!session()->get('logged_in')) {

            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        // ----------------------------------------------------------
        // CREATE TABLE IF NOT EXISTS
        // ----------------------------------------------------------

        if (!$database->tableExists('tb_pms')) {

            $database->query(
                "CREATE TABLE IF NOT EXISTS tb_pms (

                    id INT AUTO_INCREMENT PRIMARY KEY,

                    pms_number VARCHAR(255)
                        DEFAULT NULL,

                    service_tech VARCHAR(255)
                        DEFAULT NULL,

                    clinic VARCHAR(255)
                        DEFAULT NULL,

                    address VARCHAR(255)
                        DEFAULT NULL,

                    date DATE
                        DEFAULT NULL,

                    machine VARCHAR(255)
                        DEFAULT NULL,

                    status VARCHAR(255)
                        DEFAULT NULL,

                    created_at TIMESTAMP
                        DEFAULT CURRENT_TIMESTAMP

                ) ENGINE=InnoDB
                DEFAULT CHARSET=utf8mb4"
            );
        }

        $pmsNumber = trim(
            (string) $this->request->getPost(
                'pms_number'
            )
        );

        $serviceEng = (int) $this->request->getPost(
            'service_eng_id'
        );

        $dataId = (int) $this->request->getPost(
            'data_id'
        );

        $address = trim(
            (string) $this->request->getPost(
                'address'
            )
        );

        $date = trim(
            (string) $this->request->getPost(
                'date'
            )
        );

        $machineType = trim(
            (string) $this->request->getPost(
                'machine_type'
            )
        );

        $technicalDone = trim(
            (string) $this->request->getPost(
                'technical_done'
            )
        );

        if (
            $pmsNumber === '' ||
            $serviceEng <= 0 ||
            $dataId <= 0
        ) {

            return redirect()->back()
                ->with(
                    'error',
                    'Please fill required fields: PMS Number, Service Engineer, Account.'
                );
        }

        // ----------------------------------------------------------
        // RESOLVE SERVICE ENGINEER
        // ----------------------------------------------------------

        $serviceName = '';

        if (
            $serviceEng > 0 &&
            $database->tableExists('tb_user')
        ) {

            $u = $database->table('tb_user')
                ->select(
                    'fname,lname,uname'
                )
                ->where(
                    'id',
                    $serviceEng
                )
                ->get()
                ->getRowArray();

            if ($u) {

                $serviceName = trim(
                    ($u['fname'] ?? '') .
                    ' ' .
                    ($u['lname'] ?? '')
                );

                if ($serviceName === '') {

                    $serviceName =
                        $u['uname'] ?? '';
                }
            }
        }

        // ----------------------------------------------------------
        // RESOLVE ACCOUNT
        // ----------------------------------------------------------

        $clinicName = '';

        $machineName = $machineType;

        if (
            $dataId > 0 &&
            $database->tableExists('tb_data')
        ) {

            $d = $database->table('tb_data')
                ->select(
                    'Clinic_name,Address,Machine'
                )
                ->where(
                    'id',
                    $dataId
                )
                ->get()
                ->getRowArray();

            if ($d) {

                $clinicName =
                    $d['Clinic_name'] ?? '';

                $address = $address ?: (
                    $d['Address'] ?? ''
                );

                $machineName =
                    $d['Machine'] ??
                    $machineName;
            }
        }

        // ----------------------------------------------------------
        // CANDIDATE DATA
        // ----------------------------------------------------------

        $candidate = [

            'pms_number' =>
                $pmsNumber,

            'service_tech' =>
                $serviceName,

            'clinic' =>
                $clinicName,

            'address' =>
                $address,

            'date' =>
                $date === ''
                    ? null
                    : $date,

            'machine' =>
                $machineName,

            'status' =>
                $technicalDone,

            // Backward-compatible columns

            'service_eng_id' =>
                $serviceEng,

            'data_id' =>
                $dataId,

            'machine_type' =>
                $machineType,

            'technical_done' =>
                $technicalDone,
        ];

        // ----------------------------------------------------------
        // GET ACTUAL TABLE COLUMNS
        // ----------------------------------------------------------

        $available = [];

        $cols = $database
            ->query(
                'SHOW COLUMNS FROM tb_pms'
            )
            ->getResultArray();

        foreach ($cols as $c) {

            $available[] =
                $c['Field'];
        }

        // ----------------------------------------------------------
        // ONLY INSERT EXISTING COLUMNS
        // ----------------------------------------------------------

        $insert = [];

        foreach ($candidate as $key => $value) {

            if (in_array(
                $key,
                $available,
                true
            )) {

                $insert[$key] =
                    $value;
            }
        }

        if (empty($insert)) {

            return redirect()->back()
                ->with(
                    'error',
                    'No valid columns found to insert into tb_pms.'
                );
        }

        $database->table('tb_pms')
            ->insert($insert);

        return redirect()->to(
            site_url('dashboard/pms')
        )->with(
            'success',
            'PMS record added.'
        );
    }


    // ==============================================================
    // PARSE EXCEL / CSV
    // ==============================================================

    private function parseExcelRows(string $path): array
    {
        $extension = strtolower(
            pathinfo(
                $path,
                PATHINFO_EXTENSION
            )
        );

        // ----------------------------------------------------------
        // CSV
        // ----------------------------------------------------------

        if ($extension === 'csv') {

            $rows = [];

            if (($handle = fopen(
                $path,
                'rb'
            )) === false) {

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

            // Remove header

            if (!empty($rows)) {
                array_shift($rows);
            }

            $mappedRows = [];

            $colLetters = [
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
                'T',
            ];

            foreach ($rows as $row) {

                $mapped = [];

                foreach (
                    $colLetters as $index => $letter
                ) {

                    if (!isset($row[$index])) {
                        continue;
                    }

                    $mapped[$letter] = [
                        'value' =>
                            $row[$index],
                    ];
                }

                if ($mapped !== []) {
                    $mappedRows[] =
                        $mapped;
                }
            }

            return $mappedRows;
        }

        // ----------------------------------------------------------
        // XLSX
        // ----------------------------------------------------------

        if ($extension !== 'xlsx') {

            throw new \RuntimeException(
                'Only .xlsx and .csv files are supported.'
            );
        }

        if (!class_exists('ZipArchive')) {

            throw new \RuntimeException(
                'The ZipArchive extension is required for Excel upload support.'
            );
        }

        $zip = new \ZipArchive();

        if ($zip->open($path) !== true) {

            throw new \RuntimeException(
                'Unable to open Excel file.'
            );
        }

        // ----------------------------------------------------------
        // SHARED STRINGS
        // ----------------------------------------------------------

        $sharedStrings = [];

        $sharedXml = $zip->getFromName(
            'xl/sharedStrings.xml'
        );

        if ($sharedXml !== false) {

            $sharedStringXml =
                simplexml_load_string(
                    $sharedXml
                );

            if ($sharedStringXml !== false) {

                $sharedStringXml->registerXPathNamespace(
                    'a',
                    'http://schemas.openxmlformats.org/spreadsheetml/2006/main'
                );

                foreach (
                    $sharedStringXml->xpath('//a:si') as $si
                ) {

                    $text = '';

                    foreach (
                        $si->xpath('.//a:t') as $t
                    ) {

                        $text .= (string) $t;
                    }

                    $sharedStrings[] =
                        $text;
                }
            }
        }

        // ----------------------------------------------------------
        // WORKBOOK
        // ----------------------------------------------------------

        $workbookContent =
            $zip->getFromName(
                'xl/workbook.xml'
            );

        $workbookXml =
            simplexml_load_string(
                $workbookContent
            );

        if ($workbookXml === false) {

            $zip->close();

            throw new \RuntimeException(
                'The workbook could not be read.'
            );
        }

        $ns = $workbookXml
            ->getNamespaces(true);

        $workbookXml
            ->registerXPathNamespace(
                'main',
                $ns['']
            );

        // ----------------------------------------------------------
        // FIND SHEET
        // ----------------------------------------------------------

        $sheetPath = null;

        $preferredSheets = [
            'xl/worksheets/sheet1.xml',
            'xl/worksheets/sheet.xml',
        ];

        foreach (
            $preferredSheets as $candidate
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

        if ($sheetPath === null) {

            for (
                $i = 0;
                $i < $zip->numFiles;
                $i++
            ) {

                $entry =
                    $zip->getNameIndex($i);

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

        // ----------------------------------------------------------
        // WORKBOOK RELATIONSHIP FALLBACK
        // ----------------------------------------------------------

        if ($sheetPath === null) {

            $sheet = $workbookXml->xpath(
                '//main:sheet[@name="Sheet1"]'
            );

            if (empty($sheet)) {

                $sheet =
                    $workbookXml->xpath(
                        '//main:sheet[1]'
                    );
            }

            if (!empty($sheet)) {

                $relationshipsNamespace =
                    'http://schemas.openxmlformats.org/officeDocument/2006/relationships';

                $sheetId =
                    (string) $sheet[0]
                        ->attributes(
                            $relationshipsNamespace,
                            true
                        )->id;

                $relsContent =
                    $zip->getFromName(
                        'xl/_rels/workbook.xml.rels'
                    );

                $relsXml =
                    simplexml_load_string(
                        $relsContent
                    );

                if ($relsXml !== false) {

                    foreach (
                        $relsXml->Relationship
                        as $relationship
                    ) {

                        if (
                            (string) $relationship['Id']
                            === $sheetId
                        ) {

                            $sheetTarget =
                                (string) $relationship['Target'];

                            $sheetPath =
                                'xl/' .
                                ltrim(
                                    $sheetTarget,
                                    '/'
                                );

                            break;
                        }
                    }
                }
            }
        }

        if (
            $sheetPath === null ||
            $zip->locateName($sheetPath) === false
        ) {

            $zip->close();

            throw new \RuntimeException(
                'The Excel sheet could not be mapped to a file.'
            );
        }

        // ----------------------------------------------------------
        // READ SHEET
        // ----------------------------------------------------------

        $sheetContent =
            $zip->getFromName(
                $sheetPath
            );

        $sheetXml =
            simplexml_load_string(
                $sheetContent
            );

        $zip->close();

        if ($sheetXml === false) {

            throw new \RuntimeException(
                'The Excel sheet data could not be loaded.'
            );
        }

        $rows = [];

        $rowIndex = 0;

        foreach (
            $sheetXml->sheetData->row as $row
        ) {

            $rowIndex++;

            // Skip header

            if ($rowIndex === 1) {
                continue;
            }

            $parsedRow = [];

            foreach ($row->c as $cell) {

                $cellReference =
                    (string) $cell['r'];

                $column = preg_replace(
                    '/\d+$/',
                    '',
                    $cellReference
                );

                if ($column === '') {
                    continue;
                }

                $cellType =
                    (string) $cell['t'];

                $value = '';

                if ($cellType === 's') {

                    $index = (int) (
                        (string) $cell->v
                    );

                    $value =
                        $sharedStrings[$index]
                        ?? '';

                } elseif (
                    $cellType === 'inlineStr'
                ) {

                    $value =
                        (string) $cell->is->t;

                } else {

                    $value =
                        (string) $cell->v;
                }

                $parsedRow[
                    strtoupper($column)
                ] = [
                    'value' =>
                        $value,
                ];
            }

            if ($parsedRow !== []) {

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

        // Already YYYY-MM-DD

        $date = \DateTime::createFromFormat(
            'Y-m-d',
            $value
        );

        if (
            $date !== false &&
            $date->format('Y-m-d') === $value
        ) {

            return $value;
        }

        // Common date formats

        $formats = [
            'm/d/Y',
            'd/m/Y',
            'm-d-Y',
            'd-m-Y',
            'Y/m/d',
            'Y.m.d',
        ];

        foreach ($formats as $format) {

            $date = \DateTime::createFromFormat(
                $format,
                $value
            );

            if (
                $date !== false &&
                $date->format($format) === $value
            ) {

                return $date->format('Y-m-d');
            }
        }

        // Excel serial number

        if (
            preg_match(
                '/^\d+(?:\.\d+)?$/',
                $value
            )
        ) {

            $serial = (float) $value;

            if ($serial > 0) {

                $baseDate = new \DateTime(
                    '1899-12-30'
                );

                $baseDate->modify(
                    '+' .
                    (int) floor($serial) .
                    ' days'
                );

                return $baseDate->format(
                    'Y-m-d'
                );
            }
        }

        return $value;
    }


    // ==============================================================
    // NORMALIZE DR NUMBER
    // ==============================================================

    private function normalizeDrNumber(
        string $value
    ): string {

        $value = trim($value);

        if ($value === '') {
            return '';
        }

        $value = preg_replace(
            '/\s+/',
            '',
            $value
        );

        if (
            $value === null ||
            $value === ''
        ) {

            return '';
        }

        $upperValue =
            strtoupper($value);

        if (
            preg_match(
                '/^(DR|AR)/i',
                $upperValue
            ) === 1
        ) {

            return $upperValue;
        }

        return 'DR' . $upperValue;
    }


    // ==============================================================
    // CHECK MEANINGFUL VALUES
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

            '-',
        ];

        foreach ($record as $value) {

            $trimmed = trim(
                (string) $value
            );

            if ($trimmed === '') {
                continue;
            }

            $lower =
                strtolower($trimmed);

            if (
                in_array(
                    $lower,
                    $emptyValues,
                    true
                )
            ) {

                continue;
            }

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
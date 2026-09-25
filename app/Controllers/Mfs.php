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
}

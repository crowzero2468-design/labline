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
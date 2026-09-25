<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class SupportController extends BaseController
{
    public function __construct()
    {
        $this->ensureSupportTable();
    }

    public function index(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();
        $this->ensureSupportTable();

        $search = trim((string) ($this->request->getGet('search') ?? ''));
        $builder = $database->table('tb_support');

        $today = date('Y-m-d');
            $builder->groupStart()

                // Today's tickets — show all statuses
                ->where('support_date', $today)

                // Previous tickets
                ->orGroupStart()

                    ->where('support_date <', $today)

                    ->groupStart()

                        // Waiting and ongoing
                        ->whereIn('status', ['waiting', 'ongoing'])

                        // Pullout only if not yet returned
                        ->orGroupStart()
                            ->where('status', 'pullout')
                            ->where('returnstat IS NULL', null, false)
                        ->groupEnd()

                    ->groupEnd()

                ->groupEnd()

            ->groupEnd();

        if ($search !== '') {
            $builder->groupStart()
                ->like('clinic_name', $search)
                ->orLike('machine', $search)
                ->orLike('technician', $search)
                ->orLike('concern', $search)
                ->orLike('status', $search)
                ->groupEnd();
        }

        $tickets = $builder
            ->orderBy('support_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        $clinics = $database->table('tb_data')
            ->select('Clinic_name')
            ->where('Clinic_name !=', '')
            ->where('Clinic_name IS NOT NULL', null, false)
            ->where('status', 'A')
            ->groupBy('Clinic_name')
            ->orderBy('Clinic_name', 'ASC')
            ->get()
            ->getResultArray();

        $machines = $database->table('tb_data')
            ->select('Machine')
            ->where('Machine !=', '')
            ->where('Machine IS NOT NULL', null, false)
            ->groupBy('Machine')
            ->orderBy('Machine', 'ASC')
            ->get()
            ->getResultArray();

        $techs = $database->table('tb_user')
            ->select('id, fname, lname, uname, role')
            ->orderBy('fname', 'ASC')
            ->orderBy('lname', 'ASC')
            ->get()
            ->getResultArray();

        return view('dashboard/support', [
            'user' => session()->get('user'),
            'tickets' => $tickets,
            'clinics' => $clinics,
            'machines' => $machines,
            'techs' => $techs,
            'search' => $search,
        ]);
    }

    public function store(): RedirectResponse
{
    if (!session()->get('logged_in')) {
        return redirect()->to(site_url('login'))
            ->with('error', 'Please login first.');
    }

    $clinic = trim((string) $this->request->getPost('clinic_name'));
    $machine = trim((string) $this->request->getPost('machine'));
    $technician = trim((string) $this->request->getPost('technician'));
    $concern = trim((string) $this->request->getPost('concern'));
    $supportDate = trim((string) $this->request->getPost('support_date'));

    if (
        $clinic === '' ||
        $machine === '' ||
        $technician === '' ||
        $concern === ''
    ) {
        return redirect()->to(site_url('dashboard/support'))
            ->with('error', 'Please complete all support ticket fields.');
    }

    if ($supportDate === '') {
        $supportDate = date('Y-m-d');
    }

    $database = db_connect();
    $supportTable = $database->table('tb_support');

    /*
    |--------------------------------------------------------------------------
    | Generate unique ticket number
    |--------------------------------------------------------------------------
    */

    $prefix = 'SUP-';

    // Get the highest existing ticket number
    $lastTicket = $supportTable
        ->select('ticket_number')
        ->like('ticket_number', $prefix, 'after')
        ->orderBy('ticket_number', 'DESC')
        ->get()
        ->getRowArray();

    if ($lastTicket && !empty($lastTicket['ticket_number'])) {

        $lastNumber = (int) str_replace(
            $prefix,
            '',
            $lastTicket['ticket_number']
        );

        $nextNumber = $lastNumber + 1;

    } else {

        $nextNumber = 1;

    }

    /*
    |--------------------------------------------------------------------------
    | Make sure the generated number does not already exist
    |--------------------------------------------------------------------------
    */

    do {

        $ticketNumber = $prefix . str_pad(
            $nextNumber,
            6,
            '0',
            STR_PAD_LEFT
        );

        $existingTicket = $supportTable
            ->where('ticket_number', $ticketNumber)
            ->countAllResults();

        if ($existingTicket > 0) {
            $nextNumber++;
        }

    } while ($existingTicket > 0);

    /*
    |--------------------------------------------------------------------------
    | Save ticket
    |--------------------------------------------------------------------------
    */

    $supportTable->insert([
        'ticket_number' => $ticketNumber,
        'clinic_name'    => $clinic,
        'machine'        => $machine,
        'technician'     => $technician,
        'concern'        => $concern,
        'support_date'   => $supportDate,
        'status'         => 'waiting',
    ]);

    return redirect()->to(site_url('dashboard/support'))
        ->with(
            'success',
            'Support ticket ' . $ticketNumber .
            ' added successfully. It is now waiting for technician acceptance.'
        );
}

   public function updateStatus(): RedirectResponse
{
    if (!session()->get('logged_in')) {
        return redirect()->to(site_url('login'))
            ->with('error', 'Please login first.');
    }

    $id = (int) $this->request->getPost('id');

    $status = strtolower(
        trim((string) $this->request->getPost('status'))
    );

    $remarks = trim(
        (string) $this->request->getPost('remarks')
    );

    $returnstat = strtolower(
        trim((string) $this->request->getPost('returnstat'))
    );

    $allowedStatuses = [
        'waiting',
        'ongoing',
        'done',
        'pullout',
        'unservicable',
        'canceled'
    ];

    if (
        $id <= 0 ||
        !in_array($status, $allowedStatuses, true)
    ) {
        return redirect()->to(site_url('dashboard/support'))
            ->with('error', 'Invalid support status update.');
    }

    /*
    |--------------------------------------------------------------------------
    | RETURN PULLOUT
    |--------------------------------------------------------------------------
    */

    if ($returnstat === 'return') {

        $data = [
            'returnstat' => 'return',
            'update_date' => date('Y-m-d H:i:s'),
            'status_updated_at' => date('Y-m-d H:i:s')
        ];

        db_connect()
            ->table('tb_support')
            ->where('id', $id)
            ->update($data);

        return redirect()->to(site_url('dashboard/support'))
            ->with(
                'success',
                'Support ticket marked as returned.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | REQUIRE REMARKS
    |--------------------------------------------------------------------------
    */

    if (
        in_array(
            $status,
            ['done', 'unservicable'],
            true
        ) &&
        $remarks === ''
    ) {
        return redirect()->to(site_url('dashboard/support'))
            ->with(
                'error',
                'Please add remarks before marking this ticket as Done or Unservicable.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    */

    $data = [
        'status' => $status,
        'status_updated_at' => date('Y-m-d H:i:s')
    ];

    if ($status === 'ongoing') {
        $data['accepted_at'] = date('Y-m-d H:i:s');
    }

    if ($remarks !== '') {
        $data['remarks'] = $remarks;
    }

    db_connect()
        ->table('tb_support')
        ->where('id', $id)
        ->update($data);

    return redirect()->to(site_url('dashboard/support'))
        ->with(
            'success',
            'Support status updated to ' . $status . '.'
        );
}

    public function history(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();
        $search = trim((string) ($this->request->getGet('search') ?? ''));
        $dateFrom = trim((string) ($this->request->getGet('date_from') ?? ''));
        $dateTo = trim((string) ($this->request->getGet('date_to') ?? ''));
        $builder = $database->table('tb_support');

        if ($dateFrom !== '') {
            $builder->where('support_date >=', $dateFrom);
        }

        if ($dateTo !== '') {
            $builder->where('support_date <=', $dateTo);
        }

        if ($search !== '') {
            $builder->groupStart()
                ->like('clinic_name', $search)
                ->orLike('machine', $search)
                ->orLike('technician', $search)
                ->orLike('concern', $search)
                ->orLike('status', $search)
                ->orLike('support_date', $search)
                ->groupEnd();
        }

        $tickets = $builder
            ->orderBy('support_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        $clinicCountsBuilder = $database->table('tb_support')
            ->select('clinic_name, COUNT(*) as total')
            ->where('clinic_name !=', '')
            ->where('clinic_name IS NOT NULL', null, false);

        if ($dateFrom !== '') {
            $clinicCountsBuilder->where('support_date >=', $dateFrom);
        }

        if ($dateTo !== '') {
            $clinicCountsBuilder->where('support_date <=', $dateTo);
        }

        $clinicCounts = $clinicCountsBuilder
            ->groupBy('clinic_name')
            ->orderBy('clinic_name', 'ASC')
            ->get()
            ->getResultArray();

        return view('dashboard/history', [
            'user' => session()->get('user'),
            'tickets' => $tickets,
            'clinic_counts' => $clinicCounts,
            'search' => $search,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ]);
    }

    public function exportHistory()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();
        $dateFrom = trim((string) ($this->request->getGet('date_from') ?? ''));
        $dateTo = trim((string) ($this->request->getGet('date_to') ?? ''));

        $builder = $database->table('tb_support')
            ->select('id, clinic_name, machine, technician, concern, support_date, status, created_at');

        if ($dateFrom !== '') {
            $builder->where('support_date >=', $dateFrom);
        }

        if ($dateTo !== '') {
            $builder->where('support_date <=', $dateTo);
        }

        $rows = $builder
            ->orderBy('support_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        $filename = 'tb_support_history_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Clinic', 'Machine', 'Technician', 'Concern', 'Support Date', 'Status', 'Created At']);

        foreach ($rows as $row) {
            fputcsv($output, [
                $row['id'] ?? '',
                $row['clinic_name'] ?? '',
                $row['machine'] ?? '',
                $row['technician'] ?? '',
                $row['concern'] ?? '',
                $row['support_date'] ?? '',
                $row['status'] ?? '',
                $row['created_at'] ?? '',
            ]);
        }

        fclose($output);
        exit;
    }

    public function exportClinicCounts()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();
        $dateFrom = trim((string) ($this->request->getGet('date_from') ?? ''));
        $dateTo = trim((string) ($this->request->getGet('date_to') ?? ''));

        $builder = $database->table('tb_support')
            ->select('clinic_name, COUNT(*) as total')
            ->where('clinic_name !=', '')
            ->where('clinic_name IS NOT NULL', null, false);

        if ($dateFrom !== '') {
            $builder->where('support_date >=', $dateFrom);
        }

        if ($dateTo !== '') {
            $builder->where('support_date <=', $dateTo);
        }

        $rows = $builder
            ->groupBy('clinic_name')
            ->orderBy('clinic_name', 'ASC')
            ->get()
            ->getResultArray();

        $filename = 'tb_support_clinic_counts_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Clinic', 'Count']);

        foreach ($rows as $row) {
            fputcsv($output, [
                $row['clinic_name'] ?? '',
                $row['total'] ?? 0,
            ]);
        }

        fclose($output);
        exit;
    }

    private function ensureSupportTable(): void
    {
        $database = db_connect();

        $database->query(
            "CREATE TABLE IF NOT EXISTS tb_support (
                id INT AUTO_INCREMENT PRIMARY KEY,
                clinic_name VARCHAR(255) NULL,
                machine VARCHAR(255) NULL,
                technician VARCHAR(255) NULL,
                concern TEXT NULL,
                remarks TEXT NULL,
                support_date DATE NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'waiting',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );

        $fieldResult = $database->query("SHOW COLUMNS FROM tb_support LIKE 'status'");
        if ($fieldResult->getNumRows() === 0) {
            $database->query("ALTER TABLE tb_support ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'waiting' AFTER concern");
        }

        $remarksFieldResult = $database->query("SHOW COLUMNS FROM tb_support LIKE 'remarks'");
        if ($remarksFieldResult->getNumRows() === 0) {
            $database->query("ALTER TABLE tb_support ADD COLUMN remarks TEXT NULL AFTER concern");
        }

        $acceptedAtFieldResult = $database->query("SHOW COLUMNS FROM tb_support LIKE 'accepted_at'");
        if ($acceptedAtFieldResult->getNumRows() === 0) {
            $database->query("ALTER TABLE tb_support ADD COLUMN accepted_at DATETIME NULL AFTER created_at");
        }

        $statusUpdatedAtFieldResult = $database->query("SHOW COLUMNS FROM tb_support LIKE 'status_updated_at'");
        if ($statusUpdatedAtFieldResult->getNumRows() === 0) {
            $database->query("ALTER TABLE tb_support ADD COLUMN status_updated_at DATETIME NULL AFTER accepted_at");
        }

        $returnDateFieldResult = $database->query("SHOW COLUMNS FROM tb_support LIKE 'update_date'");
        if ($returnDateFieldResult->getNumRows() > 0) {
            $database->query("ALTER TABLE tb_support MODIFY COLUMN update_date DATETIME NULL");
        }
    }
}

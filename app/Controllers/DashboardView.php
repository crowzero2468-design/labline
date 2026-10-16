<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class DashboardView extends BaseController
{
    public function index(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

        $totalData = 0;

        if ($database->tableExists('tb_data')) {
            $provinceBuilder = $database->table('tb_data');
            $provinceBuilder
                ->where('status', 'A')
                ->where('Province IS NOT NULL')
                ->where("TRIM(Province) !=", '');

            $provinceResult = $provinceBuilder
                ->select('COUNT(DISTINCT LOWER(TRIM(Province))) AS total', false)
                ->get()
                ->getRow();

            $totalData = (int) ($provinceResult->total ?? 0);
        }

        $totalMachine = 0;

        if ($database->tableExists('tb_data')) {
            $clinicBuilder = $database->table('tb_data');
            $clinicBuilder
                ->where('status', 'A')
                ->where('Clinic_name IS NOT NULL')
                ->where("TRIM(Clinic_name) !=", '');

            $clinicResult = $clinicBuilder
                ->select('COUNT(DISTINCT LOWER(TRIM(Clinic_name))) AS total', false)
                ->get()
                ->getRow();

            $totalMachine = (int) ($clinicResult->total ?? 0);
        }

        $machineCounts = [];

        if ($database->tableExists('tb_data')) {
            $machineCounts = $database->table('tb_data')
                ->select(
                    "CASE
                        WHEN Machine IN ('Hematology', 'Hematology Analyzer') THEN 'Hematology Analyzer'
                        WHEN Machine IN ('Chemistry', 'Chemistry Analyzer') THEN 'Chemistry Analyzer'
                        WHEN Machine IN ('Urine', 'Urine Analyzer', 'VU10') THEN 'Urine Analyzer'
                        WHEN Machine IN ('Ultrasound', 'UTZ') THEN 'Ultrasound'
                        WHEN Machine = 'Xray' THEN 'Xray'
                    END AS machine_label, COUNT(*) AS total",
                    false
                )
                ->where('status', 'A')
                ->whereIn('Machine', [
                    'Hematology',
                    'Hematology Analyzer',
                    'Chemistry',
                    'Chemistry Analyzer',
                    'Urine',
                    'Urine Analyzer',
                    'VU10',
                    'Xray',
                    'Ultrasound',
                    'UTZ',
                ])
                ->groupBy('machine_label')
                ->orderBy('total', 'DESC')
                ->get()
                ->getResultArray();
        }

        $ongoingTicketCount = 0;
        $pulloutTicketCount = 0;
        $onHoldTicketCount = 0;
        $returnedTicketCount = 0;
        $completedTicketCount = 0;

        $userCount = 0;
        $pmsCount = 0;
        $mfsCount = 0;
        $fsrCount = 0;
        $rotorCount = 0;

        if ($database->tableExists('tb_user')) {
            $userCount = (int) $database->table('tb_user')
                ->where('uname !=', 'admin')
                ->countAllResults();
        }

        if ($database->tableExists('tb_pms')) {
            $pmsCount = (int) $database->table('tb_pms')->countAllResults();
        }

        if ($database->tableExists('tb_mfs')) {
            $mfsCount = (int) $database->table('tb_mfs')->countAllResults();
        }

        if ($database->tableExists('tb_fsr')) {
            $fsrCount = (int) $database->table('tb_fsr')->countAllResults();
        }

        if ($database->tableExists('tb_rotor')) {
            $rotorCount = (int) $database->table('tb_rotor')->countAllResults();
        }

        if ($database->tableExists('tb_support')) {
            $supportTable = $database->table('tb_support');

            $ongoingTicketCount = (int) $supportTable
                ->where('status', 'ongoing')
                ->countAllResults();

            $pulloutTicketCount = (int) $supportTable
                ->where('status', 'pullout')
                ->countAllResults();

            $onHoldTicketCount = (int) $supportTable
                ->groupStart()
                ->where('status', 'on_hold')
                ->orWhere('status', 'waiting')
                ->groupEnd()
                ->countAllResults();

            $returnedTicketCount = (int) $supportTable
                ->where('returnstat', 'return')
                ->countAllResults();

            $completedTicketCount = (int) $supportTable
                ->where('status', 'done')
                ->countAllResults();
        }

        $moduleDetails = [];
        $moduleLookup = [
            'Users' => ['table' => 'tb_user', 'preferred' => ['id', 'fname', 'lname', 'status']],
            'PMS' => ['table' => 'tb_pms', 'preferred' => ['id', 'clinic', 'machine', 'service_engineer', 'date', 'remarks']],
            'MFS' => ['table' => 'tb_mfs', 'preferred' => ['id', 'mfs_number', 'clinic', 'service_eng', 'date', 'remarks']],
            'FSR' => ['table' => 'tb_fsr', 'preferred' => ['id', 'fsr_number', 'clinic', 'service_eng', 'date', 'remarks']],
            'Rotor' => ['table' => 'tb_rotor', 'preferred' => ['id', 'clinic', 'machine', 'date', 'status', 'remarks']],
        ];

        foreach ($moduleLookup as $label => $config) {
            $tableName = $config['table'];
            if (!$database->tableExists($tableName)) {
                $moduleDetails[$label] = [];
                continue;
            }

            $columns = $database->getFieldNames($tableName);
            $selected = [];

            foreach ($config['preferred'] as $column) {
                if (in_array($column, $columns, true)) {
                    $selected[] = $column;
                }
            }

            if ($selected === []) {
                $selected = array_slice($columns, 0, 6);
            }

            $query = $database->table($tableName)
                ->select(implode(',', $selected))
                ->orderBy('id', 'DESC');

            if ($label === 'Users') {
                $query->where('uname !=', 'admin');
            }

            $rows = $query->get()->getResultArray();

            $moduleDetails[$label] = $rows;
        }

        $monthlySupport = [];
        $pulloutTimeline = [];
        $machineYearly = [];

        if ($database->tableExists('tb_support')) {
            $monthlySupport = $database->query(
                "SELECT DATE_FORMAT(support_date, '%Y-%m') AS period, COUNT(*) AS total
                 FROM tb_support
                 WHERE support_date IS NOT NULL
                 GROUP BY period
                 ORDER BY period ASC"
            )->getResultArray();

            $pulloutTimeline = $database->query(
                "SELECT DATE_FORMAT(COALESCE(update_date, support_date), '%Y-%m') AS period, COUNT(*) AS total
                 FROM tb_support
                 WHERE status = 'pullout'
                     AND COALESCE(update_date, support_date) IS NOT NULL
                 GROUP BY period
                 ORDER BY period ASC"
            )->getResultArray();
        }

        if ($database->tableExists('tb_data')) {
            $machineYearly = $database->query(
                "SELECT YEAR(Installed_date) AS year, Machine AS machine, COUNT(*) AS total
                 FROM tb_data
                 WHERE status = 'A'
                     AND Installed_date IS NOT NULL
                     AND Machine IS NOT NULL
                     AND TRIM(Machine) != ''
                 GROUP BY year, machine
                 ORDER BY year ASC, machine ASC"
            )->getResultArray();
        }

        return view('dashboard/dashboard', [
            'user' => session()->get('user'),
            'total_data' => $totalData,
            'total_machine' => $totalMachine,
            'ongoing_ticket_count' => $ongoingTicketCount,
            'pullout_ticket_count' => $pulloutTicketCount,
            'on_hold_ticket_count' => $onHoldTicketCount,
            'returned_ticket_count' => $returnedTicketCount,
            'completed_ticket_count' => $completedTicketCount,
            'user_count' => $userCount,
            'pms_count' => $pmsCount,
            'mfs_count' => $mfsCount,
            'fsr_count' => $fsrCount,
            'rotor_count' => $rotorCount,
            'machine_counts' => $machineCounts,
            'monthly_support' => $monthlySupport,
            'pullout_timeline' => $pulloutTimeline,
            'machine_yearly' => $machineYearly,
            'module_details' => $moduleDetails,
            'start_date' => '',
            'end_date' => '',
        ]);
    }
}

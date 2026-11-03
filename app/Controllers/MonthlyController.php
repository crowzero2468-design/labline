<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MonthlyController extends BaseController
{
    public function index()
    {
        return view('dashboard/monitoring', $this->getMonitoringData());
    }

    public function printReport()
    {
        return view('dashboard/monitoring_print', $this->getMonitoringData());
    }

    private function getMonitoringData(): array
    {
        $db = \Config\Database::connect();

        $selectedModule = strtolower(
            trim((string) ($this->request->getGet('module') ?? 'pms'))
        );

        $allowedModules = ['pms', 'fsr', 'mfs'];
        if (!in_array($selectedModule, $allowedModules, true)) {
            $selectedModule = 'pms';
        }

        $moduleLabels = [
            'pms' => 'PMS',
            'fsr' => 'FSR',
            'mfs' => 'MFS',
        ];

        $selectedMachine = trim(
            $this->request->getGet('machine') ?? ''
        );

        $tableMap = [
            'pms' => [
                'table' => 'tb_pms',
                'clinic' => 'clinic',
                'date' => 'date',
                'machine' => 'machine',
            ],
            'fsr' => [
                'table' => 'tb_fsr',
                'clinic' => 'account',
                'date' => 'date',
                'machine' => 'machine',
            ],
            'mfs' => [
                'table' => 'tb_mfs',
                'clinic' => 'accounts',
                'date' => 'date_fillup',
                'machine' => 'machine',
            ],
        ];

        $moduleConfig = $tableMap[$selectedModule];
        $tableName = $moduleConfig['table'];
        $clinicField = $moduleConfig['clinic'];
        $dateField = $moduleConfig['date'];
        $machineField = $moduleConfig['machine'];

        $tableColumns = $db->getFieldNames($tableName);
        $statusField = 'status';

        if (!in_array('status', $tableColumns, true)) {
            foreach (['reason', 'technical_concern', 'remarks', 'acknowledge'] as $candidate) {
                if (in_array($candidate, $tableColumns, true)) {
                    $statusField = $candidate;
                    break;
                }
            }
        }

        $machines = $db->table($tableName)
            ->select($machineField . ' AS machine')
            ->where($machineField . ' IS NOT NULL')
            ->where($machineField . ' !=', '')
            ->groupBy($machineField)
            ->orderBy($machineField, 'ASC')
            ->get()
            ->getResultArray();

        $clinics = $db->table('tb_data')
            ->select('Clinic_name, address, province')
            ->where('Clinic_name IS NOT NULL')
            ->where('Clinic_name !=', '')
            ->groupBy([
                'Clinic_name',
                'address',
                'province'
            ])
            ->orderBy('Clinic_name', 'ASC')
            ->where('status', 'A')
            ->get()
            ->getResultArray();

        $moduleBuilder = $db->table($tableName);

        $statusAlias = $statusField;
        if ($statusField === 'remarks') {
            $statusAlias = 'status';
        }

        $moduleBuilder->select([
            $clinicField . ' AS clinic',
            $dateField . ' AS date',
            $statusField . ' AS ' . $statusAlias,
            $machineField . ' AS machine',
        ]);

        $moduleBuilder
            ->where($clinicField . ' IS NOT NULL')
            ->where($clinicField . ' !=', '')
            ->where($dateField . ' IS NOT NULL');

        if ($selectedMachine !== '') {
            $moduleBuilder->where($machineField, $selectedMachine);
        }

        $moduleRecords = $moduleBuilder
            ->orderBy($dateField, 'ASC')
            ->get()
            ->getResultArray();

        $monthlyStatus = [];

        foreach ($moduleRecords as $record) {
            if (empty($record['clinic']) || empty($record['date'])) {
                continue;
            }

            $clinic = trim((string) $record['clinic']);
            $timestamp = strtotime((string) $record['date']);

            if ($timestamp === false) {
                continue;
            }

            $month = (int) date('n', $timestamp);
            $statusValue = trim((string) ($record['status'] ?? $record[$statusAlias] ?? ''));

            $monthlyStatus[$clinic][$month][] = [
                'status' => $statusValue,
                'date' => $record['date'],
                'machine' => trim((string) ($record['machine'] ?? '')),
            ];
        }

        foreach ($clinics as &$clinic) {
            $clinicName = trim((string) ($clinic['Clinic_name'] ?? ''));
            $clinic['months'] = [];

            for ($month = 1; $month <= 12; $month++) {
                $clinic['months'][$month] = $monthlyStatus[$clinicName][$month] ?? [];
            }
        }

        unset($clinic);

        return [
            'clinics' => $clinics,
            'machines' => $machines,
            'selectedMachine' => $selectedMachine,
            'selectedModule' => $selectedModule,
            'moduleLabel' => $moduleLabels[$selectedModule],
        ];
    }

}

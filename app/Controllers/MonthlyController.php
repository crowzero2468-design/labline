<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MonthlyController extends BaseController
{
    
    public function index()
    {
        $db = \Config\Database::connect();

        /*
        |--------------------------------------------------------------------------
        | Selected Machine
        |--------------------------------------------------------------------------
        */

        $selectedMachine = trim(
            $this->request->getGet('machine') ?? ''
        );


        /*
        |--------------------------------------------------------------------------
        | Get Machine List
        |--------------------------------------------------------------------------
        */

        $machines = $db->table('tb_pms')
            ->select('machine')
            ->where('machine IS NOT NULL')
            ->where('machine !=', '')
            ->groupBy('machine')
            ->orderBy('machine', 'ASC')
            ->get()
            ->getResultArray();


        /*
        |--------------------------------------------------------------------------
        | Get Clinics from tb_data
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Get PMS Records
        |--------------------------------------------------------------------------
        */

        $pmsBuilder = $db->table('tb_pms');

        $pmsBuilder->select([
            'clinic',
            'date',
            'status',
            'machine'
        ]);

        $pmsBuilder
            ->where('clinic IS NOT NULL')
            ->where('clinic !=', '')
            ->where('date IS NOT NULL');


        /*
        |--------------------------------------------------------------------------
        | MACHINE FILTER
        |--------------------------------------------------------------------------
        |
        | When a machine is selected:
        |
        | tb_pms.machine = selected machine
        |
        |--------------------------------------------------------------------------
        */

        if ($selectedMachine !== '') {

            $pmsBuilder->where(
                'machine',
                $selectedMachine
            );

        }


        $pmsRecords = $pmsBuilder
            ->orderBy('date', 'ASC')
            ->get()
            ->getResultArray();


        /*
        |--------------------------------------------------------------------------
        | Organize PMS Records
        |--------------------------------------------------------------------------
        |
        | clinic
        |    month
        |        status
        |
        |--------------------------------------------------------------------------
        */

        $monthlyStatus = [];

        foreach ($pmsRecords as $pms) {

            if (
                empty($pms['clinic']) ||
                empty($pms['date'])
            ) {
                continue;
            }


            $clinic = trim($pms['clinic']);


            $timestamp = strtotime($pms['date']);

            if ($timestamp === false) {
                continue;
            }


            $month = (int) date(
                'n',
                $timestamp
            );


            $monthlyStatus[$clinic][$month][] = [

                'status' => trim(
                    $pms['status'] ?? ''
                ),

                'date' => $pms['date'],

                'machine' => trim(
                    $pms['machine'] ?? ''
                )

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Attach Monthly Data to Clinics
        |--------------------------------------------------------------------------
        */

        foreach ($clinics as &$clinic) {

            $clinicName = trim(
                $clinic['Clinic_name']
            );


            $clinic['months'] = [];


            for ($month = 1; $month <= 12; $month++) {

                $clinic['months'][$month] =
                    $monthlyStatus[$clinicName][$month] ?? [];

            }
        }

        unset($clinic);


        /*
        |--------------------------------------------------------------------------
        | Send to View
        |--------------------------------------------------------------------------
        */

        $data = [

            'clinics' => $clinics,

            'machines' => $machines,

            'selectedMachine' => $selectedMachine

        ];

        
        return view('dashboard/monitoring', $data);
    }

}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RotorController extends BaseController
{
    protected $db;
    protected $table = 'tb_rotor';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * ==========================================================
     * DISPLAY ROTOR REPLACEMENT RECORDS
     * ==========================================================
     */
    public function index()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        /*
        |--------------------------------------------------------------------------
        | GET ROTOR REPLACEMENT RECORDS
        |--------------------------------------------------------------------------
        */
        $builder = $this->db->table($this->table);

        /*
        |--------------------------------------------------------------------------
        | DATE FILTER
        |--------------------------------------------------------------------------
        */
        if (!empty($startDate)) {
            $builder->where('date >=', $startDate);
        }

        if (!empty($endDate)) {
            $builder->where('date <=', $endDate);
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER
        |--------------------------------------------------------------------------
        */
        $builder->orderBy('date', 'DESC');

        $records = $builder
            ->get()
            ->getResultArray();

        /*
        |--------------------------------------------------------------------------
        | GET CLINIC ACCOUNTS
        |--------------------------------------------------------------------------
        |
        | Source:
        | tb_data
        |
        | clinic_name = Clinic Name
        | address     = Address
        |
        */
        $accounts = $this->db
            ->table('tb_data')
            ->select('id, clinic_name, address, model')
            ->where('clinic_name !=', '')
            ->where('status', 'A')
            ->where('Machine', 'Chemistry')
            ->orderBy('clinic_name', 'ASC')
            ->get()
            ->getResultArray();
        /*
        |--------------------------------------------------------------------------
        | SEND DATA TO VIEW
        |--------------------------------------------------------------------------
        */
        return view('dashboard/reportreplacement', [
            'user'      => session()->get('user'),
            'records'   => $records,
            'accounts'  => $accounts,
            'startDate' => $startDate,
            'endDate'   => $endDate,
        ]);
    }

    /**
     * ==========================================================
     * SAVE ROTOR REPLACEMENT
     * ==========================================================
     */
    public function save()
    {
        /*
        |--------------------------------------------------------------------------
        | GET POST DATA
        |--------------------------------------------------------------------------
        */
        $clinicName  = trim($this->request->getPost('clinic_name'));
        $address     = trim($this->request->getPost('address'));
        $model       = trim($this->request->getPost('model'));
        $rotor       = trim($this->request->getPost('rotor'));
        $lotNumber   = trim($this->request->getPost('lot_number'));
        $productCode = trim($this->request->getPost('product_code'));
        $concern     = trim($this->request->getPost('concern'));
        $date        = $this->request->getPost('date');
        $replaceable = $this->request->getPost('replaceable');
        $reason      = trim($this->request->getPost('reason'));
        $replaced    = $this->request->getPost('replaced');

        /*
        |--------------------------------------------------------------------------
        | VALIDATE REQUIRED FIELDS
        |--------------------------------------------------------------------------
        */
        if (
            empty($clinicName) ||
            empty($model) ||
            empty($date)
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Please select a clinic and fill in the required fields.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PREPARE DATA
        |--------------------------------------------------------------------------
        */
        $data = [
            'clinic_name'  => $clinicName,
            'address'      => $address,
            'model'        => $model,
            'rotor'        => $rotor,
            'lot_number'   => $lotNumber,
            'product_code' => $productCode,
            'concern'      => $concern,
            'date'         => $date,
            'replaceable'  => $replaceable,
            'reason'       => $reason,
            'replaced'     => $replaced,
        ];

        /*
        |--------------------------------------------------------------------------
        | INSERT
        |--------------------------------------------------------------------------
        */
        $insert = $this->db
            ->table($this->table)
            ->insert($data);

        /*
        |--------------------------------------------------------------------------
        | CHECK INSERT
        |--------------------------------------------------------------------------
        */
        if (!$insert) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to save Rotor Replacement Report.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->to(site_url('rotor_replace'))
            ->with(
                'success',
                'Rotor Replacement Report saved successfully.'
            );
    }

    /**
     * ==========================================================
     * UPDATE ROTOR REPLACEMENT
     * ==========================================================
     */
    public function update()
    {
        $id = $this->request->getPost('id');

        /*
        |--------------------------------------------------------------------------
        | VALIDATE ID
        |--------------------------------------------------------------------------
        */
        if (empty($id)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Invalid rotor replacement record.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | GET POST DATA
        |--------------------------------------------------------------------------
        */
        $data = [
            'clinic_name'  => trim($this->request->getPost('clinic_name')),
            'address'      => trim($this->request->getPost('address')),
            'model'        => trim($this->request->getPost('model')),
            'rotor'        => trim($this->request->getPost('rotor')),
            'lot_number'   => trim($this->request->getPost('lot_number')),
            'product_code' => trim($this->request->getPost('product_code')),
            'concern'      => trim($this->request->getPost('concern')),
            'date'         => $this->request->getPost('date'),
            'replaceable'  => $this->request->getPost('replaceable'),
            'reason'       => trim($this->request->getPost('reason')),
            'replaced'     => $this->request->getPost('replaced'),
        ];

        /*
        |--------------------------------------------------------------------------
        | VALIDATE REQUIRED FIELDS
        |--------------------------------------------------------------------------
        */
        if (
            empty($data['clinic_name']) ||
            empty($data['model']) ||
            empty($data['date'])
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Please fill in the required fields.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */
        $updated = $this->db
            ->table($this->table)
            ->where('id', $id)
            ->update($data);

        /*
        |--------------------------------------------------------------------------
        | CHECK UPDATE
        |--------------------------------------------------------------------------
        */
        if (!$updated) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to update Rotor Replacement Report.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->to(site_url('rotor_replace'))
            ->with(
                'success',
                'Rotor Replacement Report updated successfully.'
            );
    }

    /**
     * ==========================================================
     * DELETE ROTOR REPLACEMENT
     * ==========================================================
     */
    public function delete($id)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE ID
        |--------------------------------------------------------------------------
        */
        if (empty($id)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Invalid rotor replacement record.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */
        $deleted = $this->db
            ->table($this->table)
            ->where('id', $id)
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | CHECK DELETE
        |--------------------------------------------------------------------------
        */
        if (!$deleted) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Failed to delete Rotor Replacement Report.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->to(site_url('rotor_replace'))
            ->with(
                'success',
                'Rotor Replacement Report deleted successfully.'
            );
    }

    /**
     * ==========================================================
     * PRINT ROTOR REPLACEMENT REPORT
     * ==========================================================
     */
    public function printReport()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        /*
        |--------------------------------------------------------------------------
        | GET RECORDS
        |--------------------------------------------------------------------------
        */
        $builder = $this->db->table($this->table);

        /*
        |--------------------------------------------------------------------------
        | DATE FILTER
        |--------------------------------------------------------------------------
        */
        if (!empty($startDate)) {
            $builder->where('date >=', $startDate);
        }

        if (!empty($endDate)) {
            $builder->where('date <=', $endDate);
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER
        |--------------------------------------------------------------------------
        */
        $builder->orderBy('date', 'DESC');

        $records = $builder
            ->get()
            ->getResultArray();

        /*
        |--------------------------------------------------------------------------
        | PRINT VIEW
        |--------------------------------------------------------------------------
        */
        return view('dashboard/rotor_replace_print', [
            'records'   => $records,
            'startDate' => $startDate,
            'endDate'   => $endDate,
        ]);
    }
}
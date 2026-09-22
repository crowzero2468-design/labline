<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class CancelledAccount extends BaseController
{
    /**
     * ==========================================================
     * SAVE CANCELLED ACCOUNT
     * ==========================================================
     *
     * Selected Account:
     *     tb_data.id
     *
     * Clinic Name:
     *     tb_data.Clinic_name
     *
     * Machine:
     *     Selected machine from the form
     *
     * Saved into:
     *     tb_cancelledaccount
     *
     * Columns:
     *     Clinic
     *     Address
     *     Machine
     *     Date_Found_out
     *     Date_confirmed
     *     Personnel
     *     Reason
     *     Supplier
     *
     * Then:
     *     tb_data.status = 'I'
     */
    public function save(): RedirectResponse
    {
        // ======================================================
        // CHECK LOGIN
        // ======================================================

        if (!session()->get('logged_in')) {

            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Please login first.');
        }


        // ======================================================
        // DATABASE
        // ======================================================

        $database = db_connect();


        // ======================================================
        // CHECK REQUIRED TABLES
        // ======================================================

        if (!$database->tableExists('tb_data')) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'The tb_data table does not exist.'
                );
        }


        if (!$database->tableExists('tb_cancelledaccount')) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'The tb_cancelledaccount table does not exist.'
                );
        }


        // ======================================================
        // GET TB_DATA ID
        // ======================================================

        /*
         * Hidden input:
         *
         * <input type="hidden"
         *        name="id"
         *        id="cancelled_account_id">
         *
         * This contains tb_data.id.
         */

        $accountId = (int) $this->request->getPost('id');


        // ======================================================
        // FALLBACK TO ACCOUNT SELECT
        // ======================================================

        if ($accountId <= 0) {

            $accountId = (int) $this->request->getPost('account');
        }


        // ======================================================
        // VALIDATE ACCOUNT ID
        // ======================================================

        if ($accountId <= 0) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Please select a valid account.'
                );
        }


        // ======================================================
        // GET FORM DATA
        // ======================================================

        $address = trim(
            (string) $this->request->getPost('address')
        );


        /*
         * MACHINE
         *
         * This should come from:
         *
         * <select name="machine">
         *
         * or
         *
         * <input name="machine">
         */

        $machine = trim(
            (string) $this->request->getPost('machine')
        );


        $dateFoundOut = trim(
            (string) $this->request->getPost('date_found_out')
        );


        $dateConfirmed = trim(
            (string) $this->request->getPost('date_confirmed')
        );


        $personnel = trim(
            (string) $this->request->getPost('personnel')
        );


        $supplier = trim(
            (string) $this->request->getPost('supplier')
        );


        $reason = trim(
            (string) $this->request->getPost('reason')
        );


        // ======================================================
        // GET SELECTED ACCOUNT FROM TB_DATA
        // ======================================================

        /*
         * We use the selected tb_data.id.
         *
         * Clinic name:
         *     Clinic_name
         *
         * Address:
         *     Address
         */

        $account = $database
            ->table('tb_data')
            ->select('id, Clinic_name, Address')
            ->where('id', $accountId)
            ->get()
            ->getRowArray();


        // ======================================================
        // ACCOUNT NOT FOUND
        // ======================================================

        if (!$account) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'The selected account could not be found.'
                );
        }


        // ======================================================
        // GET CLINIC NAME
        // ======================================================

        $clinic = trim(
            (string) ($account['Clinic_name'] ?? '')
        );


        // ======================================================
        // VALIDATE CLINIC NAME
        // ======================================================

        if ($clinic === '') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'The selected account does not have a clinic name.'
                );
        }


        // ======================================================
        // GET ADDRESS
        // ======================================================

        /*
         * If the address from the form is empty,
         * use the address from tb_data.
         */

        if ($address === '') {

            $address = trim(
                (string) ($account['Address'] ?? '')
            );
        }


        // ======================================================
        // VALIDATE REQUIRED FIELDS
        // ======================================================

        if (
            $address === '' ||
            $machine === '' ||
            $dateFoundOut === '' ||
            $dateConfirmed === '' ||
            $personnel === '' ||
            $supplier === '' ||
            $reason === ''
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Please fill in all required fields.'
                );
        }


        // ======================================================
        // DATE VALIDATION
        // ======================================================

        if ($dateConfirmed < $dateFoundOut) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Date Confirmed From Manufacturer cannot be earlier than Date Found Out.'
                );
        }


        // ======================================================
        // PREPARE CANCELLED ACCOUNT DATA
        // ======================================================

        $cancelledData = [

            'Clinic'         => $clinic,
            'Address'        => $address,
            'Machine'        => $machine,
            'Date_Found_out' => $dateFoundOut,
            'Date_confirmed' => $dateConfirmed,
            'Personnel'      => $personnel,
            'Reason'         => $reason,
            'Supplier'       => $supplier,

        ];


        // ======================================================
        // START TRANSACTION
        // ======================================================

        $database->transBegin();


        // ======================================================
        // INSERT INTO TB_CANCELLEDACCOUNT
        // ======================================================

        $inserted = $database
            ->table('tb_cancelledaccount')
            ->insert($cancelledData);


        // ======================================================
        // CHECK INSERT
        // ======================================================

        if (!$inserted) {

            $database->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to save the cancelled account.'
                );
        }


        // ======================================================
        // UPDATE TB_DATA STATUS
        // ======================================================

        /*
         * Cancelled account:
         *
         * tb_data.status = 'I'
         *
         * I = Inactive
         *
         * The exact selected account is identified by:
         *
         * tb_data.id = $accountId
         */

        $updated = $database
            ->table('tb_data')
            ->where('id', $accountId)
            ->update([
                'status' => 'I'
            ]);


        // ======================================================
        // CHECK TB_DATA UPDATE
        // ======================================================

        if (!$updated) {

            $database->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Cancelled account was not saved because the account status could not be updated.'
                );
        }


        // ======================================================
        // CHECK TRANSACTION
        // ======================================================

        if (!$database->transStatus()) {

            $database->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to save the cancelled account. No changes were made.'
                );
        }


        // ======================================================
        // COMMIT TRANSACTION
        // ======================================================

        $database->transCommit();


        // ======================================================
        // VERIFY TB_DATA STATUS
        // ======================================================

        $updatedAccount = $database
            ->table('tb_data')
            ->select('id, status')
            ->where('id', $accountId)
            ->get()
            ->getRowArray();


        if (
            !$updatedAccount ||
            strtoupper(trim((string) $updatedAccount['status'])) !== 'I'
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Cancelled account was saved, but tb_data.status was not updated to I.'
                );
        }


        // ======================================================
        // SUCCESS
        // ======================================================

        return redirect()
            ->to(site_url('dashboard'))
            ->with(
                'success',
                'Cancelled account saved successfully, including the machine, and the account status was changed to Inactive.'
            );
    }
}
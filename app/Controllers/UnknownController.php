<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UnknownController extends BaseController
{
    public function index()
    {
         
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();

           $provinceTotals = [];
        if ($database->tableExists('tb_data')) {
            $provinceTotals = $database->query(
                "SELECT Province, COUNT(*) AS total
                 FROM tb_data
                 WHERE Province IS NOT NULL AND TRIM(Province) != ''
                 GROUP BY Province
                 ORDER BY total DESC, Province ASC"
            )->getResultArray();
        }

        return view('dashboard/404', [
            'user' => session()->get('user'),
            'province_totals' => $provinceTotals,
        ]);
    
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Receipt extends BaseController
{
    public function index(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $db = db_connect();

        $receipts = $db->table('tb_receipt')
            ->orderBy('date_upload', 'DESC')
            ->get()
            ->getResultArray();

        return view('dashboard/receipts', [
            'receipts' => $receipts
        ]);
    }

    public function upload(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $file = $this->request->getFile('receipt');

        // Check if file was uploaded
        if (!$file || !$file->isValid()) {
            return redirect()->back()
                ->with('error', 'Please select a valid receipt image.');
        }

        // Only allow JPG/JPEG
        $allowedTypes = [
            'image/jpeg',
            'image/jpg'
        ];

        if (!in_array($file->getMimeType(), $allowedTypes, true)) {
            return redirect()->back()
                ->with('error', 'Only JPG/JPEG receipt images are allowed.');
        }

        // Maximum 5MB
        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()
                ->with('error', 'Receipt must not exceed 5MB.');
        }

        // Create upload directory
        $uploadPath = FCPATH . 'uploads/receipts/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        // Generate random filename
        $newName = $file->getRandomName();

        // Move uploaded file
        $file->move($uploadPath, $newName);

        // Save relative path in database
        $fileLocation = 'uploads/receipts/' . $newName;

        $db = db_connect();

        $db->table('tb_receipt')->insert([
            'file_location' => $fileLocation,
            'date_upload'   => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(site_url('dashboard/receipts'))
            ->with('success', 'Receipt uploaded successfully.');
    }

    public function delete($id): RedirectResponse
{
    if (!session()->get('logged_in')) {
        return redirect()->to(site_url('login'))
            ->with('error', 'Please login first.');
    }

    $db = db_connect();

    // Find receipt
    $receipt = $db->table('tb_receipt')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$receipt) {
        return redirect()->to(site_url('dashboard/receipts'))
            ->with('error', 'Receipt not found.');
    }

    // Delete physical image
    if (!empty($receipt['file_location'])) {

        $fileName = basename($receipt['file_location']);

        $filePath = FCPATH . 'uploads/receipts/' . $fileName;

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    // Delete database record
    $db->table('tb_receipt')
        ->where('id', $id)
        ->delete();

    return redirect()->to(site_url('dashboard/receipts'))
        ->with('success', 'Receipt deleted successfully.');
}
}
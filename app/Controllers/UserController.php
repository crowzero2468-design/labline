<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class UserController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $database = db_connect();
        $this->ensureUserTable();

        $search = trim((string) ($this->request->getGet('search') ?? ''));
        $builder = $database->table('tb_user');

        if ($search !== '') {
            $builder->groupStart()
                ->like('fname', $search)
                ->orLike('lname', $search)
                ->orLike('uname', $search)
                ->orLike('company_id', $search)
                ->orLike('status', $search)
                ->groupEnd();
        }

        $users = $builder
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('dashboard/user', [
            'user' => session()->get('user'),
            'users' => $users,
        ]);
    }

    public function toggleStatus(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $id = (int) $this->request->getPost('id');
        $status = strtolower((string) $this->request->getPost('status'));

        if ($id <= 0 || !in_array($status, ['active', 'inactive'], true)) {
            return redirect()->to(site_url('dashboard/user'))
                ->with('error', 'Invalid user status update.');
        }

        db_connect()->table('tb_user')
            ->where('id', $id)
            ->set('status', $status)
            ->update();

        return redirect()->to(site_url('dashboard/user'))
            ->with('success', 'User status updated successfully.');
    }

    public function update(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $id = (int) $this->request->getPost('id');
        $fname = trim((string) $this->request->getPost('fname'));
        $lname = trim((string) $this->request->getPost('lname'));
        $uname = trim((string) $this->request->getPost('uname'));
        $companyId = trim((string) $this->request->getPost('company_id'));
        $role = (int) $this->request->getPost('role');
        $password = (string) $this->request->getPost('password');

        if ($id <= 0 || $fname === '' || $lname === '' || $uname === '') {
            return redirect()->to(site_url('dashboard/user'))
                ->with('error', 'Please complete all user fields.');
        }

        $database = db_connect();
        $existing = $database->table('tb_user')
            ->where('uname', $uname)
            ->where('id !=', $id)
            ->get()
            ->getRowArray();

        if ($existing) {
            return redirect()->to(site_url('dashboard/user'))
                ->with('error', 'Username already exists.');
        }

        $updateData = [
            'fname' => $fname,
            'lname' => $lname,
            'uname' => $uname,
            'company_id' => $companyId,
            'role' => $role,
        ];

        if ($password !== '') {
            $updateData['pass'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $database->table('tb_user')
            ->where('id', $id)
            ->update($updateData);

        return redirect()->to(site_url('dashboard/user'))
            ->with('success', 'User updated successfully.');
    }

    public function delete(): RedirectResponse
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please login first.');
        }

        $id = (int) $this->request->getPost('id');
        if ($id <= 0) {
            return redirect()->to(site_url('dashboard/user'))
                ->with('error', 'Invalid user selected for deletion.');
        }

        db_connect()->table('tb_user')->where('id', $id)->delete();

        return redirect()->to(site_url('dashboard/user'))
            ->with('success', 'User deleted successfully.');
    }

    private function ensureUserTable(): void
    {
        $database = db_connect();

        $database->query(
            "CREATE TABLE IF NOT EXISTS tb_user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fname VARCHAR(100) NOT NULL,
                lname VARCHAR(100) NOT NULL,
                uname VARCHAR(100) NOT NULL UNIQUE,
                pass VARCHAR(255) NOT NULL,
                company_id VARCHAR(100) NULL,
                role INT NOT NULL DEFAULT 1,
                status VARCHAR(50) NOT NULL DEFAULT 'inactive'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );

        $columns = $database->query("SHOW COLUMNS FROM tb_user")->getResultArray();
        $existing = [];
        foreach ($columns as $column) {
            $existing[] = strtolower($column['Field']);
        }

        if (!in_array('company_id', $existing, true)) {
            $database->query("ALTER TABLE tb_user ADD COLUMN company_id VARCHAR(100) NULL AFTER pass");
        }

        if (!in_array('role', $existing, true)) {
            $database->query("ALTER TABLE tb_user ADD COLUMN role INT NOT NULL DEFAULT 1 AFTER company_id");
        }

        if (!in_array('status', $existing, true)) {
            $database->query("ALTER TABLE tb_user ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'inactive' AFTER role");
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Login extends BaseController
{
    public function index(): string|RedirectResponse
    {
        if (session()->get('logged_in')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('login/login');
    }

    public function login(): RedirectResponse
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel
            ->where('uname', $username)
            ->first();

        if (!$user) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Username not found.')
                ->withInput();
        }

        if (!password_verify($password, $user['pass'])) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Incorrect password.')
                ->withInput();
        }

        if (strcasecmp((string) ($user['status'] ?? ''), 'inactive') === 0) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Your account is inactive. Please contact the system admin.')
                ->withInput();
        }

        session()->set([
            'logged_in' => true,
            'user' => [
                'id'     => $user['id'],
                'fname'  => $user['fname'],
                'lname'  => $user['lname'],
                'uname'  => $user['uname'],
                'role'   => $user['role'],
                'status' => $user['status'],
            ]
        ]);

        return redirect()
            ->to(site_url('dashboard'))
            ->with('success', 'Login successful.');
    }

    public function signup(): RedirectResponse
    {
        $fname = trim((string) $this->request->getPost('fname'));
        $lname = trim((string) $this->request->getPost('lname'));
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if ($fname === '' || $lname === '' || $username === '') {
            return redirect()->to(site_url('login'))
                ->with('error', 'Please complete all required fields.')
                ->withInput();
        }

        if (strlen($password) < 6) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Password must be at least 6 characters long.')
                ->withInput();
        }

        if ($password !== $confirmPassword) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Passwords do not match.')
                ->withInput();
        }

        $userModel = new UserModel();

        $existingUser = $userModel->where('uname', $username)->first();
        if ($existingUser) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Username already exists. Please choose another one.')
                ->withInput();
        }

        $database = db_connect();
        $database->query(
            "CREATE TABLE IF NOT EXISTS tb_user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fname VARCHAR(100) NOT NULL,
                lname VARCHAR(100) NOT NULL,
                uname VARCHAR(100) NOT NULL UNIQUE,
                pass VARCHAR(255) NOT NULL,
                role INT NOT NULL DEFAULT 1,
                status VARCHAR(50) NOT NULL DEFAULT 'inactive'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );

        $userModel->insert([
            'fname' => $fname,
            'lname' => $lname,
            'uname' => $username,
            'pass' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 1,
            'status' => 'inactive',
        ]);

        return redirect()->to(site_url('login'))
            ->with('success', 'Account created successfully. Please sign in.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to(site_url('login'))
            ->with('success', 'You have been logged out.');
    }
}
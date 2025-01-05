<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthAPIController extends ResourceController
{
    public function register_view()
    {
        // Cek jika user sudah login
        if (session()->get('isLoggedIn')) {
            return $this->redirectBasedOnRole();
        }
        return view('register');
    }

    public function register_action()
    {
        $session = session();
        $userModel = new UserModel();

        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'nama' => 'required|min_length[3]|is_unique[users.nama]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if ($this->validate($rules)) {
            $username = $this->request->getVar('username');
            $nama = $this->request->getVar('nama');
            $password = $this->request->getVar('password');

            $userModel->createUser($username, $nama, $password);
            
            $session->setFlashdata('success', 'Registration successful! Please login.');
            return redirect()->to('/login');
        } else {
            $session->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function login_view()
    {   
        // Jika sudah login, redirect sesuai role
        if (session()->get('isLoggedIn')) {
            return $this->redirectBasedOnRole();
        }
        return view('login');
    }

    public function login_action()
    {
        $session = session();
        $userModel = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $userModel->getUserByUsername($username);

        if ($data) {
            if ($userModel->validatePassword($username, $password)) {
                $ses_data = [
                    'userId' => $data['userId'],
                    'username' => $data['username'],
                    'nama' => $data['nama'],
                    'role' => $data['role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return $this->redirectBasedOnRole();
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username does not exist.');
            return redirect()->to('/login');
        }
    }

    private function redirectBasedOnRole()
    {
        if (session()->get('role') == 'admin') {
            return redirect()->to('/admin/wisata');
        }
        return redirect()->to('/wisata');  // User biasa diarahkan ke wisata
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
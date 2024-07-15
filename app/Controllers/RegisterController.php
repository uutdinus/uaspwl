<?php

namespace App\Controllers;

use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
      
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
    
        $data = [
            'validation' => \Config\Services::validation(),
            'oldInput' => session()->getFlashdata('oldInput') ?? [],
        ];
    
        return view('Auth/Register/v_register', $data);
    }
    public function create()
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|min_length[6]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
        ];
    
        $validationMessages = [
            'email.is_unique' => 'Email sudah digunakan.',
            'username.is_unique' => 'Username sudah digunakan.',
            'username.min_length' => 'Username harus memiliki minimal 6 karakter.',
            'password.min_length' => 'Password harus memiliki minimal 6 karakter.',
        ];
    
        $validation = \Config\Services::validation();
    
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('validation', $validation)
                ->with('oldInput', $this->request->getPost());
        }
    
        $userModel = new UserModel();
    
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user'
        ];
    
        if (!$userModel->insert($userData)) {
            return redirect()->back()->withInput()->with('error', 'Failed to create account. Please try again.');
        }
    
        return redirect()->to('/login')->with('success', 'Account created successfully. Please login.');
    }
    

}
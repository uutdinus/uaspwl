<?php

namespace App\Controllers;

use App\Models\UserModel;


class LoginController extends BaseController
{
    public function index()
    {

        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('Auth/Login/v_login');
    }

    public function authenticate()
    {
        $userModel = new UserModel();


        $validationRules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $validationMessages = [
            'username' => [
                'required' => 'Username is required'
            ],
            'password' => [
                'required' => 'Password is required'
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {

            return redirect()->back()->withInput()->with('validation', $this->validation);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');


        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {

            session()->set('isLoggedIn', true);
            session()->set('username', $user['username']);
            session()->set('role', $user['role']);

            if ($user['role'] === 'admin') {
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/');
            }
        } else {

            session()->setFlashdata('error', 'username atau password salah');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {

        session()->remove(['isLoggedIn', 'username', 'role']);


        if (isset($_COOKIE['ci_session'])) {
            unset($_COOKIE['ci_session']);
            setcookie('ci_session', null, -1, '/');
        }

        return redirect()->to('/login');
    }



}

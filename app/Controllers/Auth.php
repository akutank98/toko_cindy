<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->email = \Config\Services::email();
    }
    public function register()
    {
        if ($this->request->getPost()) {
            //lakukan validasi untuk data yang di post
            $data = $this->request->getPost();
            $validate = $this->validation->run($data, 'register');
            $errors = $this->validation->getErrors();

            //jika tidak ada errors jalanakan
            if (!$errors) {
                $userModel = new \App\Models\UserModel();
                $user = new \App\Entities\User();

                $user->username = $this->request->getPost('username');
                $user->password = $this->request->getPost('password');
                $user->email = $this->request->getPost('email');
                $user->created_by = 0;
                $user->created_date = date("Y-m-d H:i:s");

                $userModel->save($user);
                return view('login', [
                    'title' => ''
                ]);
            }
            $this->session->setFlashdata('errors_register', $errors);
        }

        return view('register', ['title' => 'Register']);
    }
    public function login()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('home/index'));
        } else {
            if ($this->request->getPost()) {
                //lakukan validasi untuk data yang di post
                $data = $this->request->getPost();
                $validate = $this->validation->run($data, 'login');
                $errors = $this->validation->getErrors();

                if ($errors) {
                    return view('login', [
                        'title' => 'Login'
                    ]);
                }
                $userModel = new \App\Models\UserModel();
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                $user = $userModel->where('username', $username)->first();

                if ($user != '') {
                    $salt = $user->salt;
                    if ($user->password !== md5($salt . $password)) {
                        $this->session->setFlashdata('errors', ['Password Salah']);
                    } else {
                        $sessData = [
                            'username' => $user->username,
                            'id' => $user->id_user,
                            'role' => $user->role,
                            'isLoggedIn' => TRUE
                        ];
                        $this->session->set($sessData);
                        return redirect()->to(site_url('home/index'));
                    }
                } else {
                    $this->session->setFlashdata('errors', ['User Belum Terdaftar']);
                }
            }
            return view('login', [
                'title' => 'Login',
            ]);
        }
    }
    public function resetPassword($tokenPar)
    {
        $tokenModel = new \App\Models\TokenModel();
        $token = $tokenModel->where('token', $tokenPar)->first();
        if ($token != '') {
            $currentDate = strtotime($token->created);
            $futureDate = $currentDate + (60 * 5);
            $time = date("Y-m-d H:i:s", $futureDate);

            if (!$token->created < $time) {
                return view('resetPassword', [
                    'tokenPar' => $tokenPar,
                    'title' => 'Lupa Password'
                ]);
            } else {
                $this->session->setFlashdata('error', ['Token Invalid/ Expired']);
                return redirect()->to(site_url('auth/lupaPassword'));
            }
        } else {
            $this->session->setFlashdata('error', ['Token Invalid/ Expired']);
            return redirect()->to(site_url('auth/lupaPassword'));
        }
    }
    public function changePassword()
    {
        $tokenPar = $this->request->getPost('tokenPar');
        $tokenModel = new \App\Models\TokenModel();
        $token = $tokenModel->where('token', $tokenPar)->first();
        $userModel = new \App\Models\UserModel();
        if ($token != '') {
            $newPass = $this->request->getPost('password');
            $newPass2 = $this->request->getPost('repeatPassword');
            if ($newPass != $newPass2) {
                $this->session->setFlashdata('error_reset', ['Password tidak match dengan repeat password']);
                return redirect()->to(site_url('auth/resetPassword/' . $tokenPar));
            } else {
                $user = $userModel->find($token->id_user);
                $data = [
                    'password' => md5($user->salt . $newPass)
                ];
                $userModel->update($user->id_user, $data);
                $tokenModel->delete($token->id_token);
                // logging
                $this->logging('update', 'user', $user->id_user, date("Y-m-d H:i:s"), $user->id_user, 'reset password');
                $this->session->setFlashdata('success', ['Password telah berhasil diubah']);
                return redirect()->to(site_url('auth/login'));
            }
        } else {
            $this->session->setFlashdata('error', ['Token Invalid/ Expired']);
            return redirect()->to(site_url('auth/lupaPassword'));
        }
    }
    public function lupaPassword()
    {
        return view('lupaPassword', [
            'title' => 'Lupa Password'
        ]);
    }
    public function sendToken()
    {
        $tokenModel = new \App\Models\TokenModel();
        $userModel = new \App\Models\UserModel();
        $username = $this->request->getPost('username');
        $user = $userModel->where('username', $username)->first();
        if ($user != '') {
            $token = bin2hex(random_bytes(15));
            $t = new \App\Entities\Token();
            $email = $user->email;
            $t->token = $token;
            $t->id_user = $user->id_user;
            $message = '<h2>Silahkan klik tautan dibawah ini untuk melakukan reset password</h2><br>' . site_url('auth/resetPassword/' . $token);
            $this->sendEmail('', $email, 'Reset Password', $message);
            $tokenModel->save($t);
            return view('tokenTerkirim', [
                'title' => 'Token Terkirim'
            ]);
        } else {
            $this->session->setFlashdata('error', ['User Belum Terdaftar']);
            return redirect()->to(site_url('auth/lupaPassword'));
        }
    }
    public function caraBelanja()
    {
        return view('panduan/caraBelanja', ['title' => 'Panduan Belanja']);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(site_url('auth/login'));
    }

    private function sendEmail($attachment, $to, $title, $message)
    {
        $this->email->setFrom('tokocindytag@gmail.com', 'Toko Cindy');
        $this->email->setTo($to);
        $this->email->attach($attachment);
        $this->email->setSubject($title);
        $this->email->setMessage($message);
        if (!$this->email->send()) {
            return false;
        } else {
            return true;
        }
    }
}

<?php

namespace App\Controllers;

class User extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->session = session();
    }

    public function index()
    {
        $model = new \App\Models\UserModel();
        $data = [
            'users' => $model->paginate(10),
            'pager' => $model->pager,
        ];

        return view('user/index', [
            'data' => $data,
            'title' => 'User'
        ]);
    }
    public function search()
    {
        $model = new \App\Models\UserModel();
        if (isset($_POST)) {
            $username = $_POST['username'];
        }
        $data = [
            'users' => $model->like('username', $username)
                ->paginate(10),
            'pager' => $model->pager,
        ];

        return view('user/index', [
            'data' => $data,
            'title' => 'User'
        ]);
    }
    public function ubahEmail()
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($this->session->get('id'));

        if ($this->request->getPost()) {
            $data = [
                'email' => $this->request->getPost('email')
            ];
            $userModel->update($user->id_user, $data);
            $this->logging('update', 'user', $user->id_user, date("Y-m-d H:i:s"), $this->session->get('id'), 'ubah email');
        }
        return view('user/ubahEmail', [
            'title' => 'Ubah Email',
            'user' => $user
        ]);
    }
    public function ubahPassword()
    {
        $userModel = new \App\Models\UserModel();

        if ($this->request->getPost()) {
            $entityUser = new \App\Models\UserModel();
            $user = $userModel->find($this->session->get('id'));
            $data = $this->request->getPost();
            $newPass = $data['newPassword'];
            $old_password = $data['old_password'];
            $salt = $user->salt;
            if ($user->password !== md5($salt . $old_password)) {
                $this->session->setFlashdata('error', ['Password tidak cocok']);
                return redirect()->to(site_url('user/ubahPassword'));
            } else {
                $data = [
                    'password' => md5($salt . $newPass)
                ];
                $userModel->update($user->id_user, $data);
                // logging
                $this->logging('update', 'user', $user->id_user, date("Y-m-d H:i:s"), $this->session->get('id'), 'ubah password');

                $this->session->setFlashdata('pesan', ['Password telah berhasil diubah']);
                return redirect()->to(site_url('user/ubahPassword'));
            }
        }
        return view('user/ubahPassword', [
            'title' => 'Ubah Password'
        ]);
    }
}

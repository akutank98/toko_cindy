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
                return redirect()->to(site_url('user/ubahPassword'));
            } else {
                $entityUser->password =  $newPass;
                $data = [
                    'password' => md5($salt . $newPass)
                ];
                $userModel->update($user->id_user, $data);
                // logging
                $logModel = new \App\Models\LogModel();
                $l = new \App\Entities\Log();
                $l->action = 'update';
                $l->table_name = 'user';
                $l->id_modified = $user->id_user;
                $l->change_date = date("Y-m-d H:i:s");
                $l->id_modifier = $this->session->get('id');
                $l->keterangan = 'ubah password';
                $logModel->save($l);

                $this->session->setFlashdata('success', ['Password telah berhasil diubah']);
                return redirect()->to(site_url('user/ubahPassword'));
            }
        }
        return view('user/ubahPassword');
    }
}

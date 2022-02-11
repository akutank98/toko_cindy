<?php

namespace App\Controllers;

class User extends BaseController
{
    private $url = "https://api.rajaongkir.com/starter/";
    private $apiKey = "30176a3090c25d4f6291be85b26228d1";
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
    public function alamat()
    {
        $userID = $this->session->get('id');
        $alamatModel = new \App\Models\AlamatModel();
        $alamat = $alamatModel
            ->join('provinsi', 'alamat.provinsi = provinsi.province_id', 'left')
            ->join('kabupaten', 'alamat.kabupaten = kabupaten.city_id', 'left')
            ->where('alamat.id_user', $userID)
            ->findAll();
        if ($this->request->getPost()) {
            $entityAlamat = new \App\Entities\Alamat();
            $entityAlamat->id_user = $userID;
            $entityAlamat->label = $this->request->getPost('label');
            $entityAlamat->provinsi = $this->request->getPost('provinsi');
            $entityAlamat->kabupaten = $this->request->getPost('kabupaten');
            $entityAlamat->alamat = $this->request->getPost('alamat');
            $alamatModel->save($entityAlamat);
        }
        $provinsi = $this->rajaongkir('province');
        return view('user/alamat', [
            'title' => 'Alamat',
            'alamat' => $alamat,
            'provinsi' => json_decode($provinsi)->rajaongkir->results,
        ]);
    }
    public function hapusAlamat($id)
    {
        $alamatModel = new \App\Models\AlamatModel();
        $alamat = $alamatModel->find($id);
        $alamatModel->delete($id);
        return redirect()->to(site_url('user/alamat'));
    }

    public function getCity()
    {
        if ($this->request->isAJAX()) {
            $id_province = $this->request->getGet('id_province');
            $data = $this->rajaongkir('city', $id_province);
            return $this->response->setJSON($data);
        }
    }

    private function rajaongkir($method, $id_province = null)
    {
        $endPoint = $this->url . $method;

        if ($id_province != null) {
            $endPoint = $endPoint . "?province=" . $id_province;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: " . $this->apiKey
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
}

<?php

namespace App\Controllers;

class Barang extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        $barangModel = new \App\Models\BarangModel();

        $data = [
            'barangs' => $barangModel->paginate(10),
            'pager' => $barangModel->pager,
        ];


        return view('barang/index', [
            'data' => $data,
        ]);
    }
    public function search()
    {
        $model = new \App\Models\BarangModel();
        if (isset($_POST)) {
            $nama = $_POST['barang'];
        }
        $data = [
            'barangs' => $model->like('nama', $nama)
                ->paginate(10),
            'pager' => $model->pager,
        ];

        return view('barang/index', [
            'data' => $data,
        ]);
    }

    public function view()
    {
        $id_barang = $this->request->uri->getSegment(3);

        $barangModel = new \App\Models\BarangModel();
        $barang = $barangModel->find($id_barang);

        return view('barang/view', [
            'barang' => $barang,
        ]);
    }
    // public function deskripsi()
    // {
    //     $id_barang = $this->request->uri->getSegment(3);
    //     $deskripsiModel = new \App\Models\DetailBarangModel();
    //     $entityDes = new \App\Entities\DetailBarang();
    //     $barangModel = new \App\Models\BarangModel();
    //     $barang = $barangModel->find($id_barang);

    //     if ($this->request->getPost()) {
    //         $errors = $this->validation->getErrors();
    //         $data = $this->request->getPost();
    //         $entityDes->fill($data);
    //         $entityDes->id_barang = $id_barang;
    //         $this->validation->run($data, 'deskripsi');
    //         if (!$errors) {
    //             $entityDes->fill($data);

    //             $entityDes->created_by = $this->session->get('id');
    //             $entityDes->created_date = date("Y-m-d H:i:s");
    //             $deskripsiModel->save($entityDes);
    //             $segments = ['barang', 'view', $id_barang];

    //             // logging
    //             $logModel = new \App\Models\LogModel();
    //             $l = new \App\Entities\Log();
    //             $l->action = 'create';
    //             $l->table_name = 'detail_barang';
    //             $l->id_modified = $deskripsiModel->insertID();
    //             $l->change_date = date("Y-m-d H:i:s");
    //             $l->id_modifier = $this->session->get('id');
    //             $logModel->save($l);

    //             return redirect()->to(site_url($segments));
    //         } else {
    //             $this->session->setFlashdata('errors_createDeskripsi', $errors);
    //         }
    //     } else {
    //         return view('barang/createDeskripsi', [
    //             'barang' => $barang,
    //             $id_barang,
    //         ]);
    //     }
    // }

    public function create()
    {
        if ($this->request->getPost()) {

            $data = $this->request->getPost();
            $this->validation->run($data, 'barang');
            $errors = $this->validation->getErrors();

            if (!$errors) {
                //simpan data
                $barangModel = new \App\Models\BarangModel();
                $barang = new \App\Entities\Barang();
                $barang->fill($data);
                $barang->gambar = $this->request->getFile('gambar');
                $barang->created_by = $this->session->get('id');
                $barang->created_date = date("Y-m-d H:i:s");
                $barangModel->save($barang);
                $id_barang = $barangModel->insertID();
                $segments = ['barang', 'view', $id_barang];
                // redirect segment jadi link .../barang/view/$id
                // logging
                $logModel = new \App\Models\LogModel();
                $l = new \App\Entities\Log();
                $l->action = 'create';
                $l->table_name = 'barang';
                $l->id_modified = $id_barang;
                $l->change_date = date("Y-m-d H:i:s");
                $l->id_modifier = $this->session->get('id');
                $logModel->save($l);

                return redirect()->to(site_url($segments));
            }
            $this->session->setFlashdata('errors_create', $errors);
        }
        return view('barang/create');
    }

    public function update()
    {
        $id_barang = $this->request->uri->getSegment(3);
        $barangModel = new \App\Models\BarangModel();
        $barang = $barangModel->find($id_barang);

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $this->validation->run($data, 'barangupdate');
            $errors = $this->validation->getErrors();

            if (!$errors) {
                $b = new \App\Entities\Barang();
                $b->id_barang = $id_barang;

                $b->fill($data);
                if ($this->request->getFile('gambar')->isValid()) {
                    $b->gambar = $this->request->getFile('gambar');
                }
                $b->updated_by = $this->session->get('id');
                $b->updated_date = date("Y-m-d H:i:s");
                $barangModel->save($b);
                $segments = ['Barang', 'view', $id_barang];
                // logging
                $logModel = new \App\Models\LogModel();
                $l = new \App\Entities\Log();
                $l->action = 'update';
                $l->table_name = 'barang';
                $l->id_modified = $id_barang;
                $l->change_date = date("Y-m-d H:i:s");
                $l->id_modifier = $this->session->get('id');
                $logModel->save($l);

                return redirect()->to(base_url($segments));
            }
        }
        return view('barang/update', [
            'barang' => $barang,
        ]);
    }
    public function updateStok()
    {
        //masih serror
        $barangModel = new \App\Models\BarangModel();


        $id_barang = $this->request->uri->getSegment(3);
        $stok = $this->request->getPost('stok');
        $data = [
            'stok' => $stok,
            'updated_by' => $this->session->get('id'),
            'updated_date' => date("Y-m-d H:i:s")
        ];
        $barangModel->update($id_barang, $data);

        // logging
        $logModel = new \App\Models\LogModel();
        $l = new \App\Entities\Log();
        $l->action = 'update';
        $l->table_name = 'barang';
        $l->id_modified = $id_barang;
        $l->change_date = date("Y-m-d H:i:s");
        $l->id_modifier = $this->session->get('id');
        $l->keterangan = 'update stok';
        $logModel->save($l);
        return redirect()->to(site_url('barang/index'));
    }

    public function updateDeskripsi()
    {
        $id_barang = $this->request->uri->getSegment(3);
        $barangModel = new \App\Models\BarangModel();
        $barang = $barangModel->find($id_barang);


        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $this->validation->run($data, 'deskripsiUpdate');
            $errors = $this->validation->getErrors();

            if (!$errors) {
                $d = new \App\Entities\Barang();
                $d->id_barang = $id_barang;

                $d->fill($data);
                $d->updated_by = $this->session->get('id');
                $d->updated_date = date("Y-m-d H:i:s");
                $barangModel->save($d);

                $segments = ['Barang', 'view', $id_barang];

                // logging
                $logModel = new \App\Models\LogModel();
                $l = new \App\Entities\Log();
                $l->action = 'update';
                $l->table_name = 'barang';
                $l->id_modified = $barang->id_barang;
                $l->change_date = date("Y-m-d H:i:s");
                $l->id_modifier = $this->session->get('id');
                $logModel->save($l);

                return redirect()->to(base_url($segments));
            }
            $this->session->setFlashdata('errors_updateDeskripsi', $errors);
        }


        return view('barang/updateDeskripsi', [
            'barang' => $barang,
        ]);
    }
    public function delete()
    {
        $id = $this->request->uri->getSegment(3);


        $modelBarang = new \App\Models\BarangModel();
        $barang = $modelBarang->find($id);
        $gambar = $barang->gambar;
        if ($barang->gambar == null) {
            $modelBarang->delete($id);
        } else {
            unlink('uploads/' . $gambar);
            $modelBarang->delete($id);
        }
        // logging
        $logModel = new \App\Models\LogModel();
        $l = new \App\Entities\Log();
        $l->action = 'delete';
        $l->table_name = 'barang';
        $l->id_modified = $id;
        $l->change_date = date("Y-m-d H:i:s");
        $l->id_modifier = $this->session->get('id');
        $logModel->save($l);
        return redirect()->to(site_url('barang/index'));
    }
    public function barangKosong()
    {
        $barangModel = new \App\Models\BarangModel();
        $data = [
            'barangs' => $barangModel->where('stok', 0)->paginate(10),
            'pager' => $barangModel->pager,
        ];
        return view('barang/index', [
            'data' => $data,
        ]);
    }
}

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
        $barangs = $barangModel->findAll();

        return view('barang/index', [
            'barangs' => $barangs,
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

                return redirect()->to(base_url($segments));
            }
        }

        return view('barang/update', [
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

        return redirect()->to(site_url('barang/index'));
    }
}

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
            'title' => 'Barang'
        ]);
    }
    public function search()
    {
        $model = new \App\Models\BarangModel();
        if (isset($_POST)) {
            $nama = $_POST['barang'];
            $data = [
                'barangs' => $model->like('nama', $nama)
                    ->paginate(10),
                'pager' => $model->pager,
            ];
            return view('barang/index', [
                'data' => $data,
                'title' => 'Barang'
            ]);
        }
    }

    public function view()
    {
        $id_barang = $this->request->uri->getSegment(3);

        $barangModel = new \App\Models\BarangModel();
        $barang = $barangModel->find($id_barang);

        return view('barang/view', [
            'barang' => $barang,
            'title' => 'Detail Barang'
        ]);
    }

    public function tambahKategori()
    {
        $kategoriModel = new \App\Models\KategoriModel();
        if ($this->request->getPost()) {
            $data = [
                'nama_kategori' => $this->request->getPost('nama'),
                'kategori_deleted' => null,
            ];
            $kategoriModel->insert($data);
            $this->logging('tambah kategori', 'kategori', $kategoriModel->getInsertID(), date("Y-m-d H:i:s"), $this->session->get('id'));
            return redirect()->to('barang/tambahKategori');
        }

        $kategori = $kategoriModel->findAll();
        return view('barang/tambahKategori', [
            'kategori' => $kategori,
            'title' => 'Tambah Kategori Barang'
        ]);
    }

    public function deleteKategoribarang()
    {
        $id_kategori = $this->request->uri->getSegment(3);
        $kategoriModel = new \App\Models\KategoriModel();
        $kategoriModel->delete($id_kategori);
        $this->logging('hapus kategori', 'kategori', $id_kategori, date("Y-m-d H:i:s"), $this->session->get('id'));
        return redirect()->to('barang/tambahKategori');
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
                // logging
                $this->logging('create', 'barang', $id_barang, date("Y-m-d H:i:s"), $this->session->get('id'));

                return redirect()->to(site_url($segments));
            }
            $this->session->setFlashdata('errors_create', $errors);
        }
        $kategoriModel = new \App\Models\KategoriModel();
        $kategori = $kategoriModel->findAll();
        return view('barang/create', [
            'title' => 'Tambah Barang',
            'kategori' => $kategori
        ]);
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
            $old_gambar = $barang->gambar;
            if (!$errors) {
                $b = new \App\Entities\Barang();
                $b->id_barang = $id_barang;

                $b->fill($data);
                if ($this->request->getFile('gambar')->isValid()) {
                    $b->gambar = $this->request->getFile('gambar');
                    unlink('uploads/' . $old_gambar);
                }
                $b->updated_by = $this->session->get('id');
                $b->updated_date = date("Y-m-d H:i:s");
                $barangModel->save($b);
                $segments = ['Barang', 'view', $id_barang];
                // logging
                $this->logging('update', 'barang', $id_barang, date("Y-m-d H:i:s"), $this->session->get('id'));

                return redirect()->to(base_url($segments));
            }
        }
        return view('barang/update', [
            'barang' => $barang,
            'title' => 'Update Barang'
        ]);
    }
    public function updateStok()
    {
        $barangModel = new \App\Models\BarangModel();
        $currentPage = $this->request->getPost('currentPage');
        $id_barang = $this->request->uri->getSegment(3);
        $stok = $this->request->getPost('stok');
        $data = [
            'stok' => $stok,
            'updated_by' => $this->session->get('id'),
            'updated_date' => date("Y-m-d H:i:s")
        ];
        $barangModel->update($id_barang, $data);

        // logging
        $this->logging('update', 'barang', $id_barang, date("Y-m-d H:i:s"), $this->session->get('id'), 'update stok');
        return redirect()->to(site_url('barang/index?page=' . $currentPage));
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
                $this->logging('update', 'barang', $barang->id_barang,  date("Y-m-d H:i:s"), $$this->session->get('id'));
                return redirect()->to(base_url($segments));
            }
            $this->session->setFlashdata('errors_updateDeskripsi', $errors);
        }
        return view('barang/updateDeskripsi', [
            'barang' => $barang,
            'title' => 'Update Deskripsi Barang'
        ]);
    }
    public function delete()
    {
        $id = $this->request->uri->getSegment(3);
        $currentPage = $this->request->getPost('currentPage');

        $modelBarang = new \App\Models\BarangModel();
        $barang = $modelBarang->find($id);
        $gambar = $barang->gambar;
        if ($barang->gambar == null && !file_exists('uploads/' . $gambar)) {
            unlink('uploads/' . $gambar);
            $modelBarang->delete($id);
        } else {
            $modelBarang->delete($id);
        }

        $this->logging('delete', 'barang', $id, date("Y-m-d H:i:s"), $this->session->get('id'));
        return redirect()->to(site_url('barang/index?page=' . $currentPage));
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
            'title' => 'Barang Kosong'
        ]);
    }
}

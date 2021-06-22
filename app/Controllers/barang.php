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
        $id = $this->request->uri->getSegment(3);

        $barangModel = new \App\Models\BarangModel();

        $barang = $barangModel->find($id);

        return view('barang/view', [
            'barang' => $barang,
        ]);
    }

    public function create()
    {
        return view('barang/create');
    }
    public function update()
    {
    }
    public function delete()
    {
    }
}

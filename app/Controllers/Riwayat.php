<?php

namespace App\Controllers;

class Riwayat extends BaseController
{
    public function __construct()
    {
        $this->session = session();
    }
    public function index()
    {
        $id = $this->session->get('id');

        $transaksiModel = new \App\Models\TransaksiModel();
        $data = [
            'transaksiModel' => $transaksiModel->join('barang', 'barang.id_barang=transaksi.id_barang')->where('id_pembeli', $id)->paginate(10),
            'pager' => $transaksiModel->pager,
        ];

        return view('riwayat/index', [
            'data' => $data,
        ]);
    }
}

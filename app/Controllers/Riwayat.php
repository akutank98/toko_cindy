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
        $pengirimanModel = new \App\Models\TransaksiModel();
        $pengiriman = $pengirimanModel->findAll();

        $transaksiModel = new \App\Models\TransaksiModel();
        $data = [
            'transaksiModel' => $transaksiModel
                ->select('transaksi.*,nama')
                ->join('barang', 'barang.id_barang=transaksi.id_barang')
                ->where('id_pembeli', $id)
                ->orderBy('transaksi.created_date', 'DESC')
                ->paginate(10),
            'pager' => $transaksiModel->pager,
        ];

        return view('riwayat/index', [
            'data' => $data,
            'pengiriman' => $pengiriman,
        ]);
    }
    public function view()
    {
        $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->select('*, transaksi.id_transaksi AS id_trans')->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->join('user', 'user.id_user=transaksi.id_pembeli')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        return view('riwayat/view', [
            'transaksi' => $transaksi,
        ]);
    }
}

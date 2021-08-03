<?php

namespace App\Controllers;

use TCPDF;

class Transaksi extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function view()
    {
        $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->select('*, transaksi.id_transaksi AS id_trans')->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->join('user', 'user.id_user=transaksi.id_pembeli')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        return view('transaksi/view', [
            'transaksi' => $transaksi,
        ]);
    }

    public function index()
    {
        $transaksiModel = new \App\Models\transaksiModel();
        $data = [
            'model' => $transaksiModel
                ->select('transaksi.*,barang.nama')
                ->join('barang', 'barang on barang.id_barang=transaksi.id_barang', 'left')
                ->orderBy('transaksi.created_date', 'DESC')
                ->paginate(9),
            'pager' => $transaksiModel->pager,
        ];
        return view('transaksi/index', [
            'data' => $data,
        ]);
        $this->session = session();
    }
    public function belumLunas()
    {
        $transaksiModel = new \App\Models\transaksiModel();

        $data = [
            'model' => $transaksiModel
                ->select('transaksi.*,barang.nama')
                ->join('barang', 'barang on barang.id_barang=transaksi.id_barang', 'left')
                ->where('transaksi.status', 0)
                ->orderBy('transaksi.created_date', 'DESC')
                ->paginate(9),
            'pager' => $transaksiModel->pager,
        ];

        return view('transaksi/index', [
            'data' => $data,
        ]);
        $this->session = session();
    }
    public function sudahLunas()
    {
        $transaksiModel = new \App\Models\transaksiModel();

        $data = [
            'model' => $transaksiModel
                ->select('transaksi.*,barang.nama')
                ->join('barang', 'barang on barang.id_barang=transaksi.id_barang', 'left')
                ->where('transaksi.status >', 0)
                ->orderBy('transaksi.created_date', 'DESC')
                ->paginate(9),
            'pager' => $transaksiModel->pager,
        ];

        return view('transaksi/index', [
            'data' => $data,
        ]);
        $this->session = session();
    }
    public function search()
    {
        $model = new \App\Models\TransaksiModel();
        if (isset($_POST)) {
            $id = $_POST['id'];
        }
        $data = [
            'model' => $model
                ->select('transaksi.*,barang.nama')
                ->join('barang', 'barang on barang.id_barang=transaksi.id_barang', 'left')
                ->where('transaksi.id_transaksi', $id)
                ->paginate(9),
            'pager' => $model->pager,
        ];

        return view('transaksi/index', [
            'data' => $data,
        ]);
    }

    public function batalTransaksi()
    {
        $id = $this->request->uri->getSegment(3);
        $modelBarang = new \App\Models\BarangModel();
        $modelTransaksi = new \App\Models\TransaksiModel();

        $transaksi = $modelTransaksi->find($id);
        $barang = $modelBarang->find($transaksi->id_barang);
        //mengembalikan stok yang berkurang
        $stok = $barang->stok + $transaksi->jumlah;

        $dataB = [
            'stok' => $stok
        ];
        $modelBarang->update($transaksi->id_barang, $dataB);
        $modelTransaksi->delete($id);

        //logging
        $logModel = new \App\Models\LogModel();
        $l = new \App\Entities\Log();
        $l->action = 'delete';
        $l->table_name = 'transaksi';
        $l->id_modified = $id;
        $l->change_date = date("Y-m-d H:i:s");
        $l->id_modifier = $this->session->get('id');
        $l->keterangan = 'batalkan transaksi';
        $logModel->save($l);

        return redirect()->to(site_url('transaksi/index'));
    }

    public function downloadInvoice()
    {
        $id = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->find($id);

        $userModel = new \App\Models\UserModel();
        $pembeli = $userModel->find($transaksi->id_pembeli);

        $barangModel = new \App\Models\BarangModel();
        $barang = $barangModel->find($transaksi->id_barang);

        $html = view('transaksi/invoice', [
            'transaksi' => $transaksi,
            'pembeli' => $pembeli,
            'barang' => $barang,
        ]);

        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Toko Cindy');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        //set response
        $this->response->setContentType('application/pdf');
        $name = 'invoice_tr-' . $transaksi->id_transaksi . '.pdf';

        //Close and output PDF document
        $pdf->Output($name, 'I');
    }
    public function updateResi()
    {
        $id = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->find($id);

        if ($transaksi->resi == null) {
            $r = 'tambah resi';
        } else {
            $r = 'ubah';
        }
        $resi = $this->request->getPost('resi');
        $data = [
            'resi' => $resi,
            'status' => 2,
            'updated_by' => $this->session->get('id'),
            'updated_date' => date("Y-m-d H:i:s")
        ];

        $transaksiModel->update($id, $data);
        //logging
        $logModel = new \App\Models\LogModel();
        $l = new \App\Entities\Log();
        $l->action = $r;
        $l->table_name = 'transaksi';
        $l->id_modified = $id;
        $l->change_date = date("Y-m-d H:i:s");
        $l->id_modifier = $this->session->get('id');
        $l->keterangan = 'ubah resi';
        $logModel->save($l);
        return redirect()->to(site_url('transaksi/index'));
    }
    public function updateStatusTransaksi()
    {
        $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->find($id);
        $t = new \App\Entities\Transaksi();

        $status = $transaksi->status;
        if ($transaksi->status == 0) {
            $status = 1;
        }
        $t->id_transaksi = $transaksi->id_transaksi;
        $t->id_barang = $transaksi->id_barang;
        $t->id_pembeli = $transaksi->id_pembeli;
        $t->alamat = $transaksi->alamat;
        $t->jumlah = $transaksi->jumlah;
        $t->ongkir = $transaksi->ongkir;
        $t->status = $status;
        $t->total_harga = $transaksi->total_harga;
        $t->created_by = $transaksi->created_by;
        $t->created_date = $transaksi->created_date;
        $t->update_by = $this->session->get('id');
        $t->updated_date = date("Y-m-d H:i:s");

        $transaksiModel->save($t);
        //logging
        $logModel = new \App\Models\LogModel();
        $l = new \App\Entities\Log();
        $l->action = 'update';
        $l->table_name = 'transaksi';
        $l->id_modified = $id;
        $l->change_date = date("Y-m-d H:i:s");
        $l->id_modifier = $this->session->get('id');
        $l->keterangan = 'status transaksi';
        $logModel->save($l);
        return redirect()->to(site_url('transaksi/index'));
    }
    public function laporan()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel
            ->select('transaksi.*,barang.nama')
            ->join('barang', 'barang.id_barang=transaksi.id_barang', 'left')
            ->where('transaksi.status', 2)->paginate();
        return view('transaksi/laporan', [
            'transaksi' => $transaksi,
            'pager' => $transaksiModel->pager,
            'end' => null,
            'start' => null
        ]);
    }
    public function rangeLaporan()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $start = date("Y-m-d", strtotime($_POST['date_timepicker_start']));
        $end = date("Y-m-d", strtotime($_POST['date_timepicker_end']));

        $transaksi = $transaksiModel
            ->select('transaksi.*,barang.nama')
            ->join('barang', 'barang.id_barang=transaksi.id_barang', 'left')
            ->where("status = 2 AND transaksi.created_date BETWEEN '$start' AND '$end'")
            ->paginate();

        return view('transaksi/laporan', [
            'transaksi' => $transaksi,
            'pager' => $transaksiModel->pager,
        ]);
    }
    public function cetakLaporan()
    {
        $html = $_POST['htmlreport'];
        $tgl = $_POST['tgl'];
        $htmlR = view('transaksi/pdfLaporan', [
            'html' => $html
        ]);
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Toko Cindy');
        $pdf->SetTitle('Laporan Penjualan' . $tgl);
        $pdf->SetSubject('Laporan');


        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();

        // output the HTML content
        $pdf->writeHTML($htmlR, true, false, true, false, '');
        $start = '';
        $end = '';
        //set response
        $this->response->setContentType('application/pdf');
        $name = 'laporanPenjualan' . $tgl . '.pdf';
        //Close and output PDF document
        $pdf->Output($name, 'I');
    }
}

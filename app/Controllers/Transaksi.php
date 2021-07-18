<?php

namespace App\Controllers;

use App\Database\Migrations\transaksi as MigrationsTransaksi;
use Exception;
use TCPDF;

class Transaksi extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->email = \Config\Services::email();
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
        $transaksiModel = new \App\Models\TransaksiModel();
        $model = $transaksiModel->findAll();
        return view('transaksi/index', [
            'model' => $model,
        ]);
        $this->session = session();
    }
    public function invoice()
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
        $pdf->Output(__DIR__ . "/../../public/uploads/$name", 'F');

        $attachment = base_url('uploads/Invoice.pdf');

        $message = "<h1>Invoice Pembelian</h1><p>Kepada " . $pembeli->username . " Berikut Invoice atas pembelian " . $barang->nama . "</p>";
        //buggy
        $this->sendEmail($attachment, 'akutank98@gmail.com', 'Invoice', $message);
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
    public function updateStatusTransaksi()
    {
        $id = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->find($id);
        $t = new \App\Entities\Transaksi();

        $status = $transaksi->status;
        if ($transaksi->status == 0) {
            $status = 1;
        } else {
            $status = 0;
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
        return redirect()->to(site_url('transaksi/index'));
    }
    private function sendEmail($attachment, $to, $title, $message)
    {
        $this->email->setFrom('akutank2000@gmail.com', 'Toko Cindy');
        $this->email->setTo($to);
        $this->email->attach($attachment);
        $this->email->setSubject($title);
        $this->email->setMessage($message);
        if (!$this->email->send()) {
            return false;
        } else {
            return true;
        }
    }
}

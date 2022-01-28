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
        $headerModel = new \App\Models\Header_TransaksiModel();
        $itemModel = new \App\Models\Item_TransaksiModel();
        $barangModel = new \App\Models\BarangModel();
        $id = $this->request->uri->getSegment(3);
        $header = $headerModel
            ->select('header_transaksi.*,username')
            ->join('user', 'user on id_pembeli = id_user')
            ->find($id);
        $item = $itemModel->where('id_transaksi', $header->id_header)->findAll();
        return view('transaksi/view', [
            'items' => $item,
            'head' => $header,
            'barangModel' => $barangModel,
            'title' => 'Lihat Transaksi'
        ]);
    }


    public function index()
    {
        $headModel = new \App\Models\Header_TransaksiModel();
        $head = $headModel->select('header_transaksi.*,username')
            ->join('user', 'user on id_pembeli = id_user')
            ->orderBy('created_date', 'DESC')
            ->paginate(10);
        $data = [
            'head' => $head,
            'pager' => $headModel->pager,
        ];
        return view('transaksi/index', [
            'data' => $data,
            'title' => 'Transaksi'
        ]);
    }
    public function belumLunas()
    {
        $headModel = new \App\Models\Header_TransaksiModel();

        $head = $headModel->select('header_transaksi.*,username')
            ->join('user', 'user on id_pembeli = id_user')
            ->where('status', 0)
            ->orderBy('created_date', 'DESC')
            ->paginate(10);

        $data = [
            'head' => $head,
            'pager' => $headModel->pager,
        ];

        return view('transaksi/index', [
            'data' => $data,
            'title' => 'Transaksi Belum Lunas'
        ]);
    }
    public function sudahLunas()
    {
        $headModel = new \App\Models\Header_TransaksiModel();

        $head = $headModel->select('header_transaksi.*,username')
            ->join('user', 'user on id_pembeli = id_user')
            ->orderBy('created_date', 'DESC')
            ->where('status <>', 0)
            ->paginate(10);

        $data = [
            'head' => $head,
            'pager' => $headModel->pager,
        ];

        return view('transaksi/index', [
            'data' => $data,
            'title' => 'Transaksi Sudah Lunas'
        ]);
    }
    public function search()
    {
        if ($this->request->getPost()) {
            $headModel = new \App\Models\Header_TransaksiModel();
            $id = $this->request->getPost('id');
            $head = $headModel->select('header_transaksi.*,username')
                ->join('user', 'user on id_pembeli = id_user')
                ->orderBy('created_date', 'DESC')
                ->where('id_header', $id)
                ->paginate(10);

            $data = [
                'head' => $head,
                'pager' => $headModel->pager,
            ];

            return view('transaksi/index', [
                'data' => $data,
                'title' => 'Transaksi'
            ]);
        }
    }

    public function batalTransaksi()
    {
        $id = $this->request->uri->getSegment(3);
        $modelBarang = new \App\Models\BarangModel();
        $modelHead = new \App\Models\Header_TransaksiModel();
        $modelItem = new \App\Models\Item_TransaksiModel();

        $head = $modelHead->find($id);
        $itemArray = $modelItem
            ->where('id_transaksi', $head->id_header)
            ->findAll();
        foreach ($itemArray as  $item) {
            $barang = $modelBarang->find($item->id_barang);
            $modelItem->delete($item->id_item);

            $data = [
                'stok' => $barang->stok + $item->jumlah,
            ];
            $modelBarang->update($item->id_barang, $data);
        }
        $modelHead->delete($id);
        //logging
        $this->logging('delete', 'header_transaksi', $id, date("Y-m-d H:i:s"), $this->session->get('id'), 'batalkan transaksi');

        return redirect()->to(site_url('transaksi/index'));
    }

    public function downloadInvoice()
    {
        $id = $this->request->uri->getSegment(3);
        $headModel = new \App\Models\Header_TransaksiModel();
        $itemModel = new \App\Models\Item_TransaksiModel();

        $head = $headModel
            ->select('header_transaksi.*,username')
            ->join('user', 'user on user.id_user=header_transaksi.id_pembeli')
            ->find($id);
        $item = $itemModel
            ->select('item_transaksi.*,nama')
            ->join('barang', 'barang on barang.id_barang=item_transaksi.id_barang', 'left')
            ->where('id_transaksi', $id)
            ->findAll();

        $html = view('transaksi/invoice', [
            'head' => $head,
            'item' => $item,
            'title' => 'Invoice'
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
        $name = 'invoice_tr-' . $head->id_header . '.pdf';

        //Close and output PDF document
        $pdf->Output($name, 'I');
    }
    public function updateResi()
    {
        $id = $this->request->uri->getSegment(3);
        $modelHeader = new \App\Models\Header_TransaksiModel();
        if ($this->request->getPost('resi') != '') {
            $resi = $this->request->getPost('resi');
            $data = [
                'resi' => $resi,
                'status' => 2,
                'updated_by' => $this->session->get('id'),
                'updated_date' => date("Y-m-d H:i:s")
            ];

            $modelHeader->update($id, $data);
            //logging
            $this->logging('tambah resi', 'header_transaksi', $id, date("Y-m-d H:i:s"), $this->session->get('id'));
        }
        return redirect()->to(site_url('transaksi/index'));
    }
    public function updateStatusTransaksi()
    {
        $id = $this->request->uri->getSegment(3);
        $head = new \App\Models\Header_TransaksiModel();
        $data = [
            'status' => 1,
            'updated_by' => $this->session->get('id'),
            'updated_date' => date("Y-m-d H:i:s")
        ];
        $head->update($id, $data);
        //logging
        $this->logging('update', 'header_transaksi', $id, date("Y-m-d H:i:s"), $this->session->get('id'), 'status transaksi');
        return redirect()->to(site_url('transaksi/index'));
    }
    public function laporan()
    {
        return view('transaksi/laporan', [
            'title' => 'Laporan Transaksi'
        ]);
    }

    public function cetakLaporan()
    {
        if ($this->request->getPost('datepicker') != '') {
            $date = $this->request->getPost('datepicker');
            $headModel = new \App\Models\Header_TransaksiModel();
            $month = date('F', strtotime($date));
            $year = date('Y', strtotime($date));
            $tipe = '';
            if ($this->request->getPost('opt') == 'month') {
                $start = date("Y-m-d", strtotime($date));
                $end = date("Y-m-t", strtotime($date));
                $tipe = 'bulan';
            } else  if ($this->request->getPost('opt') == 'date') {
                $start = $date;
                $end = $date;
                $tipe = $start;
                $head = $headModel
                    ->select('sum(total_harga) as total')
                    ->where("status = 2 AND created_date", $start)
                    ->findAll();
            } else if ($this->request->getPost('opt') == 'week') {
                $start = date("Y-m-d", strtotime($date));
                $end = date('Y-m-d', strtotime($start . " +7 days"));
                $tipe = $start . '-' . $end;
            }
            $head = $headModel
                ->select('sum(total_harga) as total')
                ->where("status = 2 AND created_date BETWEEN '$start' AND '$end'")
                ->findAll();
            $jumlahTransaksi = $headModel
                ->select('count(id_header) as jumlah')
                ->where("status = 2 AND created_date BETWEEN '$start' AND '$end'")
                ->findAll();

            foreach ($head as $head1) {
                if ($head1->total != '') {
                    $itemModel = new \App\Models\Item_TransaksiModel();
                    $item = $itemModel
                        ->select('item_transaksi.id_barang as id_barang,barang.nama as nama_barang,sum(item_transaksi.sub_total) as sub_total,sum(item_transaksi.jumlah) as jumlah')
                        ->join('header_transaksi', 'header_transaksi on item_transaksi.id_transaksi=header_transaksi.id_header')
                        ->join('barang', 'barang on barang.id_barang=item_transaksi.id_barang', 'right')
                        ->where("header_transaksi.status = 2 AND header_transaksi.created_date BETWEEN '$start' AND '$end'")
                        ->groupBy('item_transaksi.id_barang')
                        ->findAll();

                    if ($tipe == 'bulan') {
                        $name = 'laporanPenjualan' . $month . $year . '.pdf';
                    } else if ($tipe == 'week') {
                        $name = 'laporanPenjualan' . $month . $year . '.pdf';
                    } else if ($tipe == 'date') {
                        $name = 'laporanPenjualan' . $month . $year . '.pdf';
                    }

                    $html = view('transaksi/pdfLaporan', [
                        'head' => $head,
                        'month' => $month,
                        'year' => $year,
                        'item' => $item,
                        'tipe' => $tipe,
                        'countTransaksi' => $jumlahTransaksi
                    ]);

                    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

                    $pdf->SetCreator(PDF_CREATOR);
                    $pdf->SetAuthor('Toko Cindy');
                    $pdf->SetTitle('Laporan Penjualan bulan :' . $month . ' ' . $year);
                    $pdf->SetSubject('Laporan');

                    $pdf->setPrintHeader(false);
                    $pdf->setPrintFooter(false);

                    $pdf->addPage();
                    // output the HTML content
                    $pdf->writeHTML($html, true, false, true, false, '');
                    //set response
                    $this->response->setContentType('application/pdf');

                    //Close and output PDF document
                    $pdf->Output($name, 'I');
                } else {
                    $this->session->setFlashdata('errors_transaksi', ["Tidak Ada Transaksi Pada $month $year"]);
                    return redirect()->to('transaksi/laporan');
                }
            }
        } else {
            $this->session->setFlashdata('errors_transaksi', ['Null or Bad Request']);
            return redirect()->to('transaksi/laporan');
        }
    }
}

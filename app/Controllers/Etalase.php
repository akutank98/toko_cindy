<?php

namespace App\Controllers;


class Etalase extends BaseController
{
    private $url = "https://api.rajaongkir.com/starter/";
    private $apiKey = "30176a3090c25d4f6291be85b26228d1";
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        $barangModel = new \App\Models\BarangModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $kategori = $kategoriModel->findAll();
        $data = [
            'model' => $barangModel
                ->where('stok >', 0)
                ->paginate(12),
            'pager' => $barangModel->pager,
        ];

        return view('etalase/index', [
            'data' => $data,
            'kategori' => $kategori,
            'title' => 'Etalase'
        ]);
    }
    public function search()
    {
        $barangModel = new \App\Models\BarangModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $kategori = $kategoriModel->findAll();
        if ($this->request->getGet()) {
            $k = $this->request->getGet('kategori');
            $barang = $this->request->getGet('barang');
            if ($this->request->getGet('sort') == '') {
                $data = [
                    'model' => $barangModel
                        ->where("nama LIKE '%$barang%' AND id_kategori LIKE '%$k%' AND stok >", 0)
                        ->paginate(10),
                    'pager' => $barangModel->pager,
                ];
            } elseif ($this->request->getGet('sort') == 'termurah') {
                $data = [
                    'model' => $barangModel
                        ->where("nama LIKE '%$barang%' AND id_kategori LIKE '%$k%' AND stok >", 0)
                        ->orderBy('harga', 'asc')
                        ->paginate(10),
                    'pager' => $barangModel->pager,
                ];
            } elseif ($this->request->getGet('sort') == 'termahal') {
                $data = [
                    'model' => $barangModel
                        ->where("nama LIKE '%$barang%' AND id_kategori LIKE '%$k%' AND stok >", 0)
                        ->orderBy('harga', 'desc')
                        ->paginate(10),
                    'pager' => $barangModel->pager,
                ];
            } elseif ($this->request->getGet('sort') == 'terlaris') {
                $data = [
                    'model' => $barangModel
                        ->select('barang.*, SUM(item_transaksi.jumlah) as jml')
                        ->join('item_transaksi', 'barang.id_barang = item_transaksi.id_barang', 'left')
                        ->where("nama LIKE '%$barang%' AND id_kategori LIKE '%$k%' AND stok >", 0)
                        ->groupBy('barang.id_barang')
                        ->orderBy('harga', 'asc')
                        ->paginate(10),
                    'pager' => $barangModel->pager,
                ];
            }
            return view('etalase/search', [
                'data' => $data,
                'kategori' => $kategori,
                'title' => 'Etalase'
            ]);
        }
    }

    public function single()
    {
        if ($this->request->getPost()) {
            $headerEnt = new \App\Entities\Header_Transaksi();
            $barangModel = new \App\Models\BarangModel();
            $header = new \App\Models\Header_TransaksiModel();
            $item = new \App\Models\Item_TransaksiModel();
            $data = $this->request->getPost();
            $alamat = $this->request->getPost('alamat');
            $alamat .=
                ', ' . $this->request->getPost('kabupaten') .
                ', ' . $this->request->getPost('provinsi');
            $headerEnt->id_pembeli = $this->session->get('id');
            $headerEnt->fill($data);
            $headerEnt->alamat = $alamat;
            $headerEnt->created_by = $this->session->get('id');
            $headerEnt->created_date = date("Y-m-d H:i:s");
            $header->save($headerEnt);
            $id_head = $header->insertID();

            $itemEnt = new \App\Entities\Item_Transaksi();
            $itemEnt->id_transaksi = $id_head;
            $itemEnt->id_barang = $this->request->getPost('id_barang');
            $itemEnt->jumlah = $this->request->getPost('jumlah');
            $itemEnt->sub_total = $this->request->getPost('total_harga');

            $barang = $barangModel->find($this->request->getPost('id_barang'));
            $stok = $barang->stok;
            $stokNew = $stok - $this->request->getPost('jumlah');
            $data = [
                'stok' => $stokNew,
            ];
            $barangModel->update($barang->id_barang, $data);
            $item->save($itemEnt);
            return redirect()->to(site_url('etalase/view/' . $id_head));
        }
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
        return view('Etalase/view', [
            'items' => $item,
            'head' => $header,
            'barangModel' => $barangModel,
            'title' => 'Lihat Transaksi'
        ]);
    }

    public function addCart()
    {
        $id = $this->request->uri->getSegment(3);
        $barangModel = new \App\Models\BarangModel();
        $barang = $barangModel->find($id);

        $cart = \Config\Services::cart();
        $cart->insert(array(
            'id'      => $id,
            'qty'     => 1,
            'price'   => $barang->harga,
            'name'    => $barang->nama,
            'options' => array(
                'gambar' => $barang->gambar,
                'berat' => $barang->berat
            )
        ));
        $this->session->setFlashdata('pesan', 'Barang telah ditambahkan kedalam keranjang');
        return redirect()->to('Etalase/beli/' . $id);
    }
    public function beli()
    {
        $id = $this->request->uri->getSegment(3);
        $modelBarang = new \App\Models\BarangModel();

        $model = $modelBarang->find($id);
        $provinsi = $this->rajaongkir('province');

        return view('etalase/beli', [
            'model' => $model,
            'provinsi' => json_decode($provinsi)->rajaongkir->results,
            'title' => 'Beli'
        ]);
    }
    public function getCity()
    {
        if ($this->request->isAJAX()) {
            $id_province = $this->request->getGet('id_province');
            $data = $this->rajaongkir('city', $id_province);
            return $this->response->setJSON($data);
        }
    }

    public function getCost()
    {
        if ($this->request->isAJAX()) {
            $origin = $this->request->getGet('origin');
            $destination = $this->request->getGet('destination');
            $weight = $this->request->getGet('weight');
            $courier = $this->request->getGet('courier');
            $data = $this->rajaongkircost($origin, $destination, $weight, $courier);

            return $this->response->setJSON($data);
        }
    }
    public function getWeight()
    {
        $id = $this->request->uri->getSegment(3);
        $detailModel = new \App\Models\DetailBarangModel();
        $detail = $detailModel->where('id_barang', $id);

        return $detail;
    }

    private function rajaongkircost($origin, $destination, $weight, $courier)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: " . $this->apiKey,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
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

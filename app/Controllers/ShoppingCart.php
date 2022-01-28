<?php

namespace App\Controllers;


class ShoppingCart extends BaseController
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
        $cart = \Config\Services::cart();
        return view('shoppingCart/index', [
            'cart' => $cart,
            'title' => 'Keranjang Belanja'
        ]);
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
        return view('etalase/view', [
            'items' => $item,
            'head' => $header,
            'barangModel' => $barangModel,
            'title' => 'Lihat Transaksi'
        ]);
    }

    public function clear()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
    }
    public function add()
    {
        $currentPage = $this->request->getPost('currentPage');
        $cart = \Config\Services::cart();
        $cart->insert(array(
            'id'      => $this->request->getPost('id'),
            'qty'     => 1,
            'price'   => $this->request->getPost('price'),
            'name'    => $this->request->getPost('name'),
            'options' => array(
                'gambar' => $this->request->getPost('gambar'),
                'berat' => $this->request->getPost('berat')
            )
        ));
        $this->session->setFlashdata('pesan', 'Barang telah ditambahkan kedalam keranjang');
        return redirect()->to(site_url('etalase/index?page=' . $currentPage));
    }
    public function update()
    {
        $i = 1;
        $cart = \Config\Services::cart();
        if (isset($_POST)) {
            foreach ($cart->contents() as $items) {
                $data = array(
                    'rowid' => $items['rowid'],
                    'qty' => $_POST['qty' . $i]
                );
                $cart->update($data);
                $i++;
            }
            $this->session->setFlashdata('pesan', 'Keranjang belanja berhasil disimpan');
            return redirect()->to(site_url('ShoppingCart/index'));
        }
    }
    public function delete()
    {
        $rowid = $this->request->uri->getSegment(3);
        $cart = \Config\Services::cart();
        $cart->remove($rowid);
        $this->session->setFlashdata('pesan', 'Barang telah berhasil dihapus dari keranjang belanja');
        return redirect()->to(site_url('ShoppingCart/index'));
    }
    public function checkout()
    {
        $cart = \Config\Services::cart();
        $provinsi = $this->rajaongkir('province');

        $total_weight = 0;
        foreach ($cart->contents() as $items) {
            $total_weight += $items['options']['berat'] * $items['qty'];
        }
        return view('shoppingCart/checkout', [
            'cart' => $cart,
            'total_weight' => $total_weight,
            'provinsi' => json_decode($provinsi)->rajaongkir->results,
            'title' => 'Checkout'
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

    public function beli()
    {
        $headerEnt = new \App\Entities\Header_Transaksi();

        $barangModel = new \App\Models\BarangModel();
        $header = new \App\Models\Header_TransaksiModel();
        $item = new \App\Models\Item_TransaksiModel();
        $barangModel = new \App\Models\BarangModel();

        if ($this->request->getPost()) {
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
            $cart = \Config\Services::cart();

            foreach ($cart->contents() as $items) {
                $itemEnt = new \App\Entities\Item_Transaksi();
                $itemEnt->id_transaksi = $id_head;
                $itemEnt->id_barang = $items['id'];
                $itemEnt->jumlah = $items['qty'];
                $itemEnt->sub_total = $items['subtotal'];

                $barang = $barangModel->find($items['id']);
                $stok = $barang->stok;
                $id_barang = $items['id'];
                $data = [
                    'stok' => $stok - $items['qty'],
                ];
                $barangModel->update($id_barang, $data);
                $item->save($itemEnt);
            }

            $cart->destroy();
            return redirect()->to(site_url('ShoppingCart/view/' . $id_head));
        }
    }
}

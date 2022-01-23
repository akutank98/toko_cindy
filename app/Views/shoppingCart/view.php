<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">


        <?php $jam = date("G");
        if ($jam >= 0 && $jam <= 11)
            $sapa = "Selamat Pagi.";
        else if ($jam >= 12 && $jam <= 15)
            $sapa = "Selamat Siang.";
        else if ($jam >= 16 && $jam <= 18)
            $sapa = "Selamat Sore.";
        else if ($jam >= 19 && $jam <= 23)
            $sapa = "Selamat Malam.";
        //status 

        if ($head->status == 0) {
            $status = 'Belum lunas';
        } else if ($head->status == 1) {
            $status = 'Sudah Lunas';
        } else if ($head->status == 2) {
            $status = 'selesai';
        }
        ?>
        <div class="table-responsive ">
            <table class="table">
                <th style="width: 18%;">ID Transaksi
                <td style="width: 0%;">:</td>
                <td> <?= $head->id_header ?></td>
                </th>
                <tr>
                    <td>Pembeli</td>
                    <td>:</td>
                    <td><?= $head->username ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= $head->alamat ?></td>
                </tr>
                <tr>
                    <td>Ongkir</td>
                    <td>:</td>
                    <td><?= $head->ongkir ?></td>
                </tr>
                <tr>
                    <td>Total </td>
                    <td>:</td>
                    <td><?= $head->total_harga; ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><?= $status; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="mb-3">
        <table cellpadding="6" cellspacing="1" style="width:90%" class="table-bordered">
            <th colspan="2">Nama Barang</th>
            <th>Jumlah</th>
            <th>Sub Total</th>
            <?php foreach ($items as $index => $barang) : ?>
                <?php $b = $barangModel->find($barang->id_barang); ?>
                <tr>
                    <td colspan="2">
                        <?= ($b->nama); ?>
                    </td>
                    <td><?= $barang->jumlah; ?></td>
                    <td class="text-right"><?= "Rp " . number_format($barang->sub_total, 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a href="https://api.whatsapp.com/send?phone=628155051048&text=<?= urlencode($sapa . ' Admin / Owner Toko Cindy') . '%0a' . urlencode('Konfirmasi pesanan dengan ID : ' . $head->id_header) . '%0a' . urlencode('Nama User :  ' . $head->id_pembeli) . '%0a' . urlencode('Tanggal transaksi : ' . date("d-m-Y", strtotime($head->created_date))) . urlencode(' Total Pembelian : ' . $head->total_harga); ?>" target="_blank" class="text-info">Klik Disini Untuk Melakukan Pembayaran</a>
</div>
<?= $this->endSection() ?>
<?= $this->section('script'); ?>
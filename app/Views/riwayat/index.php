<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Transaksi</h1>
<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Ongkir</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Resi Pengiriman</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <div class="container-fluid">
                <?php
                foreach ($data['transaksiModel'] as $index => $transaksi) : ?>
                    <?php $id = $transaksi->id_transaksi ?>
                    <tr>
                        <td><?= $transaksi->id_transaksi; ?></td>
                        <td><?= $transaksi->nama; ?></td>
                        <td><?= $transaksi->jumlah; ?></td>
                        <td><?= $transaksi->ongkir; ?></td>
                        <td><?= $transaksi->total_harga; ?></td>
                        <td><?= date("d-m-Y", strtotime($transaksi->created_date)); ?></td>
                        <td>
                            <?php if ($transaksi->status == 0) {
                                echo "Belum lunas";
                            } else {
                                echo "Sudah lunas" ?>
                            <?php } ?>
                        </td>
                        <!-- salam -->
                        <?php $jam = date("G");
                        if ($jam >= 0 && $jam <= 11)
                            $sapa = "Selamat Pagi.";
                        else if ($jam >= 12 && $jam <= 15)
                            $sapa = "Selamat Siang.";
                        else if ($jam >= 16 && $jam <= 18)
                            $sapa = "Selamat Sore.";
                        else if ($jam >= 19 && $jam <= 23)
                            $sapa = "Selamat Malam.";
                        ?>
                        <!-- hanya barang yang sudah lunas dan memiliki resi yang ditampilkan -->
                        <td><?php if ($transaksi->resi != null && $transaksi->status == 1) { ?>
                                <?= $transaksi->resi; ?>
                                <a href="https://cekresi.com/?v=wi1&e=jne&noresi=<?= $transaksi->resi; ?>" class="btn btn-info" target="_blank">Cek resi</a>
                            <?php } else { ?>
                                <a href="https://api.whatsapp.com/send?phone=628155051048&text=<?= urlencode($sapa . ' Admin / Owner Toko Cindy') . '%0a' . urlencode('Konfirmasi pesanan dengan ID : ' . $transaksi->id_transaksi) . '%0a' . urlencode('ID User :  ' . $transaksi->id_pembeli) . '%0a' . urlencode('Tanggal transaksi : ' . date("d-m-Y", strtotime($transaksi->created_date))); ?>" target="_blank" class="text-info">Hubungi Admin</a>
                            <?php } ?>
                        </td>
                    <?php endforeach ?>
            </div>
        </tbody>
    </table>
</div>
<div style="float:left">
    <?= $data['pager']->links('default', 'custom_pagination') ?>
</div>
<?= $this->endSection() ?>
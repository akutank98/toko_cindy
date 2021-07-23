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
            </tr>
        </thead>
        <tbody>
            <div class="container-fluid">
                <?php

                use App\Database\Migrations\transaksi;

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
                                <a href="" class="btn btn-info mt-4" id="btn_back">Cek Resi</a>
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
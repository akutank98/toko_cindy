<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Riwayat Pembelian</h1>

<?php $num = 0; ?>
<?php foreach ($data['head'] as $index => $transaksi) : ?>
    <?php $itemModel = new \App\Models\Item_TransaksiModel();
    $i = $itemModel
        ->join('barang', 'barang on barang.id_barang=item_transaksi.id_barang', 'left')
        ->where('id_transaksi', $transaksi->id_header)
        ->findAll();
    ?>
    <div class="modal fade" id="exampleModalItem<?= $transaksi->id_header; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Rincian barang transaksi : <?= $transaksi->id_header; ?>
                    </h5>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Sub-Total</th>
                        </tr>
                        <?php $tot = 0;
                        foreach ($i as $index => $li) : ?>
                            <tr>
                                <td><?= $li->nama; ?></td>
                                <td><?= $li->jumlah; ?></td>
                                <td class="text-right"><?= "Rp " . number_format($li->sub_total, 2, ',', '.') ?></td>
                            </tr>
                        <?php $tot += $li->sub_total;
                        endforeach; ?>
                        <tr>
                            <th colspan="2" class="text-right">Jumlah :</th>
                            <td class="text-right"><?= "Rp " . number_format($tot, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Ongkir :</th>
                            <td class="text-right"><?= "Rp " . number_format($transaksi->ongkir, 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Total :</th>
                            <td class="text-right"> <?= "Rp " . number_format($transaksi->total_harga, 2, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Resi Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            <div class="container-fluid">
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
                <?php foreach ($data['head'] as $index => $transaksi) : ?>
                    <tr>
                        <td><?= $transaksi->id_header; ?></td>
                        <td><?= $transaksi->created_date; ?></td>
                        <td><?php
                            if ($transaksi->status == 0) {
                                echo 'Belum lunas ';
                            } elseif ($transaksi->status == 1) {
                                echo 'Sudah lunas ';
                            } elseif ($transaksi->status == 2) {
                                echo 'Terkirim ';
                            }
                            ?>
                        </td>
                        <td><?php if ($transaksi->resi != null && $transaksi->status == 2) { ?>
                                <?= $transaksi->resi; ?>
                                <a href="https://cekresi.com/?v=wi1&e=jne&noresi=<?= $transaksi->resi; ?>" class="btn btn-info" target="_blank">Cek resi</a>
                            <?php } else { ?>
                                <a href="https://api.whatsapp.com/send?phone=628155051048&text=<?= urlencode($sapa . ' Admin / Owner Toko Cindy') . '%0a' . urlencode('Konfirmasi pesanan dengan ID : ' . $transaksi->id_header) . '%0a' . urlencode('ID User :  ' . $transaksi->id_pembeli) . '%0a' . urlencode('Tanggal transaksi : ' . date("d-m-Y", strtotime($transaksi->created_date))) . urlencode(' Total Pembelian : ' . date("d-m-Y", strtotime($transaksi->total_harga))); ?>" target="_blank" class="text-info">Hubungi Admin</a>
                            <?php } ?>
                            <button type="button" class="btn btn-secondary ml-1" data-toggle="modal" data-target="#exampleModalItem<?= $transaksi->id_header; ?>">
                                Lihat Rincian Pembelian &raquo;
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </div>
        </tbody>
    </table>
</div>
<div style="float:left">
    <?= $data['pager']->links('default', 'custom_pagination') ?>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" id="cartmsg" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <?php
    $i = 1;
    $total_berat = 0;
    ?>
    <?php if ($cart->totalItems() == 0) { ?>
        <h2 class="mt-2" style="text-align: center;"><strong>Keranjang belanja kosong</strong></h2>
        <div style="font-size: 15vw;text-align: center; ">
            &#128722;
        </div>
        <div class="text-center">
            <a href="<?= site_url('Etalase/index') ?>" style="text-decoration: none; font-size: large;">Tambahkan barang ke dalam keranjang belanja anda</a>
        </div>
    <?php } else { ?>


        <table cellpadding="6" cellspacing="1" style="width:100%" border="0">
            <tr>
                <th>Nama barang</th>
                <th>Gambar</th>
                <th>Jumlah</th>
                <th style="text-align:right">Harga</th>
                <th style="text-align:right">Sub-Total</th>
                <th>Aksi</th>
            </tr>
            <?php $i = 1; ?>
            <?= form_open('ShoppingCart/update'); ?>
            <?php foreach ($cart->contents() as $index => $items) : ?>
                <tr>
                    <td><?= $items['name']; ?></td>
                    <?php $stok = 0;
                    $modelBarang = new \App\Models\BarangModel();
                    $barang = $modelBarang->find($items['id']);
                    $stok = $barang->stok;
                    ?>
                    <td><img width="100px" height="100px" src="<?= base_url('uploads/' . $barang->gambar) ?>"></td>
                    <td style="text-align: center;"><input type="number" min="1" max="<?= $stok; ?>" name="<?= 'qty' . $i; ?>" class="form-control" value="<?= $items['qty']; ?>"></td>
                    <td style="text-align: right;"><?= "Rp " . number_format($items['price'], 2, ',', '.') ?></td>
                    <input type="hidden" name="rowid[]" value="<?= $items['rowid']; ?>">
                    <td style="text-align: right;"><input type="text" name="total[]" disabled value="<?= "Rp " . number_format($items['qty'] * $items['price'], 2, ',', '.') ?>"></td>
                    <td>
                        <a href="<?= site_url('ShoppingCart/delete/' . $items['rowid']) ?>" class="btn text-danger">&#128473;</a>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
            <td colspan="3"> </td>
            <td style="text-align: right;"><strong>Total</strong></td>
            <td style="text-align: right;"><input type="text" name="allTotal" disabled value=" <?= "Rp " . number_format($cart->total(), 2, ',', '.') ?>"></td>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="text-align: right;"><label class="text-danger small">*Harga ini belum termasuk ongkos kirim</label></td>
            </tr>
        </table>

        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="<?= site_url('ShoppingCart/checkout'); ?>" class="btn btn-success">Checkout</a>
        <?= form_close(); ?>
    <?php } ?>

</div>
<?= $this->endSection() ?>
<?= $this->section('script'); ?>
<script>
    setTimeout(function() {
        $('#cartmsg').fadeOut('slow');
    }, 2400);
</script>
<?= $this->endSection(); ?>
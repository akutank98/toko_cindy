<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container" style="padding-bottom: 15vh;">
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" id="cartmsg" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <div class="card col-10 mr-auto ml-auto">
        <div class="card-body">
            <img class="img-fluid card-card-img-top" src="<?= base_url('uploads/' . $model->gambar) ?>" />
            <h1 style="font-size: 2.2rem;" class="text-success"><?= $model->nama ?></h1>
            <h4 style="font-size: 1.1rem;"> Harga : <?= "Rp " . number_format($model->harga, 2, ',', '.'); ?></h4>
            <h4 style="font-size: 1.1rem;"> Stok : <?= $model->stok ?></h4>
            <?php if ($model->ukuran == null && $model->berat == null) : ?>
                <div class="text-body" style="font-size:1.1rem;">Berat : 500 gram</div>
                <div class="text-body" style="font-size:1.1rem;">Ukuran : - </div>
                <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                <p class="text-body" style="font-size:1.1rem;">Tidak ada deskripsi</p>
                <!-- jika sudah ada deskripsi -->
            <?php else : ?>
                <div class="text-body" style="font-size:1.1rem;">Berat : <?= $model->berat ?>gram</div>
                <div class="text-body" style="font-size:1.1rem;">Ukuran : <?= $model->ukuran ?></div>
                <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                <div class="form-group">
                    <textarea style="resize: none;" readonly class="form-control" rows="<?= substr_count($model->deskripsi, "\n") + 1; ?>" id="exampleFormControlTextarea1" style="font-size:1.1rem;"><?= $model->deskripsi ?></textarea>
                </div>
            <?php endif ?>
            <a href="<?= site_url('Etalase/addCart/' . $model->id_barang) ?>" class="btn btn-success">Tambahkan ke keranjang &#x1F6D2;</a>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    setTimeout(function() {
        $('#cartmsg').fadeOut('slow');
    }, 2400);
</script>
<?= $this->endSection(); ?>
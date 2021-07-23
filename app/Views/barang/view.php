<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>View Barang</h1>
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" alt="image" src="<?= base_url('uploads/' . $barang->gambar); ?>" />
                </div>
            </div>
        </div>
        <div class="col-6">
            <h1 class="text-left" style="font-size:3vw;"><?= $barang->nama ?></h1>
            <div class="text-body" style="font-size:2vw;">Harga : <?= $barang->harga ?></div>
            <div class="text-body" style="font-size:2vw;">Stok : <?= $barang->stok ?></div>
            <div class="text-body" style="font-size:2vw;">Berat : <?= $des->berat ?>gram</div>
            <div class="text-body" style="font-size:2vw;">Ukuran : <?= $des->ukuran ?></div>
            <div class="text-body" style="font-size:2vw;">Deskripsi : </div>
            <p class="text-body" style="font-size:1.7vw;"><?= $des->deskripsi ?></p>
            <div class="container-fluid">
                <!-- jika sudah ada deskripsi -->
                <?php if ($des == null) : ?>
                    <a href=" <?= site_url('barang/deskripsi/' . $barang->id_barang) ?>" class="btn btn-warning mt-4" id="btn_back">Tambah Deskripsi</a>
                    <!-- jika sudah ada deskripsi -->
                <?php else : ?>
                    <a href="<?= site_url('barang/updateDeskripsi/' . $barang->id_barang) ?>" class="btn btn-warning mt-4" id="btn_back">Ubah Deskripsi</a>
                <?php endif ?>
                <a href="<?= site_url('barang/index') ?>" class="btn btn-primary mt-4" id="btn_back">List Barang</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
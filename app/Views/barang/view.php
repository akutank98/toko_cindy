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
            <div class="container-fluid">
                <h1 class="text-left" style="font-size:2.2rem;"><?= $barang->nama ?></h1>
                <div class="text-body" style="font-size:1.1rem;">Harga : <?= $barang->harga ?></div>
                <div class="text-body" style="font-size:1.1rem;">Stok : <?= $barang->stok ?></div>
                <!-- hanya owner yang dapat menambah dan update deskrips -->

                <!-- jika belum ada deskripsi -->
                <?php if ($des == null) : ?>
                    <div class="text-body" style="font-size:1.1rem;">Berat : - gram</div>
                    <div class="text-body" style="font-size:1.1rem;">Ukuran : - </div>
                    <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                    <p class="text-body" style="font-size:1.1rem;">Tidak ada deskripsi</p>
                    <?php if (session()->get('role') == 0) : ?>
                        <a href=" <?= site_url('barang/deskripsi/' . $barang->id_barang) ?>" class="btn btn-warning mt-4" id="btn_back">Tambah Deskripsi</a>
                    <?php endif; ?>
                    <!-- jika sudah ada deskripsi -->
                <?php else : ?>
                    <div class="text-body" style="font-size:1.1rem;">Berat : <?= $des->berat ?>gram</div>
                    <div class="text-body" style="font-size:1.1rem;">Ukuran : <?= $des->ukuran ?></div>
                    <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                    <p class="text-body" style="font-size:1.1rem;"><?= $des->deskripsi ?></p>
                    <?php if (session()->get('role') == 0) : ?>
                        <a href="<?= site_url('barang/updateDeskripsi/' . $barang->id_barang) ?>" class="btn btn-warning mt-4" id="btn_back">Ubah Deskripsi</a>
                    <?php endif; ?>
                <?php endif ?>
                <a href="<?= site_url('barang/index') ?>" class="btn btn-primary mt-4" id="btn_back">List Barang</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
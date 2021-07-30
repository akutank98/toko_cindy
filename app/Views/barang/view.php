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
                <div class="text-body" style="font-size:1.1rem;">Harga : <?= "Rp " . number_format($barang->harga, 2, ',', '.'); ?></div>
                <div class="text-body" style="font-size:1.1rem;">Stok : <?= $barang->stok ?></div>
                <!-- hanya owner yang dapat menambah dan update deskrips -->

                <!-- jika belum ada deskripsi -->
                <?php if ($barang->ukuran == null && $barang->berat == null) : ?>
                    <div class="text-body" style="font-size:1.1rem;">Berat : 500 gram</div>
                    <div class="text-body" style="font-size:1.1rem;">Ukuran : - </div>
                    <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                    <p class="text-body" style="font-size:1.1rem;">Tidak ada deskripsi</p>
                    <!-- jika sudah ada deskripsi -->
                <?php else : ?>
                    <div class="text-body" style="font-size:1.1rem;">Berat : <?= $barang->berat ?>gram</div>
                    <div class="text-body" style="font-size:1.1rem;">Ukuran : <?= $barang->ukuran ?></div>
                    <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                    <div class="form-group">
                        <textarea style="resize: none;" readonly class="form-control" rows="<?= substr_count($barang->deskripsi, "\n") + 1; ?>" id="exampleFormControlTextarea1" style="font-size:1.1rem;"><?= $barang->deskripsi ?></textarea>
                    </div>
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
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="container-fluid mb-3">
        <form class="d-flex" role="form" action="<?= site_url('etalase/search'); ?>" method="post">
            <input class="form-control me-2" name="nama_barang" type="search" placeholder="Cari Barang" aria-label="Search">
            <button type="submit" class="btn btn-info">Search</button>
        </form>
    </div>
    <div class="row">
        <?php foreach ($data['model'] as $m) : ?>
            <div class="col-12 col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <span><label style="color:black"><?= $m->nama ?></label></span>
                    </div>
                    <div class="card-body">
                        <img class="img-thumbnail" style="object-fit: contain;height :300px;width:fit-content" " src=" <?= base_url('uploads/' . $m->gambar) ?>" />
                        <h5 class="mt-3 text-success" style="font-size: small;"><?= "Rp " . number_format($m->harga, 2, ',', '.') ?></h5>
                        <p class="text-info">Stok : <?= $m->stok ?></p>
                    </div>
                    <div class="card-footer mb-3">
                        <a href="<?= site_url('etalase/beli/' . $m->id_barang) ?>" style="width:100%" class="btn btn-success">Beli</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<div style="float:left">
    <?= $data['pager']->links('default', 'custom_pagination') ?>
</div>
<?= $this->endSection() ?>
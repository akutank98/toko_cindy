<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="container-fluid mb-3">
        <form class="d-flex mb-3" role="form" action="<?= site_url('Etalase/search'); ?>" method="post">
            <?= csrf_field(); ?>
            <input class="form-control me-2" name="barang" type="search" placeholder="Cari Barang" aria-label="Search">
            <button type="submit" class="btn btn-info">Search</button>
        </form>
    </div>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" id="cartmsg" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
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
                        <?= form_open('ShoppingCart/add'); ?>
                        <a href="<?= site_url('Etalase/beli/' . $m->id_barang) ?>" style="width:80%; background-color: palevioletred !important; " class="btn btn-dark">Beli</a>
                        <?= form_hidden('id', $m->id_barang); ?>
                        <?= form_hidden('price', $m->harga); ?>
                        <?= form_hidden('name', $m->nama); ?>
                        <?= form_hidden('gambar', $m->gambar); ?>
                        <?= form_hidden('berat', $m->berat); ?>
                        <input type="hidden" name="currentPage" value="<?= $data['pager']->getCurrentPage('default'); ?>">
                        <button type="submit" style="width:18%; background-color: green !important; " class="btn btn-dark">&#x1F6D2;</button>
                        <?= form_close(); ?>
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
<?= $this->section('script'); ?>
<script>
    setTimeout(function() {
        $('#cartmsg').fadeOut('slow');
    }, 2400);
</script>
<?= $this->endSection(); ?>
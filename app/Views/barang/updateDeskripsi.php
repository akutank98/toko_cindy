<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
$session = session();
$errors = $session->getFlashdata('errors_updateDeskripsi');
?>
<div class="container">
    <div class="row">
        <h4 class="text-left">Ubah Deskripsi barang dengan ID : <?= $barang->id_barang; ?></h4>
        <?php if ($errors != null) : ?>
            <div class="alert alert-danger">
                <h4 class="alert-heading">Error </h4>
                <hr>
                <p class="mb-0">
                    <?php foreach ($errors as $err) {
                        echo $err . '<br>';
                    } ?>
                </p>
            </div>
        <?php endif ?>
        <form action="" class="form-control" method="post">
            <?= csrf_field(); ?>
            <label for="ukuran">Masukkan ukuran</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if ($barang->ukuran == 'S')  echo "checked"; ?> name="ukuran" id="inlineRadio1" value="S">
                <label class="form-check-label" for="inlineRadio1">S</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if ($barang->ukuran == 'M')  echo "checked"; ?> name="ukuran" id="inlineRadio2" value="M">
                <label class="form-check-label" for="inlineRadio2">M</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if ($barang->ukuran == 'L')  echo "checked"; ?> name="ukuran" id="inlineRadio3" value="L">
                <label class="form-check-label" for="inlineRadio2">L</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if ($barang->ukuran == 'Lainnya')  echo "checked"; ?> name="ukuran" id="inlineRadio4" value="Lainnya">
                <label class="form-check-label" for="inlineRadio2">Lainnya</label>
            </div>
            <div class="form-group">
                <label for="ukuran">Masukkan berat</label>
                <input type="number" name="berat" value="<?= $barang->berat; ?>" class="form-control" placeholder=" Satuan(gram)">
            </div>
            <div class="form-group">
                <label for="TextArea">Masukkan Deskripsi</label>
                <textarea class="form-control" style="resize: none;" name=" deskripsi" id="TextArea" rows="<?= substr_count($barang->deskripsi, "\n") + 1; ?>"><?= $barang->deskripsi; ?> </textarea>
            </div>
            <button type=" submit" class="btn btn-primary mb-1">Simpan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<?php

$nama = [
    'name' => 'nama',
    'id' => 'nama',
    'value' =>  old('nama'),
    'class' => 'form-control',
    'required' => true
];

$harga = [
    'name' => 'harga',
    'id' => 'harga',
    'value' => null,
    'class' => 'form-control',
    'type' => 'number',
    'min' => 0,
    'required' => true,
];

$stok = [
    'name' => 'stok',
    'id' => 'stok',
    'value' => null,
    'class' => 'form-control',
    'type' => 'number',
    'min' => 0,
    'required' => true,

];

$gambar = [
    'name' => 'gambar',
    'id' => 'gambar',
    'value' => null,
    'class' => 'form-control',
];

$submit = [
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Submit',
    'class' => 'btn btn-success',
    'type' => 'submit',
];

$session = session();
$errors = $session->getFlashdata('errors_create');

?>
<div class="container">
    <h1>Tambah Barang</h1>
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
    <?= form_open_multipart('Barang/create') ?>
    <div class="form-group">
        <?= form_label("Nama", "nama") ?>
        <?= form_input($nama) ?>
    </div>

    <div class="form-group">
        <?= form_label("Harga", "harga") ?>
        <?= form_input($harga) ?>
    </div>

    <div class="form-group">
        <?= form_label("Stok", "stok") ?>
        <?= form_input($stok) ?>
    </div>

    <label for="ukuran">Masukkan ukuran</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ukuran" id="inlineRadio1" value="S" required>
        <label class="form-check-label" for="inlineRadio1">S</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ukuran" id="inlineRadio2" value="M">
        <label class="form-check-label" for="inlineRadio2">M</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ukuran" id="inlineRadio3" value="L">
        <label class="form-check-label" for="inlineRadio2">L</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="ukuran" id="inlineRadio4" value="Lainnya">
        <label class="form-check-label" for="inlineRadio2">Lainnya</label>
    </div>
    <div class="form-group">
        <label for="ukuran">Masukkan berat</label>
        <input type="number" name="berat" class="form-control" placeholder=" Satuan(gram)" required>
    </div>
    <div class="form-group">
        <label for="TextArea">Masukkan Deskripsi</label>
        <textarea style="resize: none;" class="form-control" name="deskripsi" id="TextArea" rows="3"></textarea>
    </div>

    <div class="form-group">
        <?= form_label("Gambar", "gambar") ?>
        <?= form_upload($gambar) ?>
    </div>

    <div class="text-left">
        <?= form_submit($submit) ?>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
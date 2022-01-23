<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<?php

$nama = [
	'name' => 'nama',
	'id' => 'nama',
	'value' => $barang->nama,
	'class' => 'form-control',
];

$harga = [
	'name' => 'harga',
	'id' => 'harga',
	'value' => $barang->harga,
	'class' => 'form-control',
	'type' => 'number',
	'min' => 0,
];

$stok = [
	'name' => 'stok',
	'id' => 'stok',
	'value' => $barang->stok,
	'class' => 'form-control',
	'type' => 'number',
	'min' => 0,
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

?>
<div class="container" style="padding-bottom: 4vw;">
	<h1>Update Barang</h1>

	<?= form_open_multipart('Barang/update/' . $barang->id_barang) ?>
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
	<img class="img-fluid" alt="image" src="<?= base_url('uploads/' . $barang->gambar) ?>" />

	<div class="form-group">
		<?= form_label("Gambar", "gambar") ?>
		<?= form_upload($gambar) ?>
	</div>
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

	<div class="text-right">
		<?= form_submit($submit) ?>
	</div>

	<?= form_close(); ?>
</div>
<?= $this->endSection(); ?>
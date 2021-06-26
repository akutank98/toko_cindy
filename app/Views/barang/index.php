<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container">
	<div class="row">
		<h1>Barang</h1>
		<table class="table">
			<thead>
				<th scope="col">No</th>
				<th scope="col">Barang</th>
				<th scope="col">Gambar</th>
				<th scope="col">Harga</th>
				<th scope="col">Stok</th>
				<th scope="col">Aksi</th>
			</thead>
			<tbody>
				<?php foreach ($barangs as $index => $barang) : ?>
					<tr>
						<th scope="row"><?= ($index + 1) ?></th>
						<td><?= $barang->nama ?></td>
						<td>
							<img class="img-fluid" style="object-fit: contain;" width="200px" alt="gambar" src="<?= base_url('uploads/' . $barang->gambar) ?>" />
						</td>
						<td><?= $barang->harga ?></td>
						<td><?= $barang->stok ?></td>
						<td>
							<a href="<?= site_url('barang/view/' . $barang->id_barang) ?>" class="btn btn-primary">View</a>
							<a href="<?= site_url('barang/update/' . $barang->id_barang) ?>" class="btn btn-success">Update</a>
							<a href="<?= site_url('barang/delete/' . $barang->id_barang) ?>" class="btn btn-danger">Delete</a>
						</td>
					</tr>
				<?php endforeach ?>

			</tbody>
		</table>
	</div>
</div>
<?= $this->endSection() ?>
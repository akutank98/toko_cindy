<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container">
	<div class="container-fluid">
		<div>
			<h1>Barang</h1>
		</div>
		<form class="d-flex mb-3" role="form" action="<?= site_url('barang/search'); ?>" method="post">
			<?= csrf_field(); ?>
			<input class="form-control me-2" name="barang" type="search" placeholder="Cari Barang" aria-label="Search">
			<button type="submit" class="btn btn-info">Search</button>
		</form>
	</div>
	<div class="row">
		<table class="table">
			<thead>
				<th scope="col">ID</th>
				<th scope="col">Barang</th>
				<th scope="col">Gambar</th>
				<th scope="col">Harga</th>
				<th scope="col">Stok</th>
				<th scope="col">Aksi</th>
			</thead>
			<tbody>
				<?php foreach ($data['barangs'] as $index => $barang) : ?>
					<!-- modal ubah stok -->
					<div class="modal fade" id="exampleModalStok<?= $barang->id_barang; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">
										Ubah Stok Barang : <?= $barang->nama; ?></h5>
								</div>
								<form action="/barang/updateStok/<?= $barang->id_barang; ?>" method="post">
									<?= csrf_field() ?>
									<div class="modal-body">
										<label class="form-label-group" for="stok">Stok : </label>
										<input class="form-control" name="stok" id="<?= 'stok' . $barang->id_barang; ?>" value="<?= $barang->stok; ?>" type="number" min="1">
									</div>
									<div class=" modal-footer">
										<button onclick="document.getElementById('<?= 'stok' . $barang->id_barang; ?>').value = <?= $barang->stok; ?>" class="btn btn-secondary" data-dismiss="modal">Batal</button>
										<button type="submit" class="btn btn-info">Simpan</button>
									</div>
								</form>
							</div>
						</div>
						<?php
						if ($barang->stok == 0) {
							$bcolor = 'background-color: beige;';
						} else {
							$bcolor = 'background-color: transparent;';
						} ?>
						<tr style="<?= $bcolor; ?>">
							<th scope="row"><?= $barang->id_barang ?></th>
							<td><?= $barang->nama ?></td>
							<td>
								<img class="img-fluid" style="object-fit: contain;" width="200px" alt="gambar" src="<?= base_url('uploads/' . $barang->gambar) ?>" />
							</td>
							<td><?= $barang->harga ?></td>
							<td><?= $barang->stok ?></td>
							<td>
								<a href="<?= site_url('barang/view/' . $barang->id_barang) ?>" class="btn btn-primary">View</a>
								<!-- hanya owner yang dapat update dan delete data -->
								<?php if (session()->get('role') == 0) : ?>
									<a href="<?= site_url('barang/update/' . $barang->id_barang) ?>" class="btn btn-success">Update</a>
									<!-- modal trigger button owner-->
									<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalStok<?= $barang->id_barang; ?>">
										Ubah Stok
									</button>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $barang->id_barang; ?>">
										Hapus
									</button>
								<?php elseif (session()->get('role') == 1) : ?>
									<!-- modal trigger button admin -->
									<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalStok<?= $barang->id_barang; ?>">
										Ubah Stok
									</button>
								<?php endif; ?>

								<!-- Modal Owner-->
								<div class="modal fade" id="exampleModal<?= $barang->id_barang; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">
													Konfirmasi Hapus Barang</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												</button>
											</div>
											<div class="modal-body">
												Apakah anda yakin akan menghapus barang <?= $barang->nama; ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
												<a href="<?= site_url('barang/delete/' . $barang->id_barang) ?>" class="btn btn-danger">Hapus</a>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<div style="float:left">
	<?= $data['pager']->links('default', 'custom_pagination') ?>
</div>
<?= $this->endSection() ?>
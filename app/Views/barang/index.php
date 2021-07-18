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
				<?php foreach ($data['barangs'] as $index => $barang) : ?>
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
							<!-- modal button-->
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $barang->id_barang; ?>">
								Hapus
							</button>
							<!-- Modal -->
							<div class="modal fade" id="exampleModal<?= $barang->id_barang; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">
												Konfirmasi Hapus Barang</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											Apakah anda yakin akan menghapus barang <?= $barang->nama; ?>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<a href="<?= site_url('barang/delete/' . $barang->id_barang) ?>" class="btn btn-danger">Hapus</a>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				<?php endforeach ?>

			</tbody>
		</table>
	</div>
</div>
<div style="float:left">
	<?= $data['pager']->links('default', 'custom_pagination') ?>
</div>
<?= $this->endSection() ?>
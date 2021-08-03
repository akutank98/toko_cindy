<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
	<div>
		<h1>Transaksi</h1>
	</div>
	<form class="d-flex mb-3" role="form" action="<?= site_url('Transaksi/search');  ?>" method="post">
		<?= csrf_field(); ?>
		<input class="form-control me-2" name="id" type="search" placeholder="Cari Transaksi (ID)" aria-label="Search">
		<button type="submit" class="btn btn-info">Search</button>
	</form>
</div>
<div class="row">
	<table class="table">
		<thead>
			<tr>
				<th>ID Transaksi</th>
				<th>ID Barang</th>
				<th>Barang</th>
				<th>Pembeli</th>
				<th>Alamat</th>
				<th>Service</th>
				<th>Jumlah</th>
				<th>Total</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data['model'] as $index => $transaksi) : ?>
				<?php
				$color = 'background-color: transparent;';
				if ($transaksi->status == 0) {
					$color = 'background-color: whitesmoke;';
				} elseif ($transaksi->status == 1 && $transaksi->resi == null) {
					$color = 'background-color: lightyellow;';
				} elseif ($transaksi->status == 2) {
					$color = 'background-color: lightcyan;';
				}
				?>
				<!-- modal untuk batal -->
				<div class="modal fade" id="exampleModalBatal<?= $transaksi->id_transaksi; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">
									Batalkan transaksi
								</h5>
							</div>
							<form action="/Transaksi/batalTransaksi/<?= $transaksi->id_transaksi; ?>" method="post">
								<?= csrf_field() ?>
								<div class="modal-body">
									<label class="form-label-group" for="resi">Batalkan pesanan : <?= $transaksi->id_transaksi; ?> </label>
								</div>
								<div class=" modal-footer">
									<button class="btn btn-secondary" data-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-info">Simpan</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- init modal value resi -->
				<div class="modal fade" id="exampleModalResi<?= $transaksi->id_transaksi; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">
									Detail Pengiriman
								</h5>
							</div>
							<form action="/transaksi/updateresi/<?= $transaksi->id_transaksi; ?>" method="post">
								<?= csrf_field() ?>
								<div class="modal-body">
									<label class="form-label-group" for="resi">Resi : </label>
									<input class="form-control" name="resi" id="<?= 'resi' . $transaksi->id_transaksi; ?>" value="<?= $transaksi->resi; ?>" <?php if ($transaksi->status != 0 && $transaksi->resi != null) echo 'readonly'; ?> type="text">
								</div>
								<?php if ($transaksi->status != 0 && $transaksi->resi != null) {
									$display = 'none';
								} else {
									$display = 'block';
								} ?>
								<div class=" modal-footer">
									<button onclick="document.getElementById('<?= 'stok' . $transaksi->id_transaksi; ?>').value = <?= $transaksi->resi; ?>" class="btn btn-secondary" data-dismiss="modal">Batal</button>
									<button type="submit" style="display: <?= $display; ?>;" class="btn btn-info">Simpan</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php $id = $transaksi->id_transaksi ?>
				<tr style="<?= $color; ?>">
					<td><?= $transaksi->id_transaksi; ?></td>
					<td><?= $transaksi->id_barang; ?></td>
					<td><?= $transaksi->nama; ?></td>
					<td><?= $transaksi->id_pembeli; ?></td>
					<td><?= $transaksi->alamat; ?></td>
					<td><?= $transaksi->service; ?></td>
					<td><?= $transaksi->jumlah; ?></td>
					<td><?= $transaksi->total_harga; ?></td>
					<td>
						<?php
						if ($transaksi->status == 0) {
							echo 'Belum lunas ';
						} elseif ($transaksi->status == 1) {
							echo 'Sudah lunas ';
						} elseif ($transaksi->status == 2) {
							echo 'Terkirim ';
						}

						?>
						<!-- modal button status-->
						<?php if (session()->get('role') == 0 && $transaksi->status == 0) { ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $transaksi->id_transaksi; ?>">
								Ubah
							</button>
						<?php } ?>
						<!-- Modal status -->
						<div class="modal fade" id="exampleModal<?= $transaksi->id_transaksi; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">
											Ubah Status Pembayaran</h5>
									</div>
									<div class="modal-body">
										Apakah anda yakin akan mengubah status pembayaran transaksi dengan ID <?= $transaksi->id_transaksi; ?>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<a href="/transaksi/updateStatusTransaksi/<?= $transaksi->id_transaksi; ?>" type="button" class="btn btn-primary">Simpan</a>
									</div>
								</div>
							</div>
						</div>
					</td>
					<td class="d-inline-flex">
						<!-- hanya transaksi yang sudah lunas yang dapat ditambah / dilihat resi dan download invoice -->
						<?php if ($transaksi->status != 0) {  ?>
							<a href=" <?= site_url('Transaksi/downloadInvoice/' . $transaksi->id_transaksi) ?>" class="btn btn-primary" target="_blank">Download</a>
							<button type="button" class="btn btn-warning ml-1" data-toggle="modal" data-target="#exampleModalResi<?= $transaksi->id_transaksi; ?>">Resi</button>
						<?php } else { ?>
							<button type="button" class="btn btn-danger ml-1" data-toggle="modal" data-target="#exampleModalBatal<?= $transaksi->id_transaksi; ?>">Batal</button>
						<?php } ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<div style="float:left">
	<?= $data['pager']->links('default', 'custom_pagination') ?>
</div>
<?= $this->endSection() ?>
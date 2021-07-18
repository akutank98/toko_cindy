<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container">
	<div class="row">
		<h1>Transaksi</h1>
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Barang</th>
					<th>Pembeli</th>
					<th>Alamat</th>
					<th>Jumlah</th>
					<th>Harga</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ($model as $index => $transaksi) : ?>
					<?php $id = $transaksi->id_transaksi ?>
					<tr>
						<td><?= $transaksi->id_transaksi; ?></td>
						<td><?= $transaksi->id_barang; ?></td>
						<td><?= $transaksi->id_pembeli; ?></td>
						<td><?= $transaksi->alamat; ?></td>
						<td><?= $transaksi->jumlah; ?></td>
						<td><?= $transaksi->total_harga; ?></td>
						<td>

							<?php
							if ($transaksi->status == 0) {
								echo 'Belum lunas ';
							} else {
								echo 'Sudah lunas ';
							}
							?>
							<!-- modal button-->
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $transaksi->id_transaksi; ?>">
								Ubah
							</button>

							<!-- Modal -->
							<div class="modal fade" id="exampleModal<?= $transaksi->id_transaksi; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">
												Konfirmasi Pembayaran</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
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
						<td>
							<a href="<?= site_url('transaksi/view/' . $transaksi->id_transaksi) ?>" class="btn btn-warning">View</a>
							<a href=" <?= site_url('transaksi/invoice/' . $transaksi->id_transaksi) ?>" class="btn btn-info" target="_blank">Send</a>
							<a href=" <?= site_url('transaksi/downloadInvoice/' . $transaksi->id_transaksi) ?>" class="btn btn-primary" target="_blank">Download</a>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?= $this->endSection() ?>
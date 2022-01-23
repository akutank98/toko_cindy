<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Transaksi</h1>
<div class="container-fluid">
	<form class="d-flex mb-3" role="form" action="<?= site_url('Transaksi/search');  ?>" method="post">
		<?= csrf_field(); ?>
		<input class="form-control me-2" name="id" type="search" placeholder="Cari Transaksi (ID)" aria-label="Search">
		<button type="submit" class="btn btn-info">Search</button>
	</form>
</div>
<?php $num = 0; ?>
<?php foreach ($data['head'] as $index => $transaksi) : ?>
	<?php $itemModel = new \App\Models\Item_TransaksiModel();
	$i = $itemModel
		->join('barang', 'barang on barang.id_barang=item_transaksi.id_barang', 'left')
		->where('id_transaksi', $transaksi->id_header)
		->findAll();
	?>
	<!-- modal untuk batal -->
	<div class="modal fade" id="exampleModalBatal<?= $transaksi->id_header; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Batalkan transaksi
					</h5>
				</div>
				<form action="/Transaksi/batalTransaksi/<?= $transaksi->id_header; ?>" method="post">
					<?= csrf_field() ?>
					<div class="modal-body">
						<label class="form-label-group" for="resi">Batalkan pesanan : <?= $transaksi->id_header; ?> </label>
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
	<div class="modal fade" id="exampleModalResi<?= $transaksi->id_header; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Detail Pengiriman
					</h5>
				</div>
				<form action="/transaksi/updateresi/<?= $transaksi->id_header; ?>" method="post">
					<?= csrf_field() ?>
					<div class="modal-body">
						<label class="form-label-group" for="resi">Resi : </label>
						<input class="form-control" name="resi" id="<?= 'resi' . $transaksi->id_header; ?>" value="<?= $transaksi->resi; ?>" <?php if ($transaksi->status != 0 && $transaksi->resi != null) echo 'readonly'; ?> type="text">
					</div>
					<?php if ($transaksi->status != 0 && $transaksi->resi != null) {
						$display = 'none';
					} else {
						$display = 'block';
					} ?>
					<div class=" modal-footer">
						<button onclick="document.getElementById('<?= 'resi' . $transaksi->id_header; ?>').value = <?= $transaksi->resi; ?>" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" style="display: <?= $display; ?>;" class="btn btn-info">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal Item Transaksi -->
	<div class="modal fade" id="exampleModalItem<?= $transaksi->id_header; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Rincian barang transaksi : <?= $transaksi->id_header; ?>
					</h5>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<tr>
							<th>Nama</th>
							<th>Jumlah</th>
							<th>Sub-Total</th>
						</tr>
						<?php $tot = 0;
						foreach ($i as $index => $li) : ?>
							<tr>
								<td><?= $li->nama; ?></td>
								<td><?= $li->jumlah; ?></td>
								<td class="text-right"><?= "Rp " . number_format($li->sub_total, 2, ',', '.') ?></td>
							</tr>
						<?php $tot += $li->sub_total;
						endforeach; ?>
						<tr>
							<th colspan="2" class="text-right">Jumlah :</th>
							<td class="text-right"><?= "Rp " . number_format($tot, 2, ',', '.') ?></td>
						</tr>
						<tr>
							<th colspan="2" class="text-right">Ongkir :</th>
							<td class="text-right"><?= "Rp " . number_format($transaksi->ongkir, 2, ',', '.') ?></td>
						</tr>
						<tr>
							<th colspan="2" class="text-right">Total :</th>
							<td class="text-right"> <?= "Rp " . number_format($transaksi->total_harga, 2, ',', '.') ?></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>
<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th>ID Transaksi</th>
				<th>Pembeli</th>
				<th style="width: fit-content;">Alamat</th>
				<th>Service</th>
				<th>Total</th>
				<th>Tanggal</th>
				<th>Status</th>
				<th>Resi Pengiriman</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data['head'] as $index => $transaksi) : ?>
				<?php
				$status = '';
				if ($transaksi->status == 0) {
					$status =  'Belum lunas ';
				} elseif ($transaksi->status == 1) {
					$status =  'Sudah lunas ';
				} elseif ($transaksi->status == 2) {
					$status =  'Terkirim ';
				}
				$color = 'background-color: transparent;';
				if ($transaksi->status == 0) {
					$color = 'background-color: whitesmoke;';
				} elseif ($transaksi->status == 1 && $transaksi->resi == null) {
					$color = 'background-color: lightyellow;';
				} elseif ($transaksi->status == 2) {
					$color = 'background-color: lightcyan;';
				}
				?>
				<tr style="<?= $color; ?>">
					<td><?= $transaksi->id_header; ?></td>
					<td><?= $transaksi->username; ?></td>
					<td><?= $transaksi->alamat; ?></td>
					<td><?= $transaksi->service; ?></td>
					<td style="white-space:nowrap;"><?= "Rp " . number_format($transaksi->total_harga, 2, ',', '.') ?></td>
					<td><?= $transaksi->created_date; ?></td>
					<td><?= $status; ?>
						<?php if (session()->get('role') == 0 && $transaksi->status == 0) { ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $transaksi->id_header; ?>">
								Ubah
							</button>
						<?php } ?>
						<!-- Modal status -->
						<div class="modal fade" id="exampleModal<?= $transaksi->id_header; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">
											Ubah Status Pembayaran</h5>
									</div>
									<div class="modal-body">
										Apakah anda yakin akan mengubah status pembayaran transaksi dengan ID <?= $transaksi->id_header; ?>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<a href="/transaksi/updateStatusTransaksi/<?= $transaksi->id_header; ?>" type="button" class="btn btn-primary">Simpan</a>
									</div>
								</div>
							</div>
						</div>
					</td>
					<td>
						<?php if ($transaksi->status != 0) : ?>
							<button type="button" class="btn btn-warning ml-1" data-toggle="modal" data-target="#exampleModalResi<?= $transaksi->id_header; ?>">Resi</button>
						<?php endif; ?>
					</td>
					<td class="d-inline-flex">
						<button type="button" class="btn btn-secondary ml-1" data-toggle="modal" data-target="#exampleModalItem<?= $transaksi->id_header; ?>">
							Lihat Rincian Pembelian &raquo;
						</button>
						<!-- hanya transaksi yang sudah lunas yang dapat ditambah / dilihat resi dan download invoice -->
						<?php if ($transaksi->status != 0) {  ?>
							<a href=" <?= site_url('Transaksi/downloadInvoice/' . $transaksi->id_header) ?>" class="btn btn-primary" target="_blank">Download</a>
						<?php } else if (session()->get('role') == 0) { ?>
							<button type="button" class="btn btn-danger ml-1" data-toggle="modal" data-target="#exampleModalBatal<?= $transaksi->id_header; ?>">Batal</button>
						<?php } ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<div style="float:left">
	<?= $data['pager']->links('default', 'custom_pagination') ?>
</div>
<?= $this->endSection() ?>
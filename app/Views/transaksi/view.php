<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container">
	<div class="row">
		<div class="table-responsive ">
			<?php if ($head->status == 0) {
				$status = 'Belum lunas';
			} else if ($head->status == 1) {
				$status = 'Sudah Lunas';
			} else if ($head->status == 2) {
				$status = 'selesai';
			}
			?>
			<table class="table">
				<th style="width: 18%;">ID Transaksi
				<td style="width: 0%;">:</td>
				<td> <?= $head->id_header ?></td>
				</th>
				<tr>
					<td>Pembeli</td>
					<td>:</td>
					<td><?= $head->id_pembeli ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?= $head->alamat ?></td>
				</tr>
				<tr>
					<td>Ongkir</td>
					<td>:</td>
					<td><?= $head->ongkir ?></td>
				</tr>
				<tr>
					<td>Total </td>
					<td>:</td>
					<td><?= $head->total_harga; ?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td>:</td>
					<td><?= $status; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="mb-3">
		<table cellpadding="6" cellspacing="1" style="width:90%" class="table-bordered">
			<th colspan="2">Nama Barang</th>
			<th>Jumlah</th>
			<th>Sub Total</th>
			<?php foreach ($items as $index => $barang) : ?>
				<?php $b = $barangModel->find($barang->id_barang); ?>
				<tr>
					<td colspan="2">
						<?= ($b->nama); ?>
					</td>
					<td><?= $barang->jumlah; ?></td>
					<td class="text-right"><?= "Rp " . number_format($barang->sub_total, 2, ',', '.') ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
<?= $this->endSection() ?>
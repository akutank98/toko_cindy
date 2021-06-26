<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container">
	<div class="row">

		<div class="table-responsive ">
			<table class="table">
				<th style="width: 18%;">ID Transaksi
				<td style="width: 0%;">:</td>
				<td> <?= $transaksi->id_trans ?></td>
				</th>
				<tr>
					<td>Nama barang</td>
					<td>:</td>
					<td><?= $transaksi->nama ?></td>
				</tr>
				<tr>
					<td>Pembeli</td>
					<td>:</td>
					<td><?= $transaksi->username ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?= $transaksi->alamat ?></td>
				</tr>
				<tr>
					<td>Ongkir</td>
					<td>:</td>
					<td><?= $transaksi->ongkir ?></td>
				</tr>
				<tr>
					<td>Jumlah</td>
					<td>:</td>
					<td><?= $transaksi->jumlah ?></td>
				</tr>
				<tr>
					<td>Harga satuan</td>
					<td>:</td>
					<td><?= $transaksi->harga ?></td>
				</tr>
				<tr>
					<td>Total </td>
					<td>:</td>
					<td><?= $transaksi->total_harga ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
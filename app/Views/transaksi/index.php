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
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ($model as $index => $transaksi) : ?>
					<tr>
						<td><?= $transaksi->id_transaksi ?></td>
						<td><?= $transaksi->id_barang ?></td>
						<td><?= $transaksi->id_pembeli ?></td>
						<td><?= $transaksi->alamat ?></td>
						<td><?= $transaksi->jumlah ?></td>
						<td><?= $transaksi->total_harga ?></td>
						<td>
							<a href="<?= site_url('transaksi/view/' . $transaksi->id_transaksi) ?>" class="btn btn-primary">View</a>
							<a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi) ?>" class="btn btn-info">Invoice</a>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container">
	<div class="row">
		<?php $jam = date("G");
		if ($jam >= 0 && $jam <= 11)
			$sapa = "Selamat Pagi.";
		else if ($jam >= 12 && $jam <= 15)
			$sapa = "Selamat Siang.";
		else if ($jam >= 16 && $jam <= 18)
			$sapa = "Selamat Sore.";
		else if ($jam >= 19 && $jam <= 23)
			$sapa = "Selamat Malam.";
		?>
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
			<?php if ($transaksi->status != 2) { ?>
				<a href="https://api.whatsapp.com/send?phone=628155051048&text=<?= urlencode($sapa . ' Admin / Owner Toko Cindy') . '%0a' . urlencode('Konfirmasi pesanan dengan ID : ' . $transaksi->id_transaksi) . '%0a' . urlencode('Nama User :  ' . $transaksi->username) . '%0a' . urlencode('Tanggal transaksi : ' . date("d-m-Y", strtotime($transaksi->created_date))) . urlencode(' Total Pembelian : ' . date("d-m-Y", strtotime($transaksi->total_harga))); ?>" target="_blank" class="text-info">Klik Disini Untuk Melakukan Pembayaran</a>
			<?php } ?>
			<a href="<?= site_url('riwayat/index') ?>">Kembali ke Halaman Riwayat</a>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
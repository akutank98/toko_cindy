<html>

<head>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		td,
		th {
			border: 1px solid #000000;
			text-align: center;
		}
	</style>
</head>

<body>
	<div style="font-size:64px; color:'#dddddd' "><i>Invoice</i></div>
	<p>
		<i>Toko Cindy</i><br>
		Jawa Timur, Indonesia<br>
		+62 815-5051-048
	</p>
	<hr>
	<p></p>
	<p>
		Pembeli : <?= $head->username; ?><br>
		Alamat : <?= $head->alamat; ?><br>
		Transaksi No : <?= $head->id_header; ?><br>
		Tanggal : <?= date('Y-m-d', strtotime($head->created_date)) ?>
	</p>
	<table cellpadding="6">
		<tr>
			<th>Nama Barang</th>
			<th>Jumlah</th>
			<th>Sub Total</th>
		</tr>
		<?php foreach ($item as $index => $item) : ?>
			<tr>
				<td><?= $item->nama; ?></td>
				<td><?= $item->jumlah; ?></td>
				<td style="text-align: right;"><?= "Rp " . number_format($item->sub_total, 2, ',', '.') ?></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="2" style="text-align: right;">Ongkir</td>
			<td style="text-align: right;"><?= "Rp " . number_format($head->ongkir, 2, ',', '.') ?></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;">Total Pembayaran</td>
			<td style="text-align: right;"><?= "Rp " . number_format($head->total_harga, 2, ',', '.') ?></td>
		</tr>
	</table>
</body>

</html>
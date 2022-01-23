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
    <div style="font-size:64px; color:'#dddddd' "><i>Laporan Penjualan</i></div>
    <p>Bulan <?= $month; ?> Tahun <?= $year; ?></p>
    <?php $total = 0 ?>
    <hr>
    <table>
        <tr>
            <th style="width: 15%;">ID Barang</th>
            <th style="text-align: left;width: 50%;">Nama Barang</th>
            <th style="width: 15%;">Jumlah terjual</th>
            <th style="width: 20%;">Sub Total</th>
        </tr>
        <?php foreach ($item as $index => $transaksi) : ?>
            <tr>
                <td style="width: 15%;"><?= $transaksi->id_barang; ?></td>
                <td style="text-align: left;width: 50%;"><?= $transaksi->nama_barang; ?></td>
                <td style="width: 15%;"><?= $transaksi->jumlah; ?></td>
                <td style="text-align: right;width: 20%;"><?= "Rp " . number_format($transaksi->sub_total, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <br>

    <?php foreach ($head as $transaksi) : ?>
        <h3>Total Penjualan :<?= "Rp " . number_format($transaksi->total, 2, ',', '.') ?></h3>
    <?php endforeach ?>
    <?php foreach ($countTransaksi as $transaksi) : ?>
        <h3>Jumlah transaksi selesai : <?= $transaksi->jumlah; ?></h3>
    <?php endforeach ?>

</body>

</html>
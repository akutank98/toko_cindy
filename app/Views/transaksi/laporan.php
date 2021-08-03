<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <h1>Cetak Laporan</h1>
    </div>
    <form role="form" action="<?= site_url('Transaksi/rangeLaporan'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="row">
            <div class=" col-sm-6">
                <label for="date_timepicker_start">Mulai dari</label>
                <input name="date_timepicker_start" id="date_timepicker_start" class="form-control" type="text" autocomplete="off" required>
            </div>
            <div class="col-sm-6">
                <label for="date_timepicker_end">Sampai</label>
                <input name="date_timepicker_end" id="date_timepicker_end" class="form-control" type="text" autocomplete="off" required>
            </div>
            <div class="col-sm-2">
                <table>
                    <tr>&nbsp;</tr>
                    <tr>
                        <td>
                            <button type="submit" class="btn btn-info">Cari</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>

    <table class="table mt-2" style="width: 100%;" id="tabelLaporan">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>ID Barang</th>
                <th>Barang</th>
                <th>Pembeli</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transaksi)) { ?>
                <tr>
                    <td colspan="6" align="center">Data Tidak Ditemukan</td>
                </tr>
            <?php } else { ?>
                <?php $total = 0 ?>
                <?php foreach ($transaksi as $index => $transaksi) : ?>
                    <tr>
                        <td><?= $transaksi->id_transaksi; ?></td>
                        <td><?= $transaksi->id_barang; ?></td>
                        <td><?= $transaksi->nama; ?></td>
                        <td><?= $transaksi->id_pembeli; ?></td>
                        <td><?= $transaksi->jumlah; ?></td>
                        <td><?= $transaksi->created_date; ?></td>
                        <td style="text-align: right;"><?= "Rp " . number_format($transaksi->total_harga, 2, ',', '.') ?></td>
                        <?php $total += $transaksi->total_harga; ?>
                        <td></td>
                    </tr>
                <?php endforeach ?>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total penjualan</td>
                <td style="text-align: right;"><?= "Rp " . number_format($total, 2, ',', '.') ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?= form_open('Transaksi/cetakLaporan/'); ?>
    <input type="hidden" name="htmlreport" id="htmlreport">
    <input type="hidden" name="tgl" id="tgl">
    <?php if (!empty($transaksi)) { ?>
        <button type="submit" class="btn-info float-left">
            Cetak laporan
        </button>
    <?php } ?>
    <?= form_close(); ?>
</div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script'); ?>
<script>
    jQuery(function() {
        jQuery('#date_timepicker_start').datetimepicker({
            format: 'Y/m/d',
            onShow: function(ct) {
                this.setOptions({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'MM yy',
                    maxDate: jQuery('#date_timepicker_end').val() ? jQuery('#date_timepicker_end').val() : false
                })
            },
            timepicker: false
        });
        jQuery('#date_timepicker_end').datetimepicker({
            format: 'Y/m/d',
            onShow: function(ct) {
                this.setOptions({
                    minDate: jQuery('#date_timepicker_start').val() ? jQuery('#date_timepicker_start').val() : false
                })
            },
            timepicker: false
        });
    });


    var table = document.getElementById('tabelLaporan');
    var length = table.rows.length
    var html = '';
    var start = table.rows[1].cells[5].innerHTML.substring(0, 10);
    var end = table.rows[length - 2].cells[5].innerHTML.substring(0, 10);
    var k = (start + '_' + end);
    html += '<p>Laporan tanggal : ' + k + '</p>';

    html += '<hr><br><table cellpadding=' + '6' + '>';
    for (var r = 0, n = length; r < n; r++) {
        html += '<tr>';
        for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
            html += '<td>';
            html += (table.rows[r].cells[c].innerHTML);
            html += '</td>';
        }
        html += '</tr>';
    }
    html += '</table> ';

    $('#htmlreport').val(html);
    $('#tgl').val(k);
    console.log(html);
</script>
<?= $this->endSection(); ?>
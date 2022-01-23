<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Log</h1>
    <div class="container-fluid">
        <?= form_open('Log/logTanggal'); ?>
        <div class="row mt-2">
            <?= csrf_field(); ?>
            <select name="opt" id="opt">
                <option value="month">Bulanan</option>
                <option value="week">Mingguan</option>
                <option value="date">Harian</option>
            </select>
            <input type="hidden" name="rangewaktu">
            <div class="col-5">
                <input type="date" class="form-control" name="datepicker" id="datepicker">
            </div>
            <div class="col-2">
                <button class="btn btn-info" type="submit">Cari</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
    <table class="table">
        <thead>
            <th>ID Log</th>
            <th>Aksi</th>
            <th>Tabel</th>
            <th>ID Data</th>
            <th>Tanggal</th>
            <th>Aktor</th>
            <th>Keterangan</th>
        </thead>
        <tbody>
            <?php
            if ($data['log']) {
                $l = 0;
                foreach ($data['log'] as $index => $log) : ?>
                    <tr>
                        <td><?= $log->id_log ?></td>
                        <td><?= $log->action ?></td>
                        <td><?= $log->table_name ?></td>
                        <td><?= $log->id_modified ?></td>
                        <td><?= $log->change_date ?></td>
                        <td><?= $log->id_modifier ?></td>
                        <td><?php
                            $l += 1;
                            if ($log->keterangan == null) {
                                echo '';
                            } else echo $log->keterangan
                            ?></td>
                    </tr>
                <?php endforeach;
            } else { ?>
                <td colspan="7" class="text-center">Tidak Ada Data Log Ditemukan</td>
            <?php } ?>
        </tbody>
    </table>

    <div style="float:left">
        <?= $data['pager']->links('default', 'custom_pagination') ?>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script'); ?>
<script>
    document.getElementById("datepicker").type = 'month'
    $('#opt').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        document.getElementsByName("rangewaktu").value = valueSelected
        document.getElementById("datepicker").type = valueSelected
    });
</script>
<?= $this->endSection(); ?>
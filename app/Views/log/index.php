<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container"></div>
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
        <?php endforeach ?>
    </tbody>
</table>
</div>

<div style="float:left">
    <?= $data['pager']->links('default', 'custom_pagination') ?>
</div>

<?= $this->endSection() ?>
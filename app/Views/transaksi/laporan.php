<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <?php
    $session = session();
    $errors = $session->getFlashdata('errors_transaksi');
    if ($errors != null) : ?>
        <div class="alert alert-danger" id="d-error">
            <h4 class="alert-heading">Error </h4>
            <hr>
            <p class="mb-0">
                <?php foreach ($errors as $err) {
                    echo $err . '<br>';
                } ?>
            </p>
        </div>
    <?php endif ?>
    <div class="row">
        <h1>Cetak Laporan</h1>
    </div>
    <div class="row mt-2">
        <h4>Pilih Jarak Waktu </h4>
    </div>
    <?= form_open('Transaksi/cetakLaporan/'); ?>
    <div class="row mt-2">
        <select name="opt" id="opt">
            <option value="month">Bulanan</option>
            <option value="week">Mingguan</option>
            <option value="date">Harian</option>
        </select>
        <input type="hidden" name="rangewaktu">
        <div class="col-5">
            <input type="month" class="form-control" name="datepicker" id="datepicker">
        </div>
        <div class="col-2">
            <button class="btn btn-info" type="submit">Cetak Laporan</button>
        </div>
    </div>
    <?= form_close(); ?>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    setTimeout(function() {
        $('#d-error').fadeOut('slow');
    }, 3000);
</script>
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
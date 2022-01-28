<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <h3 class="text-center">Tautan untuk reset password telah dikirim ke email anda, <?= $user; ?> </h3>
        <h3>silahkan cek pesan masuk kemudian klik link yang tertera</h3>
        <h3>Apabila anda tidak menemukan tautan link, silahkan cek pada bagian spam</h3>
    </div>
</div>
<?= $this->endSection(); ?>
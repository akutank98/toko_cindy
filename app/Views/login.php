<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<style>
    body {
        background-color: #f1f1f1 !important;
    }

    .form-holder {
        margin-top: 30%;
        margin-bottom: 30%;
    }
</style>
<?php
$username = [
    'name' => 'username',
    'id' => 'username',
    'value' => null,
    'class' => 'form-control',
    'required' => 'required',
];

$password = [
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control',
    'required' => 'required',
];

$session = session();
$errors = $session->getFlashdata('errors');
$success = $session->getFlashdata('success');

?>



<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card form-holder">
                <div class="card-body">
                    <?php if ($success != null) : ?>
                        <div class="alert alert-success" id="d-success">
                            <h4 class="alert-heading"><?= $success; ?> </h4>
                            <hr>
                        </div>
                    <?php endif ?>
                    <h1>Login</h1>
                    <?php if ($errors != null) : ?>
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
                    <?= form_open('Auth/login'); ?>
                    <div class="form-group">
                        <?= form_label("Username", "username"); ?>
                        <?= form_input($username); ?>
                    </div>
                    <div class="form-group">
                        <?= form_label("Password", "password"); ?>
                        <?= form_password($password); ?>
                    </div>
                    <div>Belum punya akun?
                        <a href="<?= site_url('Auth/register') ?>"> Daftar</a> <br>
                        <a href="<?= site_url('Auth/lupaPassword') ?>"> Lupa Password?</a>
                    </div>
                    <div class="text-right">
                        <?= form_submit('submit', 'Submit', ['class' => 'btn btn-primary']); ?>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script'); ?>
<script>
    setTimeout(function() {
        $('#d-error').fadeOut('slow');
    }, 3000);
    setTimeout(function() {
        $('#d-success').fadeOut('slow');
    }, 3000);
</script>
<?= $this->endSection(); ?>
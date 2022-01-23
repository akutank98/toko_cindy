<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background-color: #f1f1f1 !important;
    }

    .form-holder {
        margin-top: 20%;
        margin-bottom: 20%;
    }
</style>

<?php
$password = [
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control',
    'required' => 'required',
    'minlength' => 5,
];
$repeatPassword = [
    'name' => 'repeatPassword',
    'id' => 'repeatPassword',
    'class' => 'form-control',
    'required' => 'required',
];
$session = session();
$error = $session->getFlashData('error_reset');

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card form-holder">
                <div class="card-body">
                    <h1>Masukkan Password Baru</h1>
                    <?php if ($error != null) : ?>
                        <div class="alert alert-danger" id="r-error">
                            <h4 class="alert-heading">Error </h4>
                            <hr>
                            <p class="mb-0">
                                <?php foreach ($error as $err) {
                                    echo $err . '<br>';
                                } ?>
                            </p>
                        </div>
                    <?php endif ?>
                    <?= form_open('Auth/changePassword'); ?>
                    <div class="form-group">
                        <?= form_label("Password", "password"); ?>
                        <?= form_password($password); ?>
                    </div>
                    <div class="form-group">
                        <?= form_label("Repeat Password", "repeatPassword"); ?>
                        <?= form_password($repeatPassword); ?>
                    </div>
                    <div class="text-right">
                        <?= form_submit('submit', 'Submit', ['class' => 'btn btn-primary']); ?>
                    </div>
                    <input type="hidden" name="tokenPar" value="<?= $tokenPar; ?>">
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    setTimeout(function() {
        $('#r-error').fadeOut('slow');
    }, 3000);
</script>
<?= $this->endSection(); ?>
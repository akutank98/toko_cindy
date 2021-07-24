<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$username = [
    'name' => 'username',
    'id' => 'username',
    'value' => null,
    'class' => 'form-control'
];
$password = [
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control'
];
$repeatPassword = [
    'name' => 'repeatPassword',
    'id' => 'repeatPassword',
    'class' => 'form-control'
];
$session = session();
$error = $session->getFlashData('errors_register');

?>
<h1>Register Form</h1>
<?php if ($error != null) : ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading">Error </h4>
        <hr>
        <p class="mb-0">
            <?php foreach ($error as $err) {
                echo $err . '<br>';
            } ?>
        </p>
    </div>
<?php endif ?>
<?= form_open('Auth/register'); ?>
<div class="form-group">
    <?= form_label("Username", "username"); ?>
    <?= form_input($username); ?>
</div>
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
<?= form_close(); ?>
<?= $this->endSection(); ?>
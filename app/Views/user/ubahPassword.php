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
$old_password = [
    'name' => 'old_password',
    'id' => 'old_password',
    'value' => null,
    'class' => 'form-control',
    'required' => 'required',
    'onkeyup' => 'check()',
];
$newPassword = [
    'name' => 'newPassword',
    'id' => 'newPassword',
    'class' => 'form-control',
    'required' => 'required',
    'onkeyup' => 'check()',
    'minlength' => 5,
];
$repeatNewPassword = [
    'name' => 'repeatNewPassword',
    'id' => 'repeatNewPassword',
    'class' => 'form-control',
    'required' => 'required',
    'onkeyup' => 'check()'
];
$session = session();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card form-holder">
                <div class="card-body">
                    <h1>Ubah Password</h1>
                    <?= form_open('User/ubahPassword'); ?>
                    <div class="form-group">
                        <?= form_label("Password lama", "old_password"); ?>
                        <?= form_password($old_password); ?>
                    </div>
                    <div class="form-group">
                        <?= form_label("Password baru", "password"); ?>
                        <?= form_password($newPassword); ?>
                    </div>
                    <div class="form-group">
                        <?= form_label("Repeat Password", "repeatPassword"); ?>
                        <?= form_password($repeatNewPassword); ?>
                    </div>
                    <span id='message'></span>
                    <div class="text-right">
                        <?= form_submit('submit', 'Submit', ['class' => 'btn btn-primary', 'disabled' => true, 'id' => 'submit']); ?>
                    </div>
                    <?= form_close(); ?>
                    </form>
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

    var check = function() {
        if (document.getElementById('newPassword').value == document.getElementById('old_password').value) {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Password baru tidak boleh sama';
            document.getElementById("submit").disabled = true;
        } else if (document.getElementById('newPassword').value == document.getElementById('repeatNewPassword').value && document.getElementById('repeatNewPassword').value != '') {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'Cocok';
            document.getElementById("submit").disabled = false;
        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Ulang password tidak cocok';
            document.getElementById("submit").disabled = true;
        }


    }
</script>
<?= $this->endSection(); ?>
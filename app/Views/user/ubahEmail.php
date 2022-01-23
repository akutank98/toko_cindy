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
$session = session();
$error = $session->getFlashData('error');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card form-holder">
                <div class="card-body">
                    <h1>Ubah Email</h1>
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" id="cartmsg" role="alert">
                            <?php foreach (session()->getFlashdata('pesan') as $msg) : ?>
                                <?php echo $msg ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
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
                    <?= form_open('User/ubahEmail'); ?>
                    <div class="form-group">
                        <label for="username">Username </label>
                        <input type="text" name="username" disabled value="<?= $session->get('username'); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="emailOld">Email lama</label>
                        <input type="email" id="emailOld" name="emailOld" class="form-control" value="<?= $user->email; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Baru</label>
                        <input type="email" id="email" name="email" class="form-control" onkeypress="check()">
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
        if (document.getElementById('email').value == document.getElementById('emailOld').value) {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Email baru tidak boleh sama';
            document.getElementById("submit").disabled = true;
        } else if (document.getElementById('email').value == '') {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Email baru tidak boleh kosong';
            document.getElementById("submit").disabled = false;
        } else {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = '';
            document.getElementById("submit").disabled = false;
        }
    }
</script>
<?= $this->endSection(); ?>
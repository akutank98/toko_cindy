<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url('icon.png'); ?>">

    <title>Toko Cindy</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">
    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('bootstrap-4.0.0/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- datetime -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('build/jquery.datetimepicker.min.css'); ?>" />
    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 5rem;
            padding-bottom: 20vh;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <?= $this->include('navbar'); ?>

    <main role="main" class="container" style="height: 90vh;">
        <?= $this->renderSection('content'); ?>
    </main><!-- /.container -->
    <?php


    if (session()->get('role') == 2) : ?>
        <?= $this->include('footer'); ?>
    <?php endif ?>

    <script src="<?= base_url('jquery-3.5.1.min.js'); ?>"></script>
    <script src="<?= base_url('bootstrap-4.0.0/dist/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('build/jquery.datetimepicker.full.min.js'); ?>"></script>
    <?= $this->renderSection('script') ?>

</body>

</html>
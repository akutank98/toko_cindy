<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<p class="h4 ml-auto" style="color: palevioletred;">
	Selamat datang, <?php echo session()->get('username'); ?>
</p>
<?= $this->endSection() ?>
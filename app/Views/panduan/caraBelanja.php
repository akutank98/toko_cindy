<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    a:hover {
        text-decoration: none;
    }
</style>
<div class="container" style="padding-bottom: 15%;">
    <!--Accordion wrapper-->
    <div class=" accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
        <!-- Accordion card -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header" role="tab" id="headingOne1">
                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                    <h5 class="mb-0">
                        Langkah pertama : Cari barang <i class="fas fa-angle-down rotate-icon"></i>
                    </h5>
                </a>
            </div>
            <!-- Card body -->
            <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                <div class="card-body">
                    <p>Masuk ke halaman etalase barang untuk mulai melihat barang yang anda inginkan</p>
                    <img src="<?= base_url('step_belanja/etalase.png') ?>" alt="Etalase">
                </div>
            </div>
        </div>
        <!-- Accordion card -->
        <!-- Accordion card -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header" role="tab" id="headingTwo2">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                    <h5 class="mb-0">
                        Langkah kedua : Lanjutkan ke pembelian<i class="fas fa-angle-down rotate-icon"></i>
                    </h5>
                </a>
            </div>
            <!-- Card body -->
            <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                <div class="card-body">
                    <p>Pilih barang yang diinginkan , kemudian menekan tombol beli untuk memproses pembelian </p>
                    <img src="<?= base_url('step_belanja/beli.png') ?>" style="max-width: 100%;" alt="Etalase">
                </div>
            </div>
        </div>
        <!-- Accordion card -->
        <!-- Accordion card -->
        <div class="card">
            <!-- Card header -->
            <div class="card-header" role="tab" id="headingThree3">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                    <h5 class="mb-0">
                        Collapsible Group Item #3 <i class="fas fa-angle-down rotate-icon"></i>
                    </h5>
                </a>
            </div>
            <!-- Card body -->
            <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3" data-parent="#accordionEx">
                <div class="card-body">
                </div>
            </div>
        </div>
        <!-- Accordion card -->
    </div>
</div>
<!-- Accordion wrapper -->
<?= $this->endSection() ?>
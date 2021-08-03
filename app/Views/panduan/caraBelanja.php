<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    a:hover {
        text-decoration: none;
    }
</style>
<div class="container" style="padding-bottom: 15vh;">
    <div class="text-left">
        <h2 class="mt-3">Langkah pertama : </h2>
        <p class>Masuk ke halaman etalase barang untuk mulai melihat barang yang anda inginkan</p>
        <p class="mt-3">Apabila anda sudah mengetahui nama produk yang anda inginkan , anda dapat mencari barang pada etalase melalui kolom pencarian</p>
        <div style="max-width: 100%;">
            <img src="<?= base_url('step_belanja/cariBarang.png') ?>" style="max-width: 1000px; height: auto;" alt="Cari Barang">
        </div>
        <h2 class="mt-3">Langkah kedua : </h2>
        <br> Lanjutkan ke pembelian apabila anda sudah menemukan barang yang ingin anda beli
        <p>Pilih barang yang diinginkan , kemudian menekan tombol beli untuk memproses pembelian </p>
        <div style="max-width: 100%;">
            <img src="<?= base_url('step_belanja/beli.png') ?>" style="max-width: 1000px; height: auto;" alt="Etalase">
        </div>
        <h2 class="mt-3">Langkah ketiga : </h2>
        <br>
        <p>Masukkan alamat lengkap anda serta masukkan jumlah barang yang ingin anda beli
            Pilih barang yang diinginkan , kemudian menekan tombol beli untuk memproses pembelian </p>
        <div style="max-width: 100%;">
            <img src="<?= base_url('step_belanja/pembelian.png') ?>" style="max-width: 1000px; height: auto;" alt="Beli">
        </div>
        <h2 class="mt-3">Langkah keempat : </h2>
        <br>
        <p>Lakukan konfirmasi pembayaran dengan klik link yang tersedia </p>
        <p>Mintalah nomor rekening Toko Cindy melalui whatsapp untuk pembayaran</p>
        <p>Setelah selesai melakukan pembayaran lampirkan bukti pembayaran melalui whatsapp</p>

        <div style="max-width: 100%;">
            <img src="<?= base_url('step_belanja/kirim.png') ?>" style="max-width: 1000px; height: auto;" alt="Bukti">
        </div>
        <h4 class="mt-3 text-success"><strong>Jangan lupa untuk meminta invoice apabila pembayaran telah divalidasi !</strong></h4>
    </div>
</div>
<?= $this->endSection() ?>
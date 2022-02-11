<?php
$session = session();
?>
<style>
    .buttonLogout {
        transition: all .5s ease;
        color: #fff;
        border: 3px solid white;
        text-transform: uppercase;
        text-align: center;
        line-height: 1;
        font-size: .75em;
        background-color: transparent;
        padding: 8px;
        outline: none;
        border-radius: 4px;
    }

    .buttonLogout:hover {
        color: #001F3F;
        background-color: transparent;
    }
</style>

<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: palevioletred;">
    <button class="navbar-brand btn-outline-light disabled" style="box-shadow: none;background-color: transparent;text-decoration-color: white; border:none">Toko Cindy</button>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <?php if ($session->get('isLoggedIn')) : ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= site_url('home/index') ?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <!-- owner -->
                <?php if (session()->get('role') == 0) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Barang</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="<?= site_url('Barang/index') ?>">List Barang</a>
                            <a class="dropdown-item" href="<?= site_url('Barang/barangKosong') ?>">Barang Stok Kosong</a>
                            <a class="dropdown-item" href="<?= site_url('Barang/create') ?>">Tambah Barang</a>
                            <a class="dropdown-item" href="<?= site_url('Barang/tambahKategori') ?>">Tambah Kategori</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown02">
                            <a class="dropdown-item" href="<?= site_url('Transaksi/index') ?>">Semua Transaksi</a>
                            <a class="dropdown-item" href="<?= site_url('Transaksi/sudahLunas') ?>">Sudah Lunas</a>
                            <a class="dropdown-item" href="<?= site_url('Transaksi/belumLunas') ?>">Belum Lunas</a>
                            <a class="dropdown-item" href="<?= site_url('Transaksi/laporan') ?>">Laporan Penjualan</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('User/index') ?>">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('Log/index') ?>">Log</a>
                    </li>
                    <!-- admin -->
                <?php elseif (session()->get('role') == 1) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Barang</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="<?= site_url('Barang/index') ?>">List Barang</a>
                            <a class="dropdown-item" href="<?= site_url('Barang/barangKosong') ?>">Barang Stok Kosong</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown02">
                            <a class="dropdown-item" href="<?= site_url('Transaksi/index') ?>">Semua Transaksi</a>
                            <a class="dropdown-item" href="<?= site_url('Transaksi/sudahLunas') ?>">Sudah Lunas</a>
                            <a class="dropdown-item" href="<?= site_url('Transaksi/belumLunas') ?>">Belum Lunas</a>
                        </div>
                    </li>
                    <!-- user -->
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('Etalase/index') ?>">Etalase</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('Riwayat/index') ?>">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('Auth/caraBelanja') ?>">Panduan Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('ShoppingCart/index') ?>">&#128722;</a>
                    </li>
                <?php endif ?>
            </ul>
        <?php else : ?>
            <div class="text-light" style="color:#fff; margin-left: 30vw;">
                Anda harus login terlebih dahulu sebelum dapat mengakses Website <a href="<?= site_url('Auth/login') ?>" class="text-decoration-none"><u>Login</u></a>
            </div>
        <?php endif; ?>
        <div class="form-inline my-2 my-lg-0 ml-auto">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($session->get('isLoggedIn')) : ?>
                    <div class="row g-2 mr-1 ml-1">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>Halo, <?= session()->get('username'); ?></strong></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown02">
                                <?php if (session()->get('role') == 2) : ?>
                                    <a class="dropdown-item" href="<?= site_url('User/alamat') ?>">Alamat Tersimpan</a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?= site_url('User/ubahPassword') ?>">Ubah Password</a>
                                <a class="dropdown-item" href="<?= site_url('User/ubahEmail') ?>">Ubah Email</a>
                                <a class="dropdown-item" href="<?= site_url('Auth/logout') ?>">Logout</a>
                            </div>
                        </li>
                    </div>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
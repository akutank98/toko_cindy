<?php
$session = session();
?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: palevioletred;">
    <a class="navbar-brand" href="<?= site_url('home/index') ?>">Toko Cindy</a>
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
                            <a class="dropdown-item" href="<?= site_url('barang/index') ?>">List Barang</a>
                            <a class="dropdown-item" href="<?= site_url('barang/barangKosong') ?>">Barang Stok Kosong</a>
                            <a class="dropdown-item" href="<?= site_url('barang/create') ?>">Tambah Barang</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown02">
                            <a class="dropdown-item" href="<?= site_url('transaksi/index') ?>">Semua Transaksi</a>
                            <a class="dropdown-item" href="<?= site_url('transaksi/belumLunas') ?>">Belum Lunas</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('user/index') ?>">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('log/index') ?>">Log</a>
                    </li>
                    <!-- admin -->
                <?php elseif (session()->get('role') == 1) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Barang</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="<?= site_url('barang/index') ?>">List Barang</a>
                            <a class="dropdown-item" href="<?= site_url('barang/barangKosong') ?>">Barang Stok Kosong</a>
                            <a class="dropdown-item" href="<?= site_url('barang/create') ?>">Tambah Barang</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown02">
                            <a class="dropdown-item" href="<?= site_url('transaksi/index') ?>">Semua Transaksi</a>
                            <a class="dropdown-item" href="<?= site_url('transaksi/belumLunas') ?>">Belum Lunas</a>
                        </div>
                    </li>
                    <!-- user -->
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('etalase/index') ?>">Etalase</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('riwayat/index') ?>">Riwayat</a>
                    </li>
                <?php endif ?>
            </ul>
        <?php endif; ?>
        <div class="form-inline my-2 my-lg-0 ml-auto">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($session->get('isLoggedIn')) : ?>
                    <li class="nav-item">
                        <a class="btn btn-success" href="<?= site_url('auth/logout') ?>">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item" style="margin:0 1px 1px 1px">
                        <a class="btn btn-success" href="<?= site_url('auth/login') ?>">Login</a>
                    </li>
                    <li class="nav-item" style="margin:0 1px 1px 1px">
                        <a class="btn btn-success" href="<?= site_url('auth/register') ?>">Daftar</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
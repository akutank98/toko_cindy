<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1>Kategori</h1>
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Kategori Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-check-inline">
                        <?= form_open('Barang/tambahKategori'); ?>
                        <div class="form-group">
                            <label for="nama">Masukkan nama kategori</label>
                            <input type="text" class="form-control" name="nama" required minlength="3" placeholder="Nama kategori">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" style="background-color: palevioletred">Simpan</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#exampleModalLong" style="background-color: palevioletred">
        Tambah Kategori Baru
    </button>
    <table class="table mt-3">
        <tr>
            <th>ID Kategori</th>
            <th>Nama Kategori</th>
            <th></th>
        </tr>
        <?php if ($kategori) : ?>
            <?php foreach ($kategori as $k) : ?>
                <tr>
                    <td><?= $k->id_kategori ?></td>
                    <td><?= $k->nama_kategori; ?></td>
                    <td>
                        <a href="<?= site_url('User/hapusKategori/' . $k->id_kategori) ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>
<?= $this->endSection(); ?>
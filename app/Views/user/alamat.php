<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1>Alamat Tersimpan</h1>
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Masukkan Alamat Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-check-inline">
                        <?= form_open('User/alamat'); ?>
                        <div class="form-group">
                            <label for="label">Masukkan label alamat</label>
                            <input type="text" class="form-control" name="label">
                        </div>
                        <div class="form-group">
                            <label for=" provinsi">Pilih Provinsi</label>
                            <select class="form-control" id="provinsi" name="provinsi" id="provinsi">
                                <option value="">Select Provinsi</option>
                                <?php foreach ($provinsi as $p) : ?>
                                    <option value="<?= $p->province_id ?>"><?= $p->province ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kabupaten">Pilih Kabupaten/Kota</label>
                            <select class="form-control" id="kabupaten" name="kabupaten">
                                <option value="">Pilih Kabupaten/kota</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Masukkan alamat lengkap</label>
                            <input type="text" class="form-control" name="alamat">
                        </div>
                        <input type="hidden" name="provinsi" id="hProv">
                        <input type="hidden" name="kabupaten" id="hKab">
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
    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#exampleModalLong" style="background-color: palevioletred">
        Tambah Alamat Baru
    </button>
    <table class="table mt-3">
        <tr>
            <th>Label alamat</th>
            <th>Alamat Lengkap</th>
            <th></th>
        </tr>
        <?php if ($alamat) : ?>
            <?php foreach ($alamat as $alamat) : ?>
                <tr>
                    <td><?= $alamat->label ?></td>
                    <td><?= $alamat->alamat . ', ' . $alamat->city_name . ', Provinsi ' . $alamat->province_name; ?></td>
                    <td>
                        <a href="<?= site_url('User/hapusAlamat/' . $alamat->id_alamat) ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $('document').ready(function() {
        $("#provinsi").on('change', function() {
            $("#kabupaten").empty();
            $("#service").empty();
            $("#service").append($('<option>', {
                value: '',
                text: 'Select service'
            }));
            var id_province = $(this).val();
            $.ajax({
                url: "<?= site_url('ShoppingCart/getcity') ?>",
                type: 'GET',
                data: {
                    'id_province': id_province,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var results = data["rajaongkir"]["results"];
                    for (var i = 0; i < results.length; i++) {
                        $("#kabupaten").append($('<option>', {
                            value: results[i]["city_id"],
                            text: results[i]['city_name']
                        }));
                    }
                },
            });
            var selectedTextP = $(this).find("option:selected").val();
            $("#hProv").val(selectedTextP);
        });

        $("#kabupaten").on('change', function() {
            var id_city = $(this).val();
            $("#service").empty();
            $("#service").append($('<option>', {
                value: '',
                text: 'Select service'
            }));
            var selectedTextK = $(this).find("option:selected").val();
            $("#hKab").val(selectedTextK);
        });
    });
</script>
<?= $this->endSection(); ?>
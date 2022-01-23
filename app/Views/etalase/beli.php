<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<?php
$id_barang = [
    'name' => 'id_barang',
    'id' => 'id_barang',
    'value' => $model->id_barang,
    'type' => 'hidden'
];

$id_pembeli = [
    'name' => 'id_pembeli',
    'id' => 'id_pembeli',
    'value' => session()->get('id'),
    'type' => 'hidden'
];
$jumlah = [
    'name' => 'jumlah',
    'id' => 'jumlah',
    'value' => 1,
    'min' => 1,
    'class' => 'form-control',
    'type' => 'number',
    'max' => $model->stok,
];
$total_harga = [
    'name' => 'total_harga',
    'id' => 'total_harga',
    'value' => null,
    'class' => 'form-control',
    'readonly' => true,
];
$ongkir = [
    'name' => 'ongkir',
    'id' => 'ongkir',
    'value' => null,
    'class' => 'form-control',
    'readonly' => true,
];
$alamat = [
    'name' => 'alamat',
    'id' => 'alamat',
    'class' => 'form-control',
    'value' => null,
    'required' => true
];

$submit = [
    'name' => 'submit',
    'id' => 'submit',
    'type' => 'submit',
    'value' => 'Beli sekarang',
    'class' => 'btn btn-dark',
    'style' => 'background-color: palevioletred'
];
?>

<div class="container" style="padding-bottom: 15vh;">
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" id="cartmsg" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" src="<?= base_url('uploads/' . $model->gambar) ?>" />
                    <h1 style="font-size: 2.2rem;" class="text-success"><?= $model->nama ?></h1>
                    <h4 style="font-size: 1.1rem;"> Harga : <?= "Rp " . number_format($model->harga, 2, ',', '.'); ?></h4>
                    <h4 style="font-size: 1.1rem;"> Stok : <?= $model->stok ?></h4>
                    <?php if ($model->ukuran == null && $model->berat == null) : ?>
                        <div class="text-body" style="font-size:1.1rem;">Berat : 500 gram</div>
                        <div class="text-body" style="font-size:1.1rem;">Ukuran : - </div>
                        <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                        <p class="text-body" style="font-size:1.1rem;">Tidak ada deskripsi</p>
                        <?php dd('null'); ?>
                        <!-- jika sudah ada deskripsi -->
                    <?php else : ?>
                        <div class="text-body" style="font-size:1.1rem;">Berat : <?= $model->berat ?>gram</div>
                        <div class="text-body" style="font-size:1.1rem;">Ukuran : <?= $model->ukuran ?></div>
                        <div class="text-body" style="font-size:1.1rem;">Deskripsi : </div>
                        <div class="form-group">
                            <textarea style="resize: none;" readonly class="form-control" rows="<?= substr_count($model->deskripsi, "\n") + 1; ?>" id="exampleFormControlTextarea1" style="font-size:1.1rem;"><?= $model->deskripsi ?></textarea>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="col-6">
            <h4>Pengiriman</h4>
            <?php $attributes = ['id' => 'myForm'];
            ?>
            <?= form_open('Etalase/single', $attributes) ?>
            <div class="form-group">
                <label for="provinsi">Pilih Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi" id="provinsi" required>
                    <option value="">Select Provinsi</option>
                    <?php foreach ($provinsi as $p) : ?>
                        <option value="<?= $p->province_id ?>"><?= $p->province ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="kabupaten">Pilih Kabupaten/Kota</label>
                <select class="form-control" id="kabupaten" name="kabupaten" required>
                    <option value="">Pilih Kabupaten/kota</option>
                </select>
            </div>
            <div class="form-group">
                <label for="service">Pilih Service</label>
                <select class="form-control" id="service" required>
                    <option value="">Select Service</option>
                </select>
            </div>
            <?= form_input($id_barang) ?>
            <?= form_input($id_pembeli) ?>
            <div class="form-group">
                <?= form_label('Jumlah Pembelian', 'jumlah') ?>
                <?= form_input($jumlah) ?>
            </div>
            <div class="form-group">
                <strong>Estimasi : <span id="estimasi"></span></strong>
                <hr>
            </div>
            <div class="form-group">
                <?= form_label('Ongkir', 'ongkir') ?>
                <?= form_input($ongkir) ?>
            </div>
            <div class="form-group">
                <?= form_label('Total Harga', 'total_harga') ?>
                <?= form_input($total_harga) ?>
            </div>
            <div class="form-group">
                <?= form_label('Alamat', 'alamat') ?>
                <?= form_input($alamat) ?>
            </div>
            <div class="text-right">
                <a href="<?= site_url('Etalase/addCart/' . $model->id_barang) ?>" class="btn btn-success">Tambahkan ke keranjang &#x1F6D2;</a>
                <?= form_submit($submit) ?>
            </div>
            <input type="hidden" name="Hongkir" id="Hongkir" value="<?php if ($model->berat == null) echo '500';
                                                                    else echo $model->berat; ?>">
            <input type="hidden" name="provinsi" id="hProv">
            <input type="hidden" name="kabupaten" id="hKab">
            <input type="hidden" name="service" id="hService">
            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('document').ready(function() {
        var jumlah_pembelian = $("#jumlah").val();
        var berat = $('#Hongkir').val();
        var harga = <?= $model->harga ?>;
        var Hongkir = berat;
        console.log(Hongkir);

        $("#provinsi").on('change', function() {
            $("#kabupaten").empty();
            $("#service").empty();
            $("#service").append($('<option>', {
                text: 'Select service',
                value: '',
            }));
            var id_province = $(this).val();
            $.ajax({
                url: "<?= site_url('etalase/getcity') ?>",
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
            var selectedTextP = $(this).find("option:selected").text();
            $("#hProv").val(selectedTextP);
        });

        $("#kabupaten").on('change', function() {
            var id_city = $(this).val();
            $("#service").empty();
            $("#service").append($('<option>', {
                text: 'Select service',
                value: ''
            }));
            $.ajax({
                url: "<?= site_url('etalase/getcost') ?>",
                type: 'GET',
                data: {
                    'origin': 492, //Tulungagung
                    'destination': id_city,
                    'weight': Hongkir,
                    'courier': 'jne'
                },
                dataType: 'json',
                success: function(data) {
                    var results = data["rajaongkir"]["results"][0]["costs"];

                    for (var i = 0; i < results.length; i++) {
                        var text = results[i]["description"] + "(" + results[i]["service"] + ")";
                        $("#service").append($('<option>', {
                            value: results[i]["cost"][0]["value"],
                            text: text,
                            etd: results[i]["cost"][0]["etd"]
                        }));
                    }
                },
            });
            var selectedTextK = $(this).find("option:selected").text();
            $("#hKab").val(selectedTextK);
        });

        $("#service").on('change', function() {
            var estimasi = $('option:selected', this).attr('etd');

            ongkir = parseInt($(this).val());
            $("#ongkir").val(ongkir);
            $("#estimasi").html(estimasi + " Hari");
            var total_harga = (jumlah_pembelian * harga) + ongkir;
            $("#total_harga").val(total_harga);
            var selectedTextS = $(this).find("option:selected").text();
            $("#hService").val(selectedTextS);
        });

        $("#jumlah").on("change", function() {
            var max = <?= $model->stok ?>;
            var min = 1;
            if ($(this).val() > max) {
                $(this).val(max);
            } else if ($(this).val() < min) {
                $(this).val(min);
            }
            Hongkir = berat;
            Hongkir *= $("#jumlah").val();
            $("ongkir").val(ongkir);
            jumlah_pembelian = $("#jumlah").val();
            var id_city = $("#kabupaten").find("option:selected").val();
            var service = $("#service").prop('selectedIndex') - 1;
            console.log([id_city, ' ', service]);
            $.ajax({
                url: "<?= site_url('etalase/getcost') ?>",
                type: 'GET',
                data: {
                    'origin': 492, //Tulungagung
                    'destination': id_city,
                    'weight': Hongkir,
                    'courier': 'jne'
                },
                dataType: 'json',
                success: function(data) {
                    var results = data["rajaongkir"]["results"][0]["costs"][service]["cost"][0]["value"];
                    console.log(results);
                    $("#ongkir").val(results);
                    ongkir = results
                },
            });

            var total_harga = (jumlah_pembelian * harga) + ongkir;
            $("#total_harga").val(total_harga);
        });
    });
</script>
<script>
    setTimeout(function() {
        $('#cartmsg').fadeOut('slow');
    }, 2400);
</script>
<?= $this->endSection(); ?>
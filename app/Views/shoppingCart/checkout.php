<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <h1 class="mb-3">Rincian Pembelian</h1>
    </div>
    <div class="row">
        <table cellpadding="6" cellspacing="1" style="width:90%" class="table-bordered">
            <th colspan="2">Nama Barang</th>
            <th>Jumlah</th>
            <th>Sub Total</th>
            <?php $total_berat = 0; ?>
            <?php foreach ($cart->contents() as $index => $items) : ?>
                <tr>
                    <td colspan="2">
                        <?= $items['name']; ?>
                    </td>
                    <td><?= $items['qty']; ?></td>
                    <?php $total_berat += ($items['options']['berat'] * $items['qty']); ?>
                    <td class="text-right"><?= "Rp " . number_format($items['price'] * $items['qty'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <td colspan="3" class="text-right">Total Pembayaran</td>
            <td style="text-align: right;"> <?= "Rp " . number_format($cart->total(), 2, ',', '.') ?></td>
        </table>
    </div>
    <?= form_open('ShoppingCart/beli'); ?>
    <div class="col-9">
        <?php
        if ($alamat == null) : ?>
            <div class="form-group mt-2">
                <div class="alert alert-danger" role="alert">
                    Anda belum memiliki alamat pengiriman, silahkan tambahkan alamat pengiriman terlebih dahulu dengan <a href="<?= site_url('User/alamat') ?>">Klik disini</a> atau dapat mengisi alamat secara manual.
                </div>
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
        <?php else : ?>
            <div class="form-group">
                <label for="alamat">Alamat Tersimpan</label>
                <select class="form-control" name="alamat" id="alamat">
                    <option value="">Pilih Alamat</option>
                    <?php
                    foreach ($alamat as $a) : ?>
                        <?php if ($a->kabupaten != '') : ?>
                            <option value="<?= $a->kabupaten; ?>"><?= $a->label . ' ( ' . $a->alamat . ', ' . $a->city_name . ', Provinsi ' . $a->province_name . ' )'; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <div class="form-group">
                <label for="service">Pilih Layanan Pengiriman (JNE) </label>
                <select class="form-control" id="service" required>
                    <option value="">Pilih Layanan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ongkir">Ongkir</label>
                <input type="text" name="ongkirL" value="" id="ongkirL" class="form-control" readonly />
                <input type="hidden" name="ongkir">
            </div>
            <div class="form-group">
                <label for="total_hargaL">Total Harga</label>
                <input type="text" name="total_hargaL" value="" id="total_hargaL" class="form-control" readonly />
                <input type="hidden" name="total_harga">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label> <input type="text" name="alamat" value="" id="alamat" class="form-control" required />
            </div>
            <input type="hidden" name="provinsi" id="hProv">
            <input type="hidden" name="kabupaten" id="hKab">
            <input type="hidden" name="service" id="hService">
            <div class="text-left">
                <input type="submit" name="submit" value="Beli" id="submit" class="btn btn-dark" style="background-color: palevioletred" />
            </div>
            <?= form_close(); ?>
            </div>
    </div>
    <?= $this->endSection() ?>



    <?= $this->section('script'); ?>
    <script>
        $('document').ready(function() {
            $("#provinsi").on('change', function() {
                $("#kabupaten").empty();
                $("#service").empty();
                document.getElementById("ongkirL").value = "";
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
                var selectedTextP = $(this).find("option:selected").text();
                $("#hProv").val(selectedTextP);
            });

            $("#kabupaten").on('change', function() {
                var id_city = $(this).val();
                $("#service").empty();
                document.getElementById("ongkirL").value = "";
                $("#service").append($('<option>', {
                    value: '',
                    text: 'Select service'
                }));
                $.ajax({
                    url: "<?= site_url('ShoppingCart/getcost') ?>",
                    type: 'GET',
                    data: {
                        'origin': 492, //Tulungagung
                        'destination': id_city,
                        'weight': <?= $total_weight; ?>,
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
            $("#alamat").on('change', function() {
                var id_city = $(this).val();
                $("#service").empty();
                document.getElementById("ongkirL").value = "";
                $("#service").append($('<option>', {
                    value: '',
                    text: 'Select service'
                }));
                $.ajax({
                    url: "<?= site_url('ShoppingCart/getcost') ?>",
                    type: 'GET',
                    data: {
                        'origin': 492, //Tulungagung
                        'destination': id_city,
                        'weight': <?= $total_weight; ?>,
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
            });
            $("#service").on('change', function() {
                var estimasi = $('option:selected', this).attr('etd');

                ongkir = parseInt($(this).val());
                $("#ongkir").val(ongkir);
                $("#ongkirL").val(Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(ongkir));
                $("#estimasi").html(estimasi + " Hari");
                var total_harga = <?= $cart->total(); ?> + ongkir;
                $("#total_harga").val(total_harga);
                $("#total_hargaL").val(Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(total_harga));
                var selectedTextS = $(this).find("option:selected").text();
                $("#hService").val(selectedTextS);
            });
        });
    </script>
    <?= $this->endSection(); ?>
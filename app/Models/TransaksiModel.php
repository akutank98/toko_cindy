<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = [
        'id_barang', 'id_pembeli', 'jumlah', 'total_harga', 'alamat', 'ongkir', 'status', 'service', 'sampai', 'resi', 'created_date', 'created_by', 'updated_date', 'updated_by', 'transaksi_deleted'
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'transaksi_deleted';
    protected $returnType = 'App\Entities\Transaksi';
    protected $useTimestamps = false;
}

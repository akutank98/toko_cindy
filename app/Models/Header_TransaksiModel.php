<?php

namespace App\Models;

use CodeIgniter\Model;

class Header_TransaksiModel extends Model
{
    protected $table      = 'header_transaksi';
    protected $primaryKey = 'id_header';
    protected $allowedFields = [
        'id_pembeli', 'alamat', 'ongkir', 'service', 'total_harga', 'resi', 'status', 'created_date', 'updated_by', 'updated_date', 'header_transaksi_deleted',
    ];

    protected $returnType = 'App\Entities\Header_Transaksi';
    protected $useTimestamps = false;
    protected $useSoftDeletes = true;
    protected $deletedField = 'header_transaksi_deleted';
}

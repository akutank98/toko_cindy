<?php

namespace App\Models;

use CodeIgniter\Model;

class PengirimanModel extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';
    protected $allowedFields = [
        'id_transaksi', 'service', 'tujuan', 'created_date', 'created_by', 'updated_date', 'updated_by'
    ];
    protected $returnType = 'App\Entities\Pengiriman';
    protected $useTimestamps = false;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailBarangModel extends Model
{
    protected $table = 'detail_barang';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_barang', 'ukuran', 'berat', 'deskripsi', 'created_date', 'created_by', 'updated_date', 'updated_by'
    ];
    protected $returnType = 'App\Entities\DetailBarang';
    protected $useTimestamps = false;
}

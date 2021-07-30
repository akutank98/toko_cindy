<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = [
        'nama', 'harga', 'stok', 'gambar', 'created_date', 'created_by', 'updated_date', 'updated_by', 'barang_deleted', 'ukuran', 'berat', 'deskripsi'
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'barang_deleted';
    protected $returnType = 'App\Entities\Barang';
    protected $useTimestamps = false;
}

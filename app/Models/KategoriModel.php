<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = [
        'id_kategori', 'nama_kategori', 'kategori_deleted'
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'kategori_deleted';
    protected $returnType = 'App\Entities\Kategori';
    protected $useTimestamps = false;
}

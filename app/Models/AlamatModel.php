<?php

namespace App\Models;

use CodeIgniter\Model;

class AlamatModel extends Model
{
    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';
    protected $allowedFields = [
        'id_alamat',
        'id_user',
        'label',
        'kabupaten',
        'provinsi',
        'alamat',
        'alamat_deleted'
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'alamat_deleted';
    protected $returnType = 'App\Entities\Alamat';
    protected $useTimestamps = false;
}

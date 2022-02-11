<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinsiModel extends Model
{
    protected $table = 'provinsi';
    protected $primaryKey = 'province_id';
    protected $allowedFields = [
        'province_id',
        'province_name'
    ];
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}

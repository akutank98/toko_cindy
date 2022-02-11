<?php

namespace App\Models;

use CodeIgniter\Model;

class KabupatenModel extends Model
{
    protected $table = 'kabupaten';
    protected $primaryKey = 'city_id';
    protected $allowedFields = [
        'city_id',
        'province_id',
        'city_name',
        'postal_code'
    ];
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}

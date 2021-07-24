<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'log';
    protected $primaryKey = 'id_log';
    protected $allowedFields = [
        'action', 'table_name', 'id_modified', 'change_date', 'id_modifier', 'keterangan'
    ];
    protected $returnType = 'App\Entities\Log';
    protected $useTimestamps = false;
}

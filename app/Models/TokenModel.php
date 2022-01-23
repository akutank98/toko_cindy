<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table = 'token';
    protected $primaryKey = 'id_token';
    protected $allowedFields = [
        'token', 'id_user', 'created_date', 'token_deleted'
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'token_deleted';
    protected $returnType = 'App\Entities\Token';
    protected $useTimestamps = false;
}

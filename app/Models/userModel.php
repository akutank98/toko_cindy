<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = [
        'username', 'avatar', 'password', 'salt', 'created_date', 'created_by', 'updated_date', 'updated_by', 'user_deleted'
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'user_deleted';
    protected $returnType = 'App\Entities\User';
    protected $useTimestamps = false;
}

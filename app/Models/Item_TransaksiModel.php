<?php

namespace App\Models;

use CodeIgniter\Model;

class Item_TransaksiModel extends Model
{
    protected $table      = 'item_transaksi';
    protected $primaryKey = 'id_item';
    protected $allowedFields = [
        'id_transaksi', 'id_barang', 'jumlah', 'sub_total', 'item_transaksi_deleted',
    ];
    protected $useSoftDeletes = true;
    protected $deletedField = 'item_transaksi_deleted';
    protected $returnType = 'App\Entities\Item_Transaksi';
    protected $useTimestamps = false;
}

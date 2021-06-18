<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class detail_transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'jumlah_barang' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'harga_satuan' => [
                'type' => 'INT',
                'constraint' => 11,
            ]
        ]);

        $this->forge->addKey('id_detail', TRUE);
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi');
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang');
        $this->forge->createTable('detail_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}

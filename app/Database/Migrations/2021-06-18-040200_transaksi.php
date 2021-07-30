<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPUnit\Framework\containsOnly;

class transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'id_pembeli' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'alamat' => [
                'type' => 'TEXT'
            ],
            'ongkir' => [
                'type' => 'INT',
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'total_harga' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_date' => [
                'type' => 'DATETIME',
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ],
            'updated_date' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'transaksi_deleted' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);

        $this->forge->addKey('id_transaksi', TRUE);
        $this->forge->addForeignKey('id_pembeli', 'user', 'id_user');
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}

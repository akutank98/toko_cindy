<?php

namespace App\Database\Migrations;

class Barang extends \CodeIgniter\Database\Migration
{

    public function up()
    {
        $this->forge->addField([
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'nama' => [
                'type' => 'TEXT',
            ],
            'harga' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'gambar' => [
                'type' => 'TEXT',
            ],
            'ukuran' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'berat' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 500
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true
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
            'barang_deleted' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);

        $this->forge->addKey('id_barang', TRUE);
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}

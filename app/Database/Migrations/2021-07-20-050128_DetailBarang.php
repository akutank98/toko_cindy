<?php

namespace App\Database\Migrations;

class DetailBarang extends \CodeIgniter\Database\Migration
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
			'id_barang' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE
			],
			'ukuran' => [
				'type' => 'TEXT',
			],
			'berat' => [
				'type' => 'INT',
				'constraint' => 11,
				'default' => 500
			],
			'deskripsi' => [
				'type' => 'TEXT',
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
			]
		]);

		$this->forge->addKey('id_detail', TRUE);
		$this->forge->addForeignKey('id_barang', 'barang', 'id_barang');
		$this->forge->createTable('detail_barang');
	}

	public function down()
	{
		$this->forge->dropTable('detail_barang');
	}
}

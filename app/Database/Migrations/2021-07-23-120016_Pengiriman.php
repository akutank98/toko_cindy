<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengiriman extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_pengiriman' => [
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
			'service' => [
				'type' => 'TEXT',
			],
			'tujuan' => [
				'type' => 'TEXT',
			], 'status' => [
				'type' => 'TEXT',
				'default' => 'belum dikirim'
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
			'pengiriman_deleted' => [
				'type' => 'DATETIME',
				'null' => TRUE,
			],
		]);

		$this->forge->addKey('id_pengiriman', TRUE);
		$this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi');
		$this->forge->createTable('pengiriman');
	}

	public function down()
	{
		$this->forge->dropTable('pengiriman');
	}
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Log extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_log' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			],
			'action' => [
				'type' => 'TEXT',
			],
			'table_name' => [
				'type' => 'TEXT'
			],
			'id_modified' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
			],
			'change_date' => [
				'type' => 'DATETIME',
			],
			'id_modifier' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
			], 'keterangan' => [
				'type' => 'TEXT'
			]
		]);

		$this->forge->addKey('id_log', TRUE);
		$this->forge->createTable('log');
	}

	public function down()
	{
		$this->forge->dropTable('log');
	}
}

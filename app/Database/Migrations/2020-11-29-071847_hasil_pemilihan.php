<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilPemilihan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'tps_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'calon_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'user_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'hasil'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',

			],
			'created_at' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			],
			'updated_at' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			],
			'deleted_at' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			],
		]);
		$this->forge->addField('id', TRUE);
		$this->forge->createTable('tbl_hasil_pemilihan');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}

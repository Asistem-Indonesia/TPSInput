<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Calon extends Migration
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
			'nama_calon'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
			],
			'nama_wakil_calon'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',

			],
			'image'       => [
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
		$this->forge->createTable('tbl_calon');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}

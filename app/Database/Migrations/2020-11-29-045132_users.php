<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
			'username'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',

			],
			'email'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',

			],
			'password'      => [
				'type'           => 'VARCHAR',
				'constraint'     => '128',
			],
			'role_id' => [
				'type'           => 'TEXT',
				'constraint'     => '1',
				'null'           => true,
			],
			'is_active'      => [
				'type'           => 'ENUM',
				'constraint'     => ['active', 'inactive']
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
		$this->forge->createTable('tbl_users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('tbl_users');
	}
}

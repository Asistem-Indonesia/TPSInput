<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UsersSeeder extends Seeder
{
   public function run()
   {
      $time = Time::now();
      $data = [
         'username'          => 'admin',
         'email'          => 'admin@gmail.com',
         'nama'          => 'admin',
         'nohp'          => '08123456789',
         'password'       => password_hash('admin123', PASSWORD_DEFAULT),
         'role_id'       => 1,
         'is_active'    => 1,
         'created_at'    => $time->timestamp,
         'updated_at'    => $time->timestamp,
      ];

      // Using Query Builder
      $this->db->table('tbl_users')->insert($data);
   }
}

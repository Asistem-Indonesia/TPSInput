<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
   protected $table = 'tbl_users';
   protected $primaryKey = 'id';
   protected $useTimestamps = true;
   protected $dateFormat = 'int';
   protected $allowedFields = ['username', 'email', 'password', 'nama', 'nohp', 'role_id', 'kecamatan_id', 'is_active'];

   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';

   public function getUsers($id = false)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function insertUsers($data)
   {
      $query = $this->db->table($this->table)->insert($data);

      return ($query) ? true : false;
   }

   public function updateUsers($data, $id)
   {
      return $this->db->table($this->table)->update($data, ['id' => $id]);
   }

   public function deleteUsers($id)
   {
      return $this->db->table($this->table)->delete(['id' => $id]);
   }
}

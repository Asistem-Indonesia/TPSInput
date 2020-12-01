<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilPemilihan extends Model
{
   protected $table = 'tbl_hasil_pemilihan';
   protected $primaryKey = 'id';
   protected $useTimestamps = true;
   protected $dateFormat = 'int';
   protected $allowedFields = ['tps_id', 'calon_id', 'user_id', 'hasil'];

   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';

   public function getHasilPemilihan($id = false)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function insertHasilPemilihan($data)
   {
      $query = $this->db->table($this->table)->insert($data);

      return ($query) ? true : false;
   }

   public function updateHasilPemilihan($data, $id)
   {
      return $this->db->table($this->table)->update($data, ['id' => $id]);
   }

   public function deleteHasilPemilihan($id)
   {
      return $this->db->table($this->table)->delete(['id' => $id]);
   }
}

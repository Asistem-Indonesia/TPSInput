<?php

namespace App\Models;

use CodeIgniter\Model;

class PaslonModel extends Model
{
   protected $table = 'tbl_calon';
   protected $primaryKey = 'id';
   protected $useTimestamps = true;
   protected $dateFormat = 'int';
   protected $allowedFields = ['no_urut', 'nama_calon', 'nama_wakil_calon', 'image'];

   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';

   public function getPaslon($id = false)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function insertPaslon($data)
   {
      $query = $this->db->table($this->table)->insert($data);

      return ($query) ? true : false;
   }

   public function updatePaslon($data, $id)
   {
      return $this->db->table($this->table)->update($data, ['id' => $id]);
   }

   public function deletePaslon($id)
   {
      return $this->db->table($this->table)->delete(['id' => $id]);
   }
}

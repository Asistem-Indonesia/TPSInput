<?php

namespace App\Models;

use CodeIgniter\Model;

class KecamatanModel extends Model
{
   protected $table = 'tbl_kecamatan';
   protected $primaryKey = 'id';
   protected $useTimestamps = true;
   protected $dateFormat = 'int';
   protected $allowedFields = ['kecamatan'];

   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';

   public function getKecamatan($id = false)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function insertKecamatan($data)
   {
      $query = $this->db->table($this->table)->insert($data);

      return ($query) ? true : false;
   }

   public function updateKecamatan($data, $id)
   {
      return $this->db->table($this->table)->update($data, ['id' => $id]);
   }

   public function deleteKecamatan($id)
   {
      return $this->db->table($this->table)->delete(['id' => $id]);
   }


   //cetak
}

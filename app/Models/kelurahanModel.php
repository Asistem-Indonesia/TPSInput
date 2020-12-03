<?php

namespace App\Models;

use CodeIgniter\Model;

class KelurahanModel extends Model
{
   protected $table = 'tbl_kelurahan';
   protected $primaryKey = 'id';
   protected $useTimestamps = true;
   protected $dateFormat = 'int';
   protected $allowedFields = ['kelurahan', 'kecamatan_id', 'total'];

   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';

   public function getKelurahan($id = false)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function getKelurahanByName($name = false)
   {
      return $this->getWhere(['kelurahan' => $name])->getRowArray();
   }

   public function getKelurahanByKecamatanId($kecamatan_id = false)
   {
      if ($kecamatan_id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['kecamatan_id' => $kecamatan_id])->getRowArray();
      }
   }



   public function searchByKelurahan($kelurahan)
   {
      $cari = "'" . $kelurahan . "'";
      return $this->table($this->table)->like('kelurahan', $cari)->get()->getRowArray();
   }

   public function getKelurahanByKecamatan($id)
   {
      return $this->table($this->table)->like('kecamatan_id', $id);
   }

   public function insertKelurahan($data)
   {
      $query = $this->db->table($this->table)->insert($data);

      return ($query) ? true : false;
   }

   public function updateKelurahan($data, $id)
   {
      return $this->db->table($this->table)->update($data, ['id' => $id]);
   }

   public function deleteKelurahan($id)
   {
      return $this->db->table($this->table)->delete(['id' => $id]);
   }
}

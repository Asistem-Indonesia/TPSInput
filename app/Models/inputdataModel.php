<?php

namespace App\Models;

use CodeIgniter\Model;

class InputDataModel extends Model
{
   protected $tbl_kelurahan = 'tbl_kelurahan';
   protected $tbl_tps = 'tbl_tps';


   public function getTpsByKelurahanId($id)
   {
      return $this->db->table('tbl_tps')
         ->join('tbl_kelurahan', 'tbl_tps.kelurahan_id = tbl_kelurahan.id')
         ->where(['tbl_tps.kelurahan_id' => $id])
         ->get()->getResultArray();
   }

   public function getUsersByKelurahanId($id)
   {
   }


   public function getKelurahan($id = false)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function searchByKelurahan($kelurahan)
   {
      return $this->table($this->table)->like('kelurahan', $kelurahan)->get()->getRowArray();
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

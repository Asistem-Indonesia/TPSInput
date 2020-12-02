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

   public function getAllHasilPaslon($paslon_id)
   {

      return $this->getWhere(['calon_id' => $paslon_id])->getResultArray();
   }
   public function getHasilPemilihanByIdKelurahan($id = false)
   {
      $query = "SELECT * FROM `tbl_hasil_pemilihan` 
                  JOIN `tbl_tps` ON `tbl_hasil_pemilihan`.`tps_id` = `tbl_tps`.`id` 
                  WHERE `tbl_tps`.`kelurahan_id` = $id";


      return $this->db->query($query)->getResultArray();
   }

   public function getHasilPaslonByIdKelurahan($KelurahanId = false, $PaslonId = false)
   {
      $query = "SELECT * FROM `tbl_hasil_pemilihan` 
                  JOIN `tbl_tps` ON `tbl_hasil_pemilihan`.`tps_id` = `tbl_tps`.`id` 
                  WHERE `tbl_tps`.`kelurahan_id` = $KelurahanId 
                  AND `tbl_hasil_pemilihan`.`calon_id` = $PaslonId";


      return $this->db->query($query)->getResultArray();
   }


   public  function getHasilPaslon($tpsId, $PaslonId)
   {
      if ($PaslonId === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['calon_id' => $PaslonId, 'tps_id' => $tpsId])->getRowArray();
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

   public function getByTpsDanPaslon($tps_id = null, $calon_id = null)
   {

      if ($calon_id) {
         $query = "SELECT * FROM `tbl_hasil_pemilihan` 
      JOIN `tbl_tps` ON `tbl_hasil_pemilihan`.`tps_id` = `tbl_tps`.`id`
       WHERE  `tbl_hasil_pemilihan`.`calon_id` = $calon_id AND `tbl_hasil_pemilihan`.`tps_id` = $tps_id";


         return $this->db->query($query)->getRowArray();
      } else {
         $query = "SELECT * FROM `tbl_hasil_pemilihan` 
      JOIN `tbl_tps` ON `tbl_hasil_pemilihan`.`tps_id` = `tbl_tps`.`id`";


         return $this->db->query($query)->getResultArray();
      }
   }
}

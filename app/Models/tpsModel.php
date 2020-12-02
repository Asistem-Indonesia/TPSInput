<?php

namespace App\Models;

use CodeIgniter\Model;

class TpsModel extends Model
{
   protected $table = 'tbl_tps';
   protected $primaryKey = 'id';
   protected $useTimestamps = true;
   protected $dateFormat = 'int';
   protected $allowedFields = ['tps', 'kelurahan_id'];

   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';

   public function getTps($id = null)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function getTpsByKelurahanId($id, $search = null)
   {
      if ($search) {
         $data = "SELECT `tbl_tps`.`id` , `tbl_tps`.`kelurahan_id`, `tbl_tps`.`tps`, `tbl_kelurahan`.`kecamatan_id`
         FROM `tbl_tps` 
         JOIN `tbl_kelurahan` 
         ON `tbl_kelurahan`.`id` = `tbl_tps`.`kelurahan_id`
         WHERE `tbl_tps`.`kelurahan_id` =  $id AND `tbl_tps`.`tps` LIKE $search ";
      } else {
         $data = "SELECT `tbl_tps`.`id` , `tbl_tps`.`kelurahan_id`, `tbl_tps`.`tps`, `tbl_kelurahan`.`kecamatan_id`
                  FROM `tbl_tps` 
                  JOIN `tbl_kelurahan` 
                  ON `tbl_kelurahan`.`id` = `tbl_tps`.`kelurahan_id`
                  WHERE `tbl_tps`.`kelurahan_id` =  $id ";
      }
      return $this->query($data)->getResultArray();
   }

   public function searchKelurahan($search)
   {
      return $this->table($this->table)->join('tbl_kelurahan', 'tbl_kelurahan.id = tbl_tps.kelurahan_id')->like('tbl_kelurahan.kelurahan', $search);
   }

   public function insertTps($data)
   {
      $query = $this->db->table($this->table)->insert($data);

      return ($query) ? true : false;
   }

   public function updateTps($data, $id)
   {
      return $this->db->table($this->table)->update($data, ['id' => $id]);
   }

   public function deleteTps($id)
   {
      return $this->db->table($this->table)->delete(['id' => $id]);
   }

   public function jumlahTpsPerKelurahan($id)
   {
      $result = $this->db->table($this->table)->where(['kelurahan_id' => $id])->get()->getResultArray();

      return count(array_column($result, 'tps'));
   }

   public function getHasilPerKelurahanByCalonId($kelurahan_id = null, $calon_id = null)
   {
      $query = "SELECT `tbl_tps`.`id` , `tbl_tps`.`kelurahan_id`, `tbl_tps`.`tps`, `tbl_kelurahan`.`kecamatan_id`, `tbl_hasil_pemilihan`.`calon_id` , `tbl_hasil_pemilihan`.`hasil`
      FROM `tbl_tps` 
      JOIN `tbl_kelurahan` 
      ON `tbl_kelurahan`.`id` = `tbl_tps`.`kelurahan_id`
      JOIN `tbl_hasil_pemilihan` 
      ON `tbl_hasil_pemilihan`.`tps_id` = `tbl_tps`.`id`
      
      WHERE `tbl_kelurahan`.`id` =  $kelurahan_id AND `tbl_hasil_pemilihan`.`calon_id` = $calon_id";

      return $this->query($query)->getResultArray();
   }
}

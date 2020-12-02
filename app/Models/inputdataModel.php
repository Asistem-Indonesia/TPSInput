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

   public function getQueryHasilByTps($tpsId)
   {
      $query = "SELECT * , `tbl_hasil_pemilihan`.`updated_at`, `tbl_hasil_pemilihan`.`created_at`
      FROM `tbl_hasil_pemilihan` 
      JOIN `tbl_tps` 
        ON `tbl_hasil_pemilihan`.`tps_id` = `tbl_tps`.`id`
     WHERE `tbl_hasil_pemilihan`.`tps_id` = $tpsId";
      return $this->db->query($query);
   }
}

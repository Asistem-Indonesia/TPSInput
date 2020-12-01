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

   public function getTps($id = false)
   {
      if ($id === false) {
         return $this->findAll();
      } else {
         return $this->getWhere(['id' => $id])->getRowArray();
      }
   }

   public function getTpsByKelurahanId($id)
   {
      return $this->table('tbl_tps')->where(['kelurahan_id' => $id])->get()->getResultArray();
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
}

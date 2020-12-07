<?php

namespace App\Controllers;

use App\Models\HasilPemilihan;
use App\Models\PaslonModel;
use CodeIgniter\RESTful\ResourceController;

class APIPaslon extends ResourceController
{
   protected $format    = 'json';

   public function __construct()
   {
      $this->paslonModel = new PaslonModel();
      $this->hasilPemilihanModel = new HasilPemilihan();
   }

   public function index()
   {
      $getPaslon = $this->paslonModel->getPaslon();
      foreach ($getPaslon as $ps) {
         $result = $this->hasilPemilihanModel->getAllHasilPaslon($ps['id']);
         $suara = array_sum(array_column($result, 'hasil'));

         $output[] = [
            'id' => $ps['id'],
            'no_urut'  => $ps['no_urut'],
            'nama_paslon' => $ps['nama_calon'],
            'nama_wakil_paslon' => $ps['nama_wakil_calon'],
            'suara' => $suara
         ];
      }

      return $this->respond($output, 200);
   }

   // ...
}

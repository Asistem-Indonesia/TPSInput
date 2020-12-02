<?php

namespace App\Controllers;


use App\Models\HasilPemilihan;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\PaslonModel;
use App\Models\TpsModel;
use App\Models\UsersModel;


class Cetak extends BaseController
{
   public function __construct()
   {
      $this->usersModel = new UsersModel();
      $this->kelurahanModel = new KelurahanModel();
      $this->kecamatanModel = new KecamatanModel();
      $this->paslonModel = new PaslonModel();
      $this->tpsModel = new TpsModel();
      $this->hasilPemilihanModel = new HasilPemilihan();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
      $this->pager = \Config\Services::pager();
      $this->idUserSession = session()->get('id_user');
      $this->roleIdSession = session()->get('role_id');
   }
   public function index()
   {


      $data = [
         'title' => 'Cetak Data',
         'validation' => $this->validation,
         'titleMenu' => 'Cetak Laporan',
         'user' => $this->usersModel->getUsers($this->idUserSession),
         'kecamatan' => $this->kecamatanModel->findAll(),
         'paslon' => $this->paslonModel->findAll(),
         'kelurahan' => $this->kelurahanModel->findAll(),
         'kecamatanModel' => $this->kecamatanModel,
         'paslon' => $this->paslonModel->findAll(),
         'tpsModel' => $this->tpsModel,
         'db' => $this->db,
         'hasilPemilihanModel' => $this->hasilPemilihanModel,
      ];

      return view('cetak/index', $data);
   }

   public function excel()
   {
      $data = [
         'kelurahan' => $this->kelurahanModel->findAll(),
         'kecamatanModel' => $this->kecamatanModel,
         'paslon' => $this->paslonModel->findAll(),
         'tpsModel' => $this->tpsModel,
         'db' => $this->db,
         'hasilPemilihanModel' => $this->hasilPemilihanModel,

      ];

      // echo view('cetak/excel', $data);
      return view('cetak/excel', $data);
   }
   //--------------------------------------------------------------------

}

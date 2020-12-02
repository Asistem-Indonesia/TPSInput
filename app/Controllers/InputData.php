<?php

namespace App\Controllers;


use App\Models\HasilPemilihan;
use App\Models\InputDataModel;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\PaslonModel;
use App\Models\TpsModel;
use App\Models\UsersModel;


class InputData extends BaseController
{
   public function __construct()
   {


      $this->usersModel = new UsersModel();
      $this->kelurahanModel = new KelurahanModel();
      $this->paslonModel = new PaslonModel();
      $this->kecamatanModel = new KecamatanModel();
      $this->tpsModel = new TpsModel();
      $this->inputDataModel = new InputDataModel();
      $this->hasilPemilihanModel = new HasilPemilihan();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
      $this->pager = \Config\Services::pager();
      $this->idUserSession = session()->get('id_user');
      $this->roleIdSession = session()->get('role_id');
   }
   public function index($id = null)
   {



      if ($this->request->getVar('cari')) {
         $search =  "'%" . $this->request->getVar('cari') . "%'";
         $dataTPS = $this->tpsModel->getTpsByKelurahanId($id, $search);
      } else {
         $dataTPS = $this->tpsModel->getTpsByKelurahanId($id);
      }




      $kelurahan = $this->kelurahanModel->getKelurahan($id);

      $data = [
         'title' => 'Input Manajement',
         'validation' => $this->validation,
         'titleMenu' => $kelurahan['kelurahan'],
         'pager' => $this->kelurahanModel->pager,
         'user' => $this->usersModel->getUsers($this->idUserSession),
         'paslon' => $this->paslonModel->getPaslon(),
         'kelurahan' => $kelurahan,
         'db' =>   $this->db,

         'edit' => $this->request->getVar('edit'),
         'tpsperkelurahan' => $dataTPS,
         'hasilPemilihanByIdKelurahan' => $this->hasilPemilihanModel->getHasilPemilihanByIdKelurahan($id),

         //model for view
         'inputDataModel' => $this->inputDataModel,
         'usersDataModel' => $this->usersModel,
         'tpsDataModel' => $this->tpsModel,
         'hasilPemilihanModel' => $this->hasilPemilihanModel

      ];

      if ($this->request->getPost('edit')) {
         return view('users/input-data/' . $id . '?edit=' . $this->request->getPost('edit'), $data);
      }

      return view('users/input-data', $data);
   }


   public function update()
   {

      $n = 0;
      for ($i = 0; $i < count($this->request->getPost('calon_id')); $i++) {

         $suara = $this->request->getPost('suara');
         $hasilsuara = $suara[$i];

         $calon_id = $this->request->getPost('calon_id');
         $calon_id = $calon_id[$i];

         $cek = $this->hasilPemilihanModel
            ->where(['tps_id' => $this->request->getPost('tps_id'), 'calon_id' => $calon_id])
            ->first();

         if (!empty($cek)) { //update
            $this->hasilPemilihanModel->save([
               'id' => $cek['id'],
               'tps_id' => $this->request->getPost('tps_id'),
               'calon_id' => $calon_id,
               'user_id' => $this->request->getPost('user_input'),
               'hasil' => $hasilsuara
            ]);
         } else { //add
            $this->hasilPemilihanModel->save([
               'tps_id' => $this->request->getPost('tps_id'),
               'calon_id' => $calon_id,
               'user_id' => $this->request->getPost('user_input'),
               'hasil' => $hasilsuara
            ]);
         }
      }


      session()->setFlashdata('pesan', 'Berhasil di Update');

      return redirect()->to('/inputdata/' . $this->request->getPost('kelurahan_id'))->withInput()->with('validation', $this->validation);
   }
   //--------------------------------------------------------------------

}

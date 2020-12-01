<?php

namespace App\Controllers;

use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\UsersModel;

class Kecamatan extends BaseController
{
   public function __construct()
   {
      $this->usersModel = new UsersModel();
      $this->kecamatanModel = new KecamatanModel();
      $this->kelurahanModel = new KelurahanModel();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
      $this->idUserSession = session()->get('id_user');
      $this->roleIdSession = session()->get('role_id');
   }
   public function index()
   {
      $data = [
         'title' => 'Kecamatan Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Kecamatan Manajement',
         'kecamatan' => $this->kecamatanModel->paginate(5, 'tbl_kecamatan'),
         'kelurahan' => $this->kelurahanModel->getKelurahan(),
         'user' => $this->usersModel->getUsers($this->idUserSession),
         'pager' => $this->kecamatanModel->pager,
         'currentPage' => ($this->request->getVar('page_tbl_kecamatan')) ? $this->request->getVar('page_tbl_kecamatan') : 1
      ];
      return view('menu/kecamatan/index', $data);
   }

   public function create()
   {

      //validation include
      if (!$this->validate([
         'kecamatan' => [
            'rules' =>   'required|trim|is_unique[tbl_kecamatan.kecamatan]',
            'errors' => [
               'is_unique' => 'Nama Kecamatan sudah ada',
               'required' => 'Masukkan Kecamatan!',
            ]
         ]
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
         Isi data kecamatan dengan benar
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/kecamatan')->withInput()->with('validation', $this->validation);
      }


      if ($this->kecamatanModel->save([
         'kecamatan' => $this->request->getPost('kecamatan'),
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
         Data ' . $this->request->getPost('kecamatan') . ' berhasil disimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/kecamatan');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
         Data kecamatan gagal tersimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/kecamatan')->withInput()->with('validation', $this->validation);
      }
   }


   public function edit($id = null)
   {
      $data = [
         'title' => 'Kecamatan Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Edit Kecamatan',
         'kecamatan' => $this->kecamatanModel->getKecamatan(decrypt_url($id)),
         'user' => $this->usersModel->getUsers($this->idUserSession)
      ];

      return view('menu/kecamatan/edit', $data);
   }

   public function update()
   {
      //validation include
      if (!$this->validate([
         'kecamatan' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'nama kecamatan tidak boleh kosong!',
            ]
         ]
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
      Lengkapi data
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');

         return redirect()->to('/kecamatan/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }
      $data = [
         'kecamatan' => $this->request->getPost('kecamatan'),
      ];

      if ($this->kecamatanModel->updateKecamatan($data, $this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('kecamatan') . ' berhasil diupdate
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kecamatan');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di update
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kecamatan/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }
   }


   public function delete()
   {
      if ($this->kecamatanModel->delete($this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('kecamatan') . ' berhasil di Delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kecamatan');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kecamatan')->withInput()->with('validation', $this->validation);
      }
   }

   //--------------------------------------------------------------------

}

<?php

namespace App\Controllers;

use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\TpsModel;
use App\Models\UsersModel;

class Kelurahan extends BaseController
{
   public function __construct()
   {
      $this->usersModel = new UsersModel();
      $this->kelurahanModel = new KelurahanModel();
      $this->kecamatanModel = new KecamatanModel();
      $this->tpsModel = new TpsModel();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
      $this->pager = \Config\Services::pager();
      $this->idUserSession = session()->get('id_user');
      $this->roleIdSession = session()->get('role_id');
   }
   public function index()
   {
      if (!empty($this->request->getVar('kecamatan'))) {
         $kelurahan =  $this->kelurahanModel->getKelurahanByKecamatan($this->request->getVar('kecamatan'));
         $kecamatanById = $this->kecamatanModel->getKecamatan($this->request->getVar('kecamatan'));
      } else {
         $kelurahan = $this->kelurahanModel;
         $kecamatanById = null;
      }


      $data = [
         'title' => 'Kelurahan Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Kelurahan Manajement',
         'kecamatan' => $this->kecamatanModel->getKecamatan(),
         'kelurahan' =>  $kelurahan->paginate(5, 'tbl_kelurahan'),
         'kecamatanById' => $kecamatanById,
         'pager' => $this->kelurahanModel->pager,
         'tps' => $this->tpsModel->findAll(),
         'db' => $this->db,
         'user' => $this->usersModel->getUsers($this->idUserSession),
         'currentPage' => ($this->request->getVar('page_tbl_kelurahan')) ? $this->request->getVar('page_tbl_kelurahan') : 1
      ];
      return view('menu/kelurahan/index', $data);
   }

   public function create()
   {

      $this->request->getVar('kecamatanById');
      //validation include
      if (!$this->validate([
         'kecamatan' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'pilih kecamatan!',
            ]
         ],
         'kelurahan' => [
            'rules' =>   'required|trim|is_unique[tbl_kelurahan.kelurahan]',
            'errors' => [
               'is_unique' => 'Nama Kelurahan sudah ada',
               'required' => 'Masukkan nama Kelurahan!',
            ]
         ],
         'total' => [
            'rules' =>   'required|trim|numeric',
            'errors' => [
               'numberic' => 'Harus berupa angka',
               'is_unique' => 'Nama Kelurahan sudah ada',
               'required' => 'Masukkan total Penduduk!',
            ]
         ]
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
         Isi data kelurahan dengan benar
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         if ($this->request->getVar('kecamatanById')) {
            return redirect()->to('/kelurahan?kecamatan=' . $this->request->getVar('kecamatanById'))->withInput()->with('validation', $this->validation);
         } else {
            return redirect()->to('/kelurahan')->withInput()->with('validation', $this->validation);
         }
      }

      dd($this->request->getPost());
      if ($this->kelurahanModel->save([
         'kelurahan' => $this->request->getPost('kelurahan'),
         'kecamatan_id' => $this->request->getPost('kecamatan'),
         'total' => $this->request->getPost('total')
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
         Data ' . $this->request->getPost('kelurahan') . ' berhasil disimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         if ($this->request->getVar('kecamatanById')) {
            return redirect()->to('/kelurahan?kecamatan=' . $this->request->getVar('kecamatanById'))->withInput()->with('validation', $this->validation);
         } else {
            return redirect()->to('/kelurahan')->withInput()->with('validation', $this->validation);
         }
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
         Data kelurahan gagal tersimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         if ($this->request->getVar('kecamatanById')) {
            return redirect()->to('/kelurahan?kecamatan=' . $this->request->getVar('kecamatanById'))->withInput()->with('validation', $this->validation);
         } else {
            return redirect()->to('/kelurahan')->withInput()->with('validation', $this->validation);
         }
      }
   }

   public function edit($id = null)
   {
      $data = [
         'title' => 'Kelurahan Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Edit Kelurahan',
         'kecamatan' => $this->kecamatanModel->getKecamatan(),
         'kelurahan' => $this->kelurahanModel->getKelurahan(decrypt_url($id)),
         'user' => $this->usersModel->getUsers($this->idUserSession)
      ];

      return view('menu/kelurahan/edit', $data);
   }

   public function update()
   {
      //validation include
      if (!$this->validate([
         'kecamatan' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'pilih kecamatan!',
            ]
         ],
         'kelurahan' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'nama kelurahan tidak boleh kosong!',
            ]
         ],
         'total' => [
            'rules' =>   'required|trim|numeric',
            'errors' => [
               'numberic' => 'Harus berupa angka',
               'is_unique' => 'Nama Kelurahan sudah ada',
               'required' => 'Masukkan total Penduduk!',
            ]
         ]
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
      Lengkapi data
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');

         return redirect()->to('/kelurahan/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }

      $data = [
         'kelurahan' => $this->request->getPost('kelurahan'),
         'kecamatan_id' => $this->request->getPost('kecamatan'),
         'total' => $this->request->getPost('total')
      ];

      if ($this->kelurahanModel->updateKelurahan($data, $this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('kelurahan') . ' berhasil diupdate
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kelurahan');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di update
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kelurahan/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }
   }

   public function delete()
   {
      if ($this->kelurahanModel->delete($this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('kelurahan') . ' berhasil di Delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kelurahan');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/kelurahan')->withInput()->with('validation', $this->validation);
      }
   }

   //form input  tps





   //--------------------------------------------------------------------

}

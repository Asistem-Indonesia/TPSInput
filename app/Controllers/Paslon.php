<?php

namespace App\Controllers;

use App\Models\KecamatanModel;
use App\Models\PaslonModel;
use App\Models\RoleModel;
use App\Models\UsersModel;

class Paslon extends BaseController
{

   public function __construct()
   {
      $this->usersModel = new UsersModel();
      $this->paslonModel = new PaslonModel();
      $this->roleModel = new RoleModel();
      $this->kecamatanModel = new KecamatanModel();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
      $this->idUserSession = session()->get('id_user');
      $this->roleIdSession = session()->get('role_id');
   }
   public function index()
   {
      $data = [
         'title' => 'Paslon Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Paslon Manajement',
         'users' => $this->usersModel->getUsers(),
         'role' => $this->roleModel->getRole(),
         'kecamatan' => $this->kecamatanModel->getKecamatan(),
         'user' => $this->usersModel->getUsers($this->idUserSession),
         'paslon' => $this->paslonModel->getPaslon()
      ];
      return view('menu/paslon/index', $data);
   }

   public function create()
   {
      //validation include
      if (!$this->validate([
         // 'foto' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
         'no_urut' => [
            'rules' =>   'required|trim|is_unique[tbl_calon.no_urut]',
            'errors' => [
               'is_unique' => 'No Urut sudah digunakan',
               'required' => 'PilIh No Urut!',
            ]
         ],
         'nama_calon' => [
            'rules' =>   'required|trim|is_unique[tbl_calon.nama_calon]',
            'errors' => [
               'is_unique' => 'Nama calon sudah ada',
               'required' => 'Masukkan Nama Calon!',
            ]
         ],
         'nama_wakil_calon' => [
            'rules' =>   'required|trim|is_unique[tbl_calon.nama_wakil_calon]',
            'errors' => [
               'is_unique' => 'Nama wakil calon sudah ada',
               'required' => 'Masukkan Nama wakil Calon!',
            ]
         ],

      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
         Isi data dengan benar
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/paslon')->withInput()->with('validation', $this->validation);
      }

      $randomName = 'default.jpg';
      if ($this->request->getFileMultiple('foto')) {
         foreach ($this->request->getFileMultiple('foto') as $img) {
            if ($img->isValid() && !$img->hasMoved()) {
               $randomName = $img->getRandomName();
               $img->move(ROOTPATH . 'public/assets/users/paslon/', $randomName);
            }
         }
      }

      if ($this->paslonModel->save([
         'no_urut' => $this->request->getPost('no_urut'),
         'nama_calon' => $this->request->getPost('nama_calon'),
         'nama_wakil_calon' => $this->request->getPost('nama_wakil_calon'),
         'image' =>  $randomName,
         'is_active' => $this->request->getPost('is_active') ? 'active' : 'inactive',
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
         Data paslon ' . $this->request->getPost('no_urut') . ' berhasil disimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/paslon');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
         Data gagal tersimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/paslon')->withInput()->with('validation', $this->validation);
      }
   }


   public function update()
   {

      //validation include
      if (!$this->validate([
         // 'foto' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
         'no_urut' => [
            'rules' =>   'required|trim',
            'errors' => [
               'is_unique' => 'No Urut sudah digunakan',
               'required' => 'PilIh No Urut!',
            ]
         ],
         'nama_calon' => [
            'rules' =>   'required|trim',
            'errors' => [
               'is_unique' => 'Nama calon sudah ada',
               'required' => 'Masukkan Nama Calon!',
            ]
         ],
         'nama_wakil_calon' => [
            'rules' =>   'required|trim',
            'errors' => [
               'is_unique' => 'Nama wakil calon sudah ada',
               'required' => 'Masukkan Nama wakil Calon!',
            ]
         ],

      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
         Isi data dengan benar
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/paslon')->withInput()->with('validation', $this->validation);
      };

      $paslon = $this->paslonModel->getPaslon($this->request->getPost('id'));

      foreach ($this->request->getFileMultiple('foto') as $img) {
         //jika image update
         if ($img->getName() == "") {
            $randomName = $paslon['image'];
         } else {
            //delete image sebelumnya
            $image_target = 'assets/users/paslon/' . $paslon['image'];

            if (file_exists($image_target)) {
               unlink($image_target);
            }
            if (!file_exists($image_target)) {

               //update iamge baru
               if ($img->isValid() && !$img->hasMoved()) {
                  $randomName = $img->getRandomName();
                  $img->move(ROOTPATH . 'public/assets/users/paslon/', $randomName);
               }
            }
         }
      }

      if ($this->paslonModel->save([
         'id' => $this->request->getPost('id'),
         'no_urut' => $this->request->getPost('no_urut'),
         'nama_calon' => $this->request->getPost('nama_calon'),
         'nama_wakil_calon' => $this->request->getPost('nama_wakil_calon'),
         'image' => ($randomName) ? $randomName : $paslon['image'],
         'is_active' => $this->request->getPost('is_active') ? 'active' : 'inactive',
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
         Data paslon ' . $this->request->getPost('no_urut') . ' berhasil disimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/paslon');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
         Data gagal tersimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/paslon')->withInput()->with('validation', $this->validation);
      }
   }


   public function delete()
   {
      $paslon = $this->paslonModel->getPaslon($this->request->getPost('id'));

      if ($this->paslonModel->delete($this->request->getPost('id'))) {

         //delete image
         $image_target = 'assets/users/paslon/' . $paslon['image'];
         if (file_exists($image_target)) {
            unlink($image_target);
         }

         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data paslon ' . $this->request->getPost('no_urut') . ' berhasil di Delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/paslon');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/paslon')->withInput()->with('validation', $this->validation);
      }
   }

   //--------------------------------------------------------------------

}

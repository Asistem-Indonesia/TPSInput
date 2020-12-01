<?php

namespace App\Controllers;

use App\Models\KecamatanModel;
use App\Models\RoleModel;
use App\Models\UsersModel;

class Users extends BaseController
{
   public function __construct()
   {
      $this->usersModel = new UsersModel();
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
         'title' => 'Users Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Users Manajement',
         'users' => $this->usersModel->getUsers(),
         'role' => $this->roleModel->getRole(),
         'kecamatan' => $this->kecamatanModel->getKecamatan(),
         'user' => $this->usersModel->getUsers($this->idUserSession)
      ];
      return view('menu/users/index', $data);
   }

   public function create()
   {

      //validation include
      if (!$this->validate([
         'username' => [
            'rules' =>   'required|trim|is_unique[tbl_users.username]',
            'errors' => [
               'is_unique' => 'Username sudah digunakan',
               'required' => 'Masukkan Username!',
            ]
         ],
         'email' => [
            'rules' =>   'required|trim|valid_emails|is_unique[tbl_users.email]',
            'errors' => [
               'is_unique' => 'Email sudah digunakan',
               'required' => 'Masukkan Email!',
            ]
         ],
         'password' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Masukkan Email!',
            ]
         ],
         'nama' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Masukkan Nama lengkap!',
            ]
         ],
         'nohp' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Masukkan nomor telp!',
            ]
         ],
         'kecamatan' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Pilih Kecamatan!',
            ]
         ],
         'role' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Pilih role akses menu!',
            ]
         ]
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
         Isi data dengan benar
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/users')->withInput()->with('validation', $this->validation);
      }


      if ($this->usersModel->save([
         'username' => $this->request->getPost('username'),
         'email' => $this->request->getPost('email'),
         'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
         'nama' => $this->request->getPost('nama'),
         'nohp' => $this->request->getPost('nohp'),
         'image' => 'default.jpg',
         'role_id' => $this->request->getPost('role'),
         'kecamatan_id' => $this->request->getPost('kecamatan'),
         'is_active' => $this->request->getPost('is_active') ? 'active' : 'inactive',
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
         Data ' . $this->request->getPost('nama') . ' berhasil disimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/users');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
         Data gagal tersimpan
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/users')->withInput()->with('validation', $this->validation);
      }
   }


   public function edit($id = null)
   {
      $data = [
         'title' => 'Users Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Edit Users',
         'users' => $this->usersModel->getUsers(decrypt_url($id)),
         'role' => $this->roleModel->getRole(),
         'kecamatan' => $this->kecamatanModel->getKecamatan(),
         'user' => $this->usersModel->getUsers($this->idUserSession)
      ];

      return view('menu/users/edit', $data);
   }

   public function update()
   {

      //validation include
      if (!$this->validate([
         'username' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Masukkan Username!',
            ]
         ],
         'email' => [
            'rules' =>   'required|trim|valid_emails',
            'errors' => [

               'required' => 'Masukkan Email!',
            ]
         ],
         'nama' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Masukkan Nama lengkap!',
            ]
         ],
         'nohp' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Masukkan nomor telp!',
            ]
         ],
         'kecamatan' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Pilih Kecamatan!',
            ]
         ],
         'role' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'Pilih role akses menu!',
            ]
         ]
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
      Lengkapi data
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');

         return redirect()->to('/users/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }
      $data = [
         'username' => $this->request->getPost('username'),
         'email' => $this->request->getPost('email'),
         'nama' => $this->request->getPost('nama'),
         'nohp' => $this->request->getPost('nohp'),
         'image' => 'default.jpg',
         'role_id' => $this->request->getPost('role'),
         'kecamatan_id' => $this->request->getPost('kecamatan'),
         'is_active' => $this->request->getPost('is_active') ? 'active' : 'inactive',
      ];

      if ($this->usersModel->updateUsers($data, $this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('nama') . ' berhasil diupdate
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/users');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di update
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/users/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }
   }

   public function changepassword()
   {

      $user = $this->usersModel->getUsers($this->idUserSession);

      if (password_verify($this->request->getPost('password'), $user['password'])) {

         //validation include
         if (!$this->validate([
            'passwordchange' => [
               'rules' =>   'required|trim',
               'errors' => [
                  'required' => 'Masukkan Password!',
               ]
            ]
         ])) {
            session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
         Gagal melakukan perubahan password
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');

            return redirect()->to('/users/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
         }

         $data = [
            'password' => password_hash($this->request->getPost('passwordchange'), PASSWORD_DEFAULT),
         ];
         if ($this->usersModel->updateUsers($data, $this->request->getPost('id'))) {
            session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
         Password ' . $this->request->getPost('nama') . ' berhasil diupdate
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
            return redirect()->to('/users/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
         } else {
            session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
         Perubahaan password gagal
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
            return redirect()->to('/users/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
         }
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
         Password anda salah!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>');
         return redirect()->to('/users/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }
   }

   public function delete()
   {
      if ($this->usersModel->delete($this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('nama') . ' berhasil di Delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/users');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/users')->withInput()->with('validation', $this->validation);
      }
   }

   //--------------------------------------------------------------------

}

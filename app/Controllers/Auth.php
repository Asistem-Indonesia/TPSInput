<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
   public function __construct()
   {
      $this->usersModel = new UsersModel();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
   }
   public function index()
   {
      $data = [
         'title' => 'Halaman Login',
         'validation' => $this->validation
      ];
      return view('auth/login', $data);
   }

   public function login()
   {
      if (!$this->validate([
         'username' => 'required|trim',
         'password' => 'required|trim'
      ])) {
         return redirect()->to('/auth')->withInput()->with('validation', $this->validation);
      }

      //get form login
      $username = $this->request->getVar('username');
      $password = $this->request->getVar('password');

      $username_cek = $this->usersModel->where(['username' => $username])->first();


      if (!empty($username_cek)) {
         //user active check


         if ($username_cek['is_active'] == 'active') {

            //password verify 
            if (password_verify($password, $username_cek['password'])) {

               //session set
               $data = [
                  'id_user' => $username_cek['id'],
                  'username' => $username_cek['username'],
                  'role_id' => $username_cek['role_id'],

               ];
               session()->set($data);

               //role id 1 = admin, 2 = users
               if ($username_cek['role_id'] == 1) {
                  return redirect()->to('/admin');
               } else {
                  return redirect()->to('/');
               }
            } else {
               session()->setFlashdata('pesan', 'Password salah!');
               return redirect()->to('/auth')->withInput()->with('validation', $this->validation);
            }
         } else {
            session()->setFlashdata('pesan', 'Akun tidak aktif hubungi admin!');
            return redirect()->to('/auth')->withInput()->with('validation', $this->validation);
         }
      } else {
         session()->setFlashdata('pesan', 'Akun tidak ditemukan');
         return redirect()->to('/auth')->withInput()->with('validation', $this->validation);
      }
   }
   public function register()
   {
      $data = [
         'title' => 'Halaman Registrasi',
         'validation' => $this->validation
      ];
      return view('auth/register', $data);
   }

   public function logout()
   {
      session_destroy();
      session()->remove(['username', 'role_id', 'id_user']);

      session()->setFlashdata('pesan', 'Anda telah keluar');
      return redirect()->to('/auth')->withInput()->with('validation', $this->validation);
   }

   //--------------------------------------------------------------------

}

<?php

namespace App\Controllers;

use App\Models\SubMenuModel;
use App\Models\UsersModel;

class Admin extends BaseController
{
   public function __construct()
   {
      $this->usersModel = new UsersModel();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
      $this->idUserSession = session()->get('id_user');
      $this->roleIdSession = session()->get('role_id');
      $this->submenuModel = new SubMenuModel();
   }
   public function index()
   {
      $data = [
         'title' => 'Dashboard Admin',
         'validation' => $this->validation,
         'titleMenu' => 'Menu Admin',
         'user' => $this->usersModel->getUsers($this->idUserSession),
         'db' => $this->db,
         'menuMenu' => $this->submenuModel->getSubmenuByMenu(2)
      ];
      return view('admin/index', $data);
   }

   //--------------------------------------------------------------------

}

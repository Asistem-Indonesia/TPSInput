<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Models\SubMenuModel;
use App\Models\UsersAccessMenuModel;

class Access implements FilterInterface
{

   public function before(RequestInterface $request, $arguments = null)
   {
      $db = \Config\Database::connect();

      $this->subMenuModel = new SubMenuModel();
      $this->userAccessMenuModel = new UsersAccessMenuModel();

      if (!session()->get('role_id')) {
         return redirect()->to('/auth');
      } else {
         $role_id = session()->get('role_id');

         //ambil url dari segment url
         $uri = service('uri');
         $url = $uri->getSegment(1);


         //ambil menu id dari tabel subMenu
         $querySubMenu = $this->subMenuModel->where(['url' => $url])->first();
         $menu_id =  $querySubMenu['menu_id'];

         # code...

         //cocokan dengan access menu

         $cek = $this->userAccessMenuModel->where(['role_id' => $role_id, 'menu_id' => $menu_id])->first();


         if (!$cek) {
            if ($role_id == 1) {
               return redirect()->to('admin');
            } else {
               return redirect()->to('/home');
            }
         }
      }
   }

   //--------------------------------------------------------------------

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
      // Do something here
   }
}

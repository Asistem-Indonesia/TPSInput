<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Models\SubMenuModel;
use App\Models\UsersAccessMenuModel;

class AccessInputData implements FilterInterface
{

   public function before(RequestInterface $request, $arguments = null)
   {
      $db = \Config\Database::connect();

      $this->subMenuModel = new SubMenuModel();
      $this->userAccessMenuModel = new UsersAccessMenuModel();

      if (!session()->get('role_id')) {
         return redirect()->to('/auth');
      }
   }

   //--------------------------------------------------------------------

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
      // Do something here
   }
}

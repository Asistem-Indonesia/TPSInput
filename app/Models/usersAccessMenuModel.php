<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersAccessMenuModel extends Model
{
   protected $table = 'tbl_user_access_menu';
   protected $primaryKey = 'id';
   protected $useTimestamps = true;
   protected $dateFormat = 'int';
   protected $allowedFields = ['role_id', 'menu_id'];

   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';
}

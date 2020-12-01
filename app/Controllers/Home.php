<?php

namespace App\Controllers;

use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\UsersModel;

class Home extends BaseController
{
	public function __construct()
	{
		$this->usersModel = new UsersModel();
		$this->kelurahanModel = new KelurahanModel();
		$this->kecamatanModel = new KecamatanModel();
		$this->validation = \Config\Services::validation();
		$this->db = \Config\Database::connect();
		$this->pager = \Config\Services::pager();
		$this->idUserSession = session()->get('id_user');
		$this->roleIdSession = session()->get('role_id');
	}
	public function index($id = null)
	{
		$kelurahan = $this->kelurahanModel->getKelurahan($id);
		$data = [
			'title' => 'Input Manajement',
			'validation' => $this->validation,
			'titleMenu' => 'Home',
			'pager' => $this->kelurahanModel->pager,
			'user' => $this->usersModel->getUsers($this->idUserSession),
			'kelurahan' => $kelurahan,
			'currentPage' => ($this->request->getVar('page_tbl_kelurahan')) ? $this->request->getVar('page_tbl_kelurahan') : 1
		];

		return view('users/home', $data);
	}

	//--------------------------------------------------------------------

}

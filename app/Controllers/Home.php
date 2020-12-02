<?php

namespace App\Controllers;

use App\Models\HasilPemilihan;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\PaslonModel;
use App\Models\UsersModel;

class Home extends BaseController
{
	public function __construct()
	{
		$this->usersModel = new UsersModel();
		$this->kelurahanModel = new KelurahanModel();
		$this->kecamatanModel = new KecamatanModel();
		$this->paslonModel = new PaslonModel();
		$this->hasilPemilihanModel = new HasilPemilihan();
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
			'kecamatan' => $this->kecamatanModel->findAll(),
			'paslon' => $this->paslonModel->findAll(),
			'kecamatanModel' => $this->kecamatanModel,
			'kelurahanModel' => $this->kelurahanModel,
			'hasilPemilihanModel' => $this->hasilPemilihanModel,
			'db' => $this->db
		];

		return view('users/home', $data);
	}

	//--------------------------------------------------------------------

}

<?php

namespace App\Controllers;

use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\TpsModel;
use App\Models\UsersModel;

class Tps extends BaseController
{
   public function __construct()
   {

      $this->usersModel = new UsersModel();
      $this->tpsModel = new TpsModel();
      $this->kelurahanModel = new KelurahanModel();
      $this->kecamatanModel = new KecamatanModel();
      $this->validation = \Config\Services::validation();
      $this->db = \Config\Database::connect();
      $this->pager = \Config\Services::pager();
      $this->idUserSession = session()->get('id_user');
      $this->roleIdSession = session()->get('role_id');
   }
   public function index()
   {
      if (session()->get('role_id') != 1) {
         return redirect()->to('/auth');
      }

      if (!empty($this->request->getVar('search'))) {
         $tps =  $this->tpsModel->searchKelurahan($this->request->getVar('search'));
         $kelurahanByid = $this->kelurahanModel->searchByKelurahan($this->request->getVar('search')) ? $this->kelurahanModel->searchByKelurahan($this->request->getVar('search')) : null;
      } else {
         $tps = $this->tpsModel;
         $kelurahanByid = null;
      }

      $data = [
         'title' => 'TPS Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'TPS Manajement',
         'kelurahan' => $this->kelurahanModel->getKelurahan(),
         'tps' =>  $tps->paginate(20, 'tbl_tps'),
         'kelurahanByid' => $kelurahanByid,
         'pager' => $this->tpsModel->pager,
         'user' => $this->usersModel->getUsers($this->idUserSession),
         'currentPage' => ($this->request->getVar('page_tbl_tps')) ? $this->request->getVar('page_tbl_tps') : 1
      ];
      return view('menu/tps/index', $data);
   }

   public function create()
   {
      if (session()->get('role_id') != 1) {
         return redirect()->to('/auth');
      }

      if ($this->request->getPost('kecamatan')) {

         //validation include
         if (!$this->validate([
            'kelurahan' => [
               'rules' =>   'required|trim',
               'errors' => [
                  'required' => 'pilih kelurahan!',
               ]
            ],
            'jmltps' => [
               'rules' =>   'required|trim',
               'errors' => [
                  'required' => 'jumlah tps tidak boleh kosong!',
               ]
            ]
         ])) {
            return redirect()->to('/tps/create?kecamatan=' . $this->request->getPost('kecamatan'))->withInput()->with('validation', $this->validation);
         }
         $jml = $this->request->getPost('jmltps');

         for ($i = 1; $i <= $jml; $i++) {
            $cekKelurahan = $this->tpsModel->getLastTpsByKelurahanId($this->request->getPost('kelurahan'));


            if ($cekKelurahan) {
               $lastnomorTPS = intval(preg_replace("/[^0-9]/", "", $cekKelurahan->tps));
            } else {
               $lastnomorTPS = 0;
            }

            $nomorTps = $lastnomorTPS + 1;


            $tps = 'TPS ' . $nomorTps;





            $this->tpsModel->save([
               'tps' => $tps,
               'kelurahan_id' => $this->request->getPost('kelurahan'),
            ]);
         }
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
            Data ' . $this->request->getPost('tps') . ' berhasil disimpan
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
         return redirect()->to('/tps/index');
      } else {


         if (!empty($this->request->getVar('kecamatan'))) {
            $Kelurahan = $this->kelurahanModel->getKelurahanByKecamatan($this->request->getVar('kecamatan'))->get()->getResultArray();
         } else {
            $Kelurahan = null;
         }

         $data = [
            'title' => 'TPS Manajement',
            'validation' => $this->validation,
            'titleMenu' => 'Tambah TPS',
            'kecamatan' => $this->kecamatanModel->getKecamatan(),
            'kelurahan' => $Kelurahan,
            'user' => $this->usersModel->getUsers($this->idUserSession),
         ];
         return view('menu/tps/create', $data);
      }
   }


   public function edit($id = null)
   {
      if (session()->get('role_id') != 1) {
         return redirect()->to('/auth');
      }

      $data = [
         'title' => 'TPS Manajement',
         'validation' => $this->validation,
         'titleMenu' => 'Edit TPS',
         'kecamatan' => $this->kecamatanModel->getKecamatan(),
         'kelurahan' => $this->kelurahanModel->getKelurahan(),
         'tps' => $this->tpsModel->getTps(decrypt_url($id)),
         'user' => $this->usersModel->getUsers($this->idUserSession)
      ];

      return view('menu/tps/edit', $data);
   }

   public function update()
   {
      //validation include
      if (!$this->validate([
         'kelurahan' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'pilih kelurahan!',
            ]
         ],
         'tps' => [
            'rules' =>   'required|trim',
            'errors' => [
               'required' => 'nama tps tidak boleh kosong!',
            ]
         ]
      ])) {
         session()->setFlashdata('pesan', '<div class="alert alert-warning" role="alert">
      Lengkapi data
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');

         return redirect()->to('/tps/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }

      $data = [
         'tps' => $this->request->getPost('tps'),
         'kelurahan_id' => $this->request->getPost('kelurahan')
      ];

      if ($this->tpsModel->updateTps($data, $this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('tps') . ' berhasil diupdate
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/tps/index');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di update
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/tps/' . encrypt_url($this->request->getPost('id')) . '/edit')->withInput()->with('validation', $this->validation);
      }
   }


   public function delete()
   {
      if ($this->tpsModel->delete($this->request->getPost('id'))) {
         session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">
      Data ' . $this->request->getPost('tps') . ' berhasil di Delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/tps/index');
      } else {
         session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">
      Data gagal di delete
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
         return redirect()->to('/tps/index')->withInput()->with('validation', $this->validation);
      }
   }

   //--------------------------------------------------------------------

}

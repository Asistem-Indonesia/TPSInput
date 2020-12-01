<?= $this->extend('template/app_template') ?>

<?= $this->section('app_content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1><?= $titleMenu ?></h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                     <a href="<?= base_url('/admin'); ?>">
                        Home
                     </a>
                  </li>
                  <li class="breadcrumb-item active"><?= $titleMenu ?></li>
               </ol>
            </div>
         </div>
      </div><!-- /.container-fluid -->
   </section>
   <!-- Main content Kecamatan-->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
               <div class="card card-primary card-outline">
                  <div class="card-header">
                     <h3 class="card-title">Data TPS <?= $titleMenu ?></h3>
                  </div>

                  <?php if (session()->getFlashdata('pesan')) : ?>
                     <?= session()->getFlashdata('pesan'); ?>
                  <?php endif; ?>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                           <h1 class="font-weight-bold"><span class="bg-success p-3"><i class="fa fa-bullhorn" aria-hidden="true"></i></span> 4000</h1>
                           <hr>
                           <div class="pb-3 pt-3">
                              <form action="" method="GET">
                                 <input type="text" name="search" id="search" class="w-50 form-control float-left mr-2" placeholder="Contoh 'TPS 1'">
                                 <button type="submit" class="btn btn-primary">Cari</button>
                                 <a href="<?= base_url('/kelurahan/' . $kelurahan['id']); ?>" class="btn btn-secondary">Reset</a>
                              </form>
                           </div>

                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                           <div class="row">
                              <?php foreach ($paslon as $p) : ?>
                                 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 p-1">
                                    <div class=" text-center shadow-sm p-3">
                                       <div class="p-1">
                                          <img src="<?= base_url('assets/users/paslon/' . $p['image']); ?>" alt="" class="rounded-circle border" style="width: 100px; height: 100px;">
                                       </div>
                                       <h3 class="font-weight-bold"><?= $p['no_urut']; ?></h3>
                                       <div class="progress">
                                          <div class="progress-bar bg-warning" style="width: 70%"></div>
                                       </div>
                                       <p class="font-weight-bold">
                                          Perfomance 30%</p>
                                    </div>
                                 </div>
                              <?php endforeach; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
               <div class="card card-primary card-outline">
                  <!-- /.card-header -->
                  <div class="card-body " style=" height:500px; overflow-y: scroll;">
                     <?php
                     $n = 0;
                     foreach ($tpsperkelurahan as $tps) : ?>
                        <?php
                        $kelurahan = $db->table('tbl_kelurahan')->where(['id' => $tps['kelurahan_id']])->get()->getRowArray();
                        $kecamatan = $db->table('tbl_kecamatan')->where(['id' => $kelurahan['kecamatan_id']])->get()->getRowArray();
                        $users = $db->table('tbl_users')->where(['kecamatan_id' => $kecamatan['id']])->get()->getRowArray();

                        $query = $db->table('tbl_hasil_pemilihan')->where(['tps_id' => $tps['id']])->get();
                        $getResultArray = $query->getResultArray();
                        $sum = array_sum(array_column($getResultArray, 'hasil'));
                        $tgl  = $query->getRowArray();
                        ?>
                        <div class="info-box shadow">
                           <span class="info-box-icon bg-info"><?= preg_replace("/[^0-9]/", "", $tps['tps']); ?></span>
                           <div class="info-box-content">
                              <div class="row">
                                 <div class="col-12 col-lg-4">

                                    <h4 class="info-box-text font-weight-bold"><?= $tps['tps']; ?></h4>
                                    <span class="info-box-number">Total :<?= $sum; ?> </span>
                                    <small class="progress-description font-weight-bold">
                                       By : <?= $users['nama']; ?>
                                    </small>
                                    <small class="progress-description">
                                       Last Update : <?= (!empty($tgl['created_at'])) ? date("d M Y ", $tgl['created_at']) : '-' ?>
                                    </small>

                                 </div>
                                 <div class="col-12 col-lg-8">

                                    <?php if ($users['id'] == $user['id'] || $user['role_id'] == '1') : ?>
                                       <?php if (!empty($edit) and $edit == $tps['id']) : ?>

                                          <form action="<?= base_url('inputdata/update'); ?>" method="POST" class="text-center">
                                             <?= csrf_field(); ?>
                                             <input type="hidden" name="tps_id" id="tps_id" value="<?= $tps['id']; ?>">
                                             <input type="hidden" name="kelurahan_id" id="tps_id" value="<?= $kelurahan['id']; ?>">
                                             <input type="hidden" name="user_input" id="user_input" value="<?= $user['id']; ?>">
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="row">
                                                      <?php foreach ($paslon as $p) : ?>
                                                         <?php
                                                         $Result = $db->table('tbl_hasil_pemilihan')
                                                            ->getWhere(['tps_id' => $tps['id'], 'calon_id' => $p['id']])->getRowArray();

                                                         if (!empty($Result)) {
                                                         } else {
                                                            $Result['hasil'] = "";
                                                         }
                                                         ?>
                                                         <div class="col-3">
                                                            <div class="text-center">
                                                               <input type="hidden" name="calon_id[]" value="<?= $p['id'] ?>">
                                                               <label><?= $p['no_urut']; ?></label>
                                                               <input type="text" name="suara[]" class="form-control  mb-2" value="<?= $Result['hasil']; ?>">
                                                            </div>
                                                         </div>
                                                      <?php endforeach; ?>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <button type="submit" class="btn btn-primary w-100 mb-2">Simpan</button>
                                                   <a href="<?= base_url('/inputdata/' . $tps['kelurahan_id']); ?>" class="btn btn-block btn-outline-secondary w-100">Cancel</a>
                                                </div>
                                             </div>
                                          </form>
                                       <?php else : ?>

                                          <div class="row">
                                             <div class="col-12">
                                                <div class="row">
                                                   <?php foreach ($paslon as $ps) : ?>

                                                      <div class="col-3">
                                                         <div class="text-center border shadow-sm">
                                                            <label for="search"><?= $ps['no_urut']; ?></label>
                                                            <p>
                                                               <?php
                                                               $Result = $db->table('tbl_hasil_pemilihan')
                                                                  ->getWhere(['tps_id' => $tps['id'], 'calon_id' => $ps['id']])->getRowArray();

                                                               if (!empty($Result)) {
                                                                  echo $Result['hasil'];
                                                               } else {
                                                                  echo 'NULL';
                                                               }
                                                               ?>
                                                            </p>
                                                         </div>
                                                      </div>
                                                   <?php endforeach; ?>
                                                </div>
                                             </div>
                                             <div class="col-12">


                                                <a href="<?= base_url('inputdata/' . $tps['kelurahan_id'] . '?edit=' . $tps['id']); ?>" class="btn btn-success w-100 mb-2 mt-3">Edit</a>
                                             </div>
                                          </div>
                                       <?php endif; ?>
                                    <?php else : ?>

                                    <?php endif; ?>


                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php $n++;
                     endforeach; ?>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>


</div>
<?= $this->endSection(); ?>
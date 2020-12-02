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
   <?php if (empty($edit)) : ?>




      <section class="content">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="card card-primary card-outline">
                     <div class="card-header">
                        <h3 class="card-title">Data TPS <?= $titleMenu ?></h3>
                     </div>
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success m-3" role="alert">
                           <?= session()->getFlashdata('pesan'); ?>
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     <?php endif; ?>
                     <!-- /.card-header -->
                     <div class="card-body">
                        <div class="row">
                           <!-- <div class="col-lg-4 col-md-4 col-sm-12">
                              <h1 class="font-weight-bold"><span class="bg-success p-3"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                                 <?php
                                 $totalHasilKelurahan = array_sum(array_column($hasilPemilihanByIdKelurahan, 'hasil'));
                                 ?>
                                 <?= $totalHasilKelurahan . '/' . $kelurahan['total']; ?>
                              </h1>
                              <hr>
                           </div> -->
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <div class="row">
                                 <?php foreach ($paslon as $p) : ?>

                                    <?php
                                    $hasilPaslon = array_sum(array_column($hasilPemilihanModel->getHasilPaslonByIdKelurahan($kelurahan['id'], $p['id']), 'hasil'));
                                    $totalPenduduk =  $kelurahan['total'];
                                    $hasilpresentase = (!empty($hasilPaslon) && !empty($totalPenduduk)) ? (($hasilPaslon / $totalPenduduk) * 100) : 0;

                                    ?>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 p-1">
                                       <div class=" text-center shadow-sm p-3">
                                          <div class="p-1">
                                             <img src="<?= base_url('assets/users/paslon/' . $p['image']); ?>" alt="" class="rounded-circle border" style="width: 80px; height: 80px;">
                                          </div>
                                          <h4 class="font-weight-bold"><?= $p['no_urut']; ?></h4>
                                          <div class="progress">
                                             <div class="progress-bar bg-warning" style="width: <?= $hasilpresentase; ?>%"></div>
                                          </div>
                                          <p class="font-weight-bold">

                                             Perfomance <?= $hasilpresentase; ?>%</p>
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
   <?php endif; ?>
   <?php if (!empty($edit)) : ?>
      <?php
      $tps = $tpsDataModel->getTps($edit);
      ?>

      <?php if (empty($tps)) : ?>
         <section class="content">
            <div class="container-fluid">
               <h3 class="mr-5">TPS <?= $edit; ?> tidak ditemukan <a href="<?= base_url('/inputdata/' . $kelurahan['id']); ?>">Kembali</a></h3>
            </div>
         </section>


      <?php else : ?>



         <section class="content">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="card card-primary card-outline">
                        <div class="card-header">
                           <div class="row">
                              <div class="col-sm-12 col-md-8 col-lg-8 mb-3">
                                 <h3 class="card-title font-weight-bold">Data <?= $tps['tps']; ?> </h3>
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-12">
                                 <form action="" method="GET">
                                    <input type="text" name="edit" id="edit" class="w-50 form-control float-left mr-2" placeholder="Contoh '1'">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                 </form>
                              </div>
                           </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                           <!-- Edit Form -->
                           <form action="<?= base_url('inputdata/update'); ?>" method="POST" class="text-center">
                              <?= csrf_field(); ?>
                              <div class="row">
                                 <div class="col-12">
                                    <div class="row">
                                       <?php foreach ($paslon as $p) : ?>
                                          <?php
                                          $hasil = (!empty($hasilPemilihanModel->getHasilPaslon($tps['id'], $p['id']))) ? $hasilPemilihanModel->getHasilPaslon($tps['id'], $p['id']) : '';
                                          ?>
                                          <div class="col-3">
                                             <div class="text-center">
                                                <input type="hidden" name="tps_id" id="tps_id" value="<?= $tps['id']; ?>">
                                                <input type="hidden" name="user_input" id="user_input" value="<?= $user['id']; ?>">
                                                <input type="hidden" name="kelurahan_id" id="kelurahan_id" value="<?= $tps['kelurahan_id']; ?>">
                                                <input type="hidden" name="calon_id[]" value="<?= $p['id']; ?>">
                                                <label><?= $p['no_urut']; ?></label>
                                                <input type="text" name="suara[]" class="form-control  mb-2" value="<?= (!empty($hasil)) ? $hasil['hasil'] : ''; ?>">
                                             </div>
                                          </div>
                                       <?php endforeach; ?>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100 mb-2">Simpan</button>
                                    <a href="<?= base_url('inputdata/' . $tps['kelurahan_id']); ?>" class="btn btn-block btn-outline-secondary w-100">Cancel</a>
                                 </div>
                              </div>
                           </form>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      <?php endif; ?>
   <?php else : ?>
      <section class="content">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="card card-primary card-outline">
                     <div class="card-header">

                        <div class="float-right">
                           <form action="" method="GET">
                              <input type="text" name="cari" id="cari" class="w-50 form-control float-left mr-2" placeholder="Contoh 'TPS 1'">
                              <button type="submit" class="btn btn-primary">Cari</button>
                              <a href="<?= base_url('/inputdata/' . $kelurahan['id']); ?>" class="btn btn-secondary">Reset</a>
                           </form>

                        </div>
                     </div>
                     <!-- /.card-header -->

                     <div class="card-body " style=" height:500px; overflow-y: scroll;">
                        <?php
                        $n = 0;
                        foreach ($tpsperkelurahan as $tps) : ?>


                           <?php

                           //query tbl-hasil beerdasarkan tbl-tps
                           $RowArrayHasilByTps = $inputDataModel->getQueryHasilByTps($tps['id'])->getRowArray();
                           $ResultArrayHasilByTps = $inputDataModel->getQueryHasilByTps($tps['id'])->getResultArray();



                           //query tbl-users berdasrkan user_id pada RowArrayHasilByTps
                           $userPengimput = (!empty($RowArrayHasilByTps['user_id'])) ? $RowArrayHasilByTps['user_id'] : '-';
                           $DetailUsers = $usersDataModel->getUsers($userPengimput);
                           ?>
                           <div class="info-box shadow">
                              <span class="info-box-icon bg-info"><?= preg_replace("/[^0-9]/", "", $tps['tps']); ?></span>
                              <div class="info-box-content">
                                 <div class="row">
                                    <div class="col-12 col-lg-4">
                                       <h4 class="info-box-text font-weight-bold"><?= $tps['tps']; ?></h4>
                                       <span class="info-box-number">Total suara: <?= array_sum(array_column($ResultArrayHasilByTps, 'hasil')); ?> </span>
                                       <small class="progress-description font-weight-bold">
                                          By : <?= (!empty($DetailUsers['nama'])) ? $DetailUsers['nama'] : '-'; ?>
                                       </small>
                                       <small class="progress-description">
                                          Last Update :<?= (!empty($RowArrayHasilByTps['updated_at'])) ? date('d M Y H:i:s', $RowArrayHasilByTps['updated_at']) : '-'; ?>
                                       </small>
                                    </div>
                                    <div class="col-12 col-lg-8">

                                       <?php if (!empty($edit == $tps['id'])) : ?>
                                          <!-- Edit Form -->
                                          <form action="<?= base_url('inputdata/update'); ?>" method="POST" class="text-center">
                                             <?= csrf_field(); ?>
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="row">
                                                      <?php foreach ($paslon as $p) : ?>
                                                         <?php
                                                         $hasil = (!empty($hasilPemilihanModel->getHasilPaslon($tps['id'], $p['id']))) ? $hasilPemilihanModel->getHasilPaslon($tps['id'], $p['id']) : '';
                                                         ?>
                                                         <div class="col-3">
                                                            <div class="text-center">
                                                               <input type="hidden" name="tps_id" id="tps_id" value="<?= $tps['id']; ?>">
                                                               <input type="hidden" name="user_input" id="user_input" value="<?= $user['id']; ?>">
                                                               <input type="hidden" name="kelurahan_id" id="kelurahan_id" value="<?= $tps['kelurahan_id']; ?>">
                                                               <input type="hidden" name="calon_id[]" value="<?= $p['id']; ?>">
                                                               <label><?= $p['no_urut']; ?></label>
                                                               <input type="text" name="suara[]" class="form-control  mb-2" value="<?= (!empty($hasil)) ? $hasil['hasil'] : ''; ?>">
                                                            </div>
                                                         </div>
                                                      <?php endforeach; ?>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <button type="submit" class="btn btn-primary w-100 mb-2">Simpan</button>
                                                   <a href="<?= base_url('inputdata/' . $tps['kelurahan_id']); ?>" class="btn btn-block btn-outline-secondary w-100">Cancel</a>
                                                </div>
                                             </div>
                                          </form>
                                       <?php else : ?>
                                          <!-- Show -->
                                          <div class="row">
                                             <div class="col-12">
                                                <div class="row">

                                                   <?php foreach ($paslon as $p) : ?>
                                                      <?php
                                                      $hasil = (!empty($hasilPemilihanModel->getHasilPaslon($tps['id'], $p['id']))) ? $hasilPemilihanModel->getHasilPaslon($tps['id'], $p['id']) : '';
                                                      ?>
                                                      <div class="col-3">
                                                         <div class="text-center">
                                                            <label><?= $p['no_urut']; ?></label>
                                                            <div><?= (!empty($hasil)) ? $hasil['hasil'] : '0'; ?></div>
                                                         </div>
                                                      </div>
                                                   <?php endforeach; ?>
                                                </div>
                                             </div>
                                             <div class="col-12 mt-3">
                                                <?php if ($user['kecamatan_id'] == $tps['kecamatan_id'] || $user['role_id'] == 1) : ?>
                                                   <a href="<?= base_url('inputdata/' . $tps['kelurahan_id'] . '?edit=' . $tps['id']); ?>" class="btn btn-success w-100">Edit</a>
                                                <?php endif; ?>
                                             </div>
                                          </div>
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
   <?php endif ?>

</div>
<?= $this->endSection(); ?>
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

                     <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                           <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                           <i class="fas fa-times"></i>
                        </button>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <?php foreach ($paslon as $p) : ?>
                           <?php

                           $result = $hasilPemilihanModel->getAllHasilPaslon($p['id']);
                           $resultkelurahan = $kelurahanModel->findAll();


                           $totalWarga = (!empty($resultkelurahan)) ? array_sum(array_column($resultkelurahan, 'total')) : 0;
                           $SuaraPaslon = (!empty($result)) ? array_sum(array_column($result, 'hasil')) : 0;

                           if (!empty($resultkelurahan)) {
                              $totalHasil = ($SuaraPaslon / $totalWarga) * 100;
                           } else {
                              $totalHasil = 0;
                           }


                           ?>
                           <div class="col-lg-3 col-md-3 col-sm-12">
                              <div class="row m-2 border">
                                 <div class="col-12 text-center p-3">
                                    <h3 class="font-weight-normal bg-success">
                                       <span class="font-weight-bold"><?= $totalHasil; ?>% </span>
                                       <!-- (<?= $SuaraPaslon; ?> / <?= $totalWarga; ?>) -->
                                    </h3>
                                    <img src="<?= base_url('assets/users/paslon/' . $p['image']); ?>" alt="" class="img-circle img-fluid img-thumbnail" style="width: 150px; height: 150px;">
                                 </div>
                                 <div class="col-12 text-center">
                                    <h1 class="font-weight-bold"><?= $p['no_urut']; ?></h1>
                                    <h2 class="lead"><b><?= $p['nama_calon']; ?></b></h2>
                                    <h2 class="lead"><b><?= $p['nama_wakil_calon']; ?></b></h2>
                                 </div>
                              </div>
                           </div>
                        <?php endforeach; ?>
                     </div>
                  </div>
               </div>
            </div>
            <?php foreach ($paslon as $pd) : ?>
               <?php

               $result = $hasilPemilihanModel->getAllHasilPaslon($pd['id']);

               $resultkelurahan = $kelurahanModel->findAll();

               $totalWarga = (!empty($resultkelurahan)) ? array_sum(array_column($resultkelurahan, 'total')) : 0;
               $SuaraPaslon = (!empty($result)) ? array_sum(array_column($result, 'hasil')) : 0;
               ?>
               <div class="col-lg-12">
                  <div class="card card-primary card-outline">
                     <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                           <h1 class="card-title font-weight-bold">Paslon <?= $pd['no_urut']; ?></h1>
                           <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                 <i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                 <i class="fas fa-times"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-4">
                              <div class="row">
                                 <div class="col-12 text-center p-3">
                                    <img src="<?= base_url('assets/users/paslon/' . $pd['image']); ?>" alt="" class="img-circle img-fluid img-thumbnail" style="width: 200px; height: 200px;">
                                 </div>
                                 <div class="col-12 text-center">
                                    <h2 class="lead font-weight-bold"><b><?= $pd['nama_calon']; ?></b></h2>
                                    <h2 class="lead font-weight-bold"><b><?= $pd['nama_wakil_calon']; ?></b></h2>
                                 </div>
                              </div>
                           </div>
                           <div class="col-8">
                              <div class="card-header">
                                 <h3 class="card-title font-weight-bold">Jumlah Suara <?= $SuaraPaslon; ?>/<?= $totalWarga; ?></h3>
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body" style=" height:300px; overflow-y: scroll;">
                                 <?php foreach ($kecamatan as $kc) : ?>

                                    <?php
                                    $kcId = $kc['id'];
                                    $query = "SELECT * FROM tbl_kelurahan WHERE tbl_kelurahan.kecamatan_id = $kcId";
                                    $result = $db->query($query)->getResultArray();

                                    $resultkelurahanPerkecamatan = $kelurahanModel->getKelurahanByKecamatanId($kcId);
                                    $totalWargaPerKecamatan = (!empty($resultkelurahanPerkecamatan)) ? array_sum(array_column($resultkelurahanPerkecamatan, 'total')) : 0;

                                    $totalSuaraPaslonPerKecamatan;

                                    ?>
                                    <label><?= $kc['kecamatan']; ?></label>

                                    <?php
                                    $kc_id = $kc['id'];
                                    $paslon_id =  $pd['id'];
                                    $queryB = "SELECT * FROM tbl_hasil_pemilihan JOIN tbl_tps ON tbl_hasil_pemilihan.tps_id = tbl_tps.id 
                                          JOIN tbl_kelurahan ON tbl_tps.kelurahan_id = tbl_kelurahan.id WHERE tbl_kelurahan.kecamatan_id = $kc_id AND tbl_hasil_pemilihan.calon_id = $paslon_id
                                       ";
                                    $result = $db->query($queryB)->getResultArray();
                                    $hasilPaslonPerKecamatan = (!empty($result)) ? array_sum(array_column($result, 'hasil')) : 0;

                                    //hitung

                                    if ($totalWargaPerKecamatan) {
                                       $persenPaslonPerKecamatan = ($hasilPaslonPerKecamatan / $totalWargaPerKecamatan) * 100;
                                    } else {
                                       $persenPaslonPerKecamatan = 0;
                                    }
                                    ?>
                                    <div class="progress mb-3">
                                       <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?= $persenPaslonPerKecamatan; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persenPaslonPerKecamatan; ?>%">
                                          <span class="sr-only"><?= $persenPaslonPerKecamatan; ?>% Complete (success)</span>
                                          <?= $persenPaslonPerKecamatan; ?>% (<?= $hasilPaslonPerKecamatan; ?> suara)
                                       </div>
                                    </div>
                                 <?php endforeach; ?>
                              </div>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
   </section>
</div>
<?= $this->endSection(); ?>
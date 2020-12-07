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
                        Menu Admin
                     </a>
                  </li>
                  <li class="breadcrumb-item active"> <a href="<?= base_url('/tps/index'); ?>"><?= $title; ?></a></li>
                  <li class="breadcrumb-item active"><?= $titleMenu ?></li>
               </ol>
            </div>
         </div>
      </div><!-- /.container-fluid -->
   </section>
   <!-- Main content Kecamatan-->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
               <div class="card card-primary card-outline">
                  <div class="card-header">
                     <h3 class="card-title">Pilih Kecamatan</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <form action="" method="GET">
                        <select name="kecamatan" class="w-50 custom-select" id="kecamatan">
                           <option value="">-- Pilih Kecamatan --</option>
                           <?php foreach ($kecamatan as $k) : ?>
                              <option value="<?= $k['id']; ?>" <?php if (!empty($_GET['kecamatan'])) {
                                                                  echo ($_GET['kecamatan'] == $k['id']) ? 'selected' : '';
                                                               } ?>><?= $k['kecamatan'] ?></option>
                           <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Pilih</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- /.content -->

   <?php if (!empty($kelurahan)) : ?>


      <!-- Main content Kelurahan-->
      <section class="content">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12 col-md-6 col-lg-6">
                  <div class="card card-primary card-outline">
                     <div class="card-header">
                        <h3 class="card-title">Tambah Data TPS</h3>
                     </div>
                     <!-- /.card-header -->
                     <form action="<?= base_url('tps/create'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="kecamatan" value="<?= (!empty($_GET['kecamatan'])); ?>">
                        <div class="card-body">
                           <div class="form-group">
                              <label for="kelurahan" class="col-form-label">Pilih Kelurahan'</label>
                              <select name="kelurahan" class="custom-select form-control  <?= ($validation->hasError('kelurahan')) ? 'is-invalid' : ''; ?>" id="kelurahan">
                                 <option value="">-- Pilih Kelurahan --</option>
                                 <?php foreach ($kelurahan as $k) : ?>
                                    <option value="<?= $k['id']; ?>" <?= (old('kelurahan') == $k['id']) ? 'selected' : ''; ?>><?= $k['kelurahan'] ?></option>
                                 <?php endforeach; ?>
                              </select>
                              <div class="invalid-feedback pl-4">
                                 <span class="text-danger"><?= $validation->getError('kelurahan'); ?></span>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="jmltps" class="col-form-label">Jumlah TPS</label>
                              <input type="text" name="jmltps" class="form-control  <?= ($validation->hasError('jmltps')) ? 'is-invalid' : ''; ?>" value="<?= old('jmltps'); ?>" placeholder="jumlah TPS" id="jmltps">
                              <div class="invalid-feedback pl-4">
                                 <span class="text-danger"><?= $validation->getError('jmltps'); ?></span>
                              </div>
                           </div>
                           <!-- <div class="form-group">
                              <label for="tps" class="col-form-label">Nama TPS</label>
                              <input type="text" name="tps" class="form-control  <?= ($validation->hasError('tps')) ? 'is-invalid' : ''; ?>" value="<?= old('tps'); ?>" placeholder="nama tps" id="tps">
                              <div class="invalid-feedback pl-4">
                                 <span class="text-danger"><?= $validation->getError('tps'); ?></span>
                              </div>
                           </div> -->
                        </div>
                        <div class="modal-footer">
                           <a href="<?= base_url('/tps/index'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
                           <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- /.content -->
   <?php endif; ?>
</div>
<?= $this->endSection(); ?>
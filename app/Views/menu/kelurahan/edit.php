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
                  <li class="breadcrumb-item">
                     <a href="<?= base_url('/kelurahan'); ?>">
                        Manajement kelurahan
                     </a>
                  </li>
                  <li class="breadcrumb-item active"><?= $titleMenu; ?> (<?= $kelurahan['kelurahan']; ?>)</li>
               </ol>
            </div>
         </div>
      </div><!-- /.container-fluid -->
   </section>

   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-6">
               <form action="<?= base_url('/kelurahan/update'); ?>" method="POST">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="id" value="<?= $kelurahan['id']; ?>">
                  <div class="card card-primary card-outline">
                     <div class="card-header">
                        <h3 class="card-title">Pengelolahan Data kelurahan</h3>
                     </div>
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>

                     <div class="card-body">
                        <div class="form-group">
                           <label for="kecamatan" class="col-form-label">Nama Kecamatan:</label>
                           <select name="kecamatan" class="custom-select <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" id="kecamatan">
                              <option value="">-- Pilih Kecamatan --</option>
                              <?php foreach ($kecamatan as $k) : ?>
                                 <option value="<?= $k['id']; ?>" <?= ($k['id'] == $kelurahan['kecamatan_id']) ? 'selected' : ''; ?>><?= $k['kecamatan'] ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="kelurahan" class="col-form-label">Nama Kelurahan: </label>
                           <input type="text" name="kelurahan" class="form-control  <?= ($validation->hasError('kelurahan')) ? 'is-invalid' : ''; ?>" value="<?= $kelurahan['kelurahan']; ?>" placeholder="kelurahan" id="kelurahan">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('kelurahan'); ?></span>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="total" class="col-form-label">Total Penduduk</label>
                           <input type="text" name="total" class="form-control  <?= ($validation->hasError('total')) ? 'is-invalid' : ''; ?>" value="<?= $kelurahan['total']; ?>" placeholder="total penduduk" id="total">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('total'); ?></span>
                           </div>
                        </div>

                     </div>
                     <div class="modal-footer">
                        <a href="<?= base_url('/kelurahan'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
   </section>
   <!-- /.content -->
</div>

<?= $this->endSection(); ?>
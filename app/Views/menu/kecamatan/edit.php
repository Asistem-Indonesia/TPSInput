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
                     <a href="<?= base_url('/kecamatan'); ?>">
                        Manajement Kecamatan
                     </a>
                  </li>
                  <li class="breadcrumb-item active"><?= $titleMenu; ?> (<?= $kecamatan['kecamatan']; ?>)</li>
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
               <form action="<?= base_url('/kecamatan/update'); ?>" method="POST">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="id" value="<?= $kecamatan['id']; ?>">
                  <div class="card card-primary card-outline">
                     <div class="card-header">
                        <h3 class="card-title">Pengelolahan Data Kecamatan</h3>
                     </div>
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>

                     <div class="card-body">
                        <div class="form-group">
                           <label for="kecamatan" class="col-form-label">Nama Kecamatan: </label>
                           <input type="text" name="kecamatan" class="form-control  <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" value="<?= $kecamatan['kecamatan']; ?>" placeholder="Kecamatan" id="kecamatan">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('kecamatan'); ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <a href="<?= base_url('/kecamatan'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
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
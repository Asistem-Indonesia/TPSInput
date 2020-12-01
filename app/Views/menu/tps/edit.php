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
                     <a href="<?= base_url('/tps'); ?>">
                        TPS manajement
                     </a>
                  </li>
                  <li class="breadcrumb-item active"><?= $titleMenu; ?> (<?= $tps['tps']; ?>)</li>
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
               <form action="<?= base_url('/tps/update'); ?>" method="POST">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="id" value="<?= $tps['id']; ?>">
                  <div class="card card-primary card-outline">
                     <div class="card-header">
                        <h3 class="card-title">Pengelolahan Data TPS</h3>
                     </div>
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>

                     <div class="card-body">
                        <div class="form-group">
                           <label for="kelurahan" class="col-form-label">Nama Kelurahan:</label>
                           <select name="kelurahan" class="custom-select <?= ($validation->hasError('kelurahan')) ? 'is-invalid' : ''; ?>" id="kelurahan">
                              <option value="">-- Pilih Kelurahan --</option>
                              <?php foreach ($kelurahan as $k) : ?>
                                 <option value="<?= $k['id']; ?>" <?= ($k['id'] == $tps['kelurahan_id']) ? 'selected' : ''; ?>>

                                    <?= $k['kelurahan'] ?>
                                    (<?php
                                       foreach ($kecamatan as $kc) {
                                          if ($k['kecamatan_id'] == $kc['id']) {
                                             echo $kc['kecamatan'];
                                             break;
                                          }
                                       }
                                       ?>)
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="tps" class="col-form-label">Nama Tps: </label>
                           <input type="text" name="tps" class="form-control  <?= ($validation->hasError('tps')) ? 'is-invalid' : ''; ?>" value="<?= $tps['tps']; ?>" placeholder="<?= $tps['tps']; ?>" id="tps">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('tps'); ?></span>
                           </div>
                        </div>

                     </div>
                     <div class="modal-footer">
                        <a href="<?= base_url('/tps'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
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
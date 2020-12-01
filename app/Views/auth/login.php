<?= $this->extend('template/auth_template') ?>

<?= $this->section('auth_content'); ?>

<body class="hold-transition login-page">
   <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
         <div class="card-header text-center">
            <a href="" class="h1"><b>Aplikasi </b>TPS</a>
         </div>
         <div class="card-body">
            <?php if (session()->getFlashdata('pesan')) : ?>
               <p class="login-box-msg text-danger"> <?= session()->getFlashdata('pesan'); ?></p>
            <?php endif; ?>
            <form action="<?= base_url('/login'); ?>" method="POST">
               <!-- <div class="input-group mb-3">
                  <input type="text" name="username" class="form-control  <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" value="<?= old('username'); ?>" placeholder="Username">
                  <div class="input-group-append">
                     <div class="input-group-text">
                        <span class="fas fa-user"></span>
                     </div>
                  </div>
                  <div class="invalid-feedback pl-4">
                     <span class="text-danger"><?= $validation->getError('username'); ?></span>
                  </div>
               </div> -->
               <div class="input-group mb-3">
                  <input type="text" name="username" class="form-control  <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" value="<?= old('username'); ?>" placeholder="Username">
                  <div class="input-group-append">
                     <div class="input-group-text">
                        <span class="fas fa-user"></span>
                     </div>
                  </div>
                  <div class="invalid-feedback pl-4">
                     <span class="text-danger"><?= $validation->getError('username'); ?></span>
                  </div>
               </div>
               <div class="input-group mb-3">
                  <input type="password" name="password" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" placeholder="Password">
                  <div class="input-group-append">
                     <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                     </div>
                  </div>
                  <div class="invalid-feedback pl-4">
                     <span class="text-danger"><?= $validation->getError('password'); ?></span>
                  </div>
               </div>
               <div class="row">

                  <div class="col-12">
                     <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                  </div>
                  <!-- /.col -->
               </div>
            </form>
         </div>
         <!-- /.card-body -->
      </div>
      <!-- /.card -->
   </div>
   <!-- /.login-box -->

   <?= $this->endSection(); ?>
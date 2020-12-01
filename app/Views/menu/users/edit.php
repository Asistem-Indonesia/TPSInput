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
                     <a href="<?= base_url('/users'); ?>">
                        Manajement Users
                     </a>
                  </li>
                  <li class="breadcrumb-item active"><?= $titleMenu; ?> (<?= $users['username']; ?>)</li>
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
               <form action="<?= base_url('/users/update'); ?>" method="POST">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="id" value="<?= $users['id']; ?>">
                  <div class="card card-primary card-outline">
                     <div class="card-header">
                        <h3 class="card-title">Pengelolahan Data Pengguna</h3>
                     </div>
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>

                     <div class="card-body">
                        <div class="form-group">
                           <label for="username" class="col-form-label">Username: </label>
                           <input type="text" name="username" class="form-control  <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" value="<?= $users['username']; ?>" placeholder="Username" id="username">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('username'); ?></span>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="password" class="col-form-label">Password: </label>
                           <button type="button" class="form-control btn btn-danger" data-toggle="modal" data-target="#changepassword">Rubah Password</button>
                        </div>
                        <div class="form-group">
                           <label for="email" class="col-form-label">Email: </label>
                           <input type="text" name="email" class="form-control  <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" value="<?= $users['email']; ?>" placeholder="email lengkap" id="email">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('email'); ?></span>
                           </div>
                        </div>
                        <hr>
                        <div class="form-group">
                           <label for="nama" class="col-form-label">Nama lengkap: </label>
                           <input type="text" name="nama" class="form-control  <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?= $users['nama']; ?>" placeholder="Nama lengkap" id="nama">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('nama'); ?></span>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="nohp" class="col-form-label">No Telp: </label>
                           <input type="text" name="nohp" class="form-control  <?= ($validation->hasError('nohp')) ? 'is-invalid' : ''; ?>" value="<?= $users['nohp']; ?>" placeholder="nohp lengkap" id="nohp">
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('nohp'); ?></span>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="kecamatan" class="col-form-label">Role akses input: </label>
                           <select name="kecamatan" class="custom-select <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" id="kecamatan">
                              <option value="">-- Pilih Kecamatan --</option>
                              <?php foreach ($kecamatan as $k) : ?>
                                 <option value="<?= $k['id']; ?>" <?= ($users['kecamatan_id'] == $k['id']) ? 'selected' : ''; ?>><?= $k['kecamatan'] ?></option>
                              <?php endforeach; ?>
                           </select>
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('kecamatan'); ?></span>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="role" class="col-form-label">Role akses menu: </label>
                           <select name="role" class="custom-select <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" id="role">
                              <option value="">-- Pilih Access --</option>
                              <?php foreach ($role as $r) : ?>
                                 <option value="<?= $r['id']; ?>" <?= ($users['role_id'] == $r['id']) ? 'selected' : ''; ?>><?= $r['role'] ?></option>
                              <?php endforeach; ?>
                           </select>
                           <div class="invalid-feedback pl-4">
                              <span class="text-danger"><?= $validation->getError('role'); ?></span>
                           </div>
                        </div>
                        <div class="custom-control custom-checkbox">
                           <input name="is_active" type="checkbox" class="custom-control-input" id="is_active" checked="<?= ($users['is_active'] == 'active') ? 'checked' : ''; ?>">
                           <label class="custom-control-label" for="is_active">Active</label>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <a href="<?= base_url('/users'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
   </section>
   <!-- /.content -->
</div>


<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="changepassword" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="<?= base_url('/users/changePassword'); ?>" method="POST">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="id" value="<?= $users['id']; ?>">
            <div class="modal-header bg-primary">
               <h5 class="modal-title font-weight-bold" id="changepassword">Konfirmasi perubahan password</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>

            <div class="modal-body">
               <div class="form-group">
                  <label for="password" class="col-form-label">Password anda: </label>
                  <input type="text" name="password" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" placeholder="Password" id="password">
                  <div class="invalid-feedback pl-4">
                     <span class="text-danger"><?= $validation->getError('password'); ?></span>
                  </div>
               </div>
               <div class="form-group">
                  <label for="passwordchange" class="col-form-label">Password yang mau di ubah: </label>
                  <input type="text" name="passwordchange" class="form-control  <?= ($validation->hasError('passwordchange')) ? 'is-invalid' : ''; ?>" value="<?= old('passwordchange'); ?>" placeholder="Password <?= $users['nama'] ?> baru" id="passwordchange">
                  <div class="invalid-feedback pl-4">
                     <span class="text-danger"><?= $validation->getError('passwordchange'); ?></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Rubah Password</button>
            </div>
         </form>
      </div>
   </div>
</div>
<?= $this->endSection(); ?>
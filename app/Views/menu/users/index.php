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
                  <li class="breadcrumb-item active"><?= $titleMenu ?></li>
               </ol>
            </div>
         </div>
      </div><!-- /.container-fluid -->
   </section>

   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card card-primary card-outline">
                  <div class="card-header">
                     <h3 class="card-title">Pengelolahan Data Pengguna</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah data pengguna</button>
                     <!-- <button type="button" class="btn btn-info toastrDefaultInfo">
                        Launch Info Toast
                     </button> -->
                     <!-- Modal Tambah -->
                     <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <form action="<?= base_url('/users/create'); ?>" method="POST">
                                 <?= csrf_field(); ?>
                                 <div class="modal-header bg-primary">
                                    <h5 class="modal-title font-weight-bold" id="addModalLabel">Form tambah data pengguna</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>

                                 <div class="modal-body">
                                    <div class="form-group">
                                       <label for="username" class="col-form-label">Username: </label>
                                       <input type="text" name="username" class="form-control  <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" value="<?= old('username'); ?>" placeholder="Username" id="username">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('username'); ?></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="password" class="col-form-label">Password: </label>
                                       <input type="text" name="password" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" placeholder="Password" id="password">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('password'); ?></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="email" class="col-form-label">Email: </label>
                                       <input type="text" name="email" class="form-control  <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" value="<?= old('email'); ?>" placeholder="email lengkap" id="email">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('email'); ?></span>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                       <label for="nama" class="col-form-label">Nama lengkap: </label>
                                       <input type="text" name="nama" class="form-control  <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" value="<?= old('nama'); ?>" placeholder="Nama lengkap" id="nama">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('nama'); ?></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="nohp" class="col-form-label">No Telp: </label>
                                       <input type="text" name="nohp" class="form-control  <?= ($validation->hasError('nohp')) ? 'is-invalid' : ''; ?>" value="<?= old('nohp'); ?>" placeholder="nohp lengkap" id="nohp">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('nohp'); ?></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="kecamatan" class="col-form-label">Role akses input: </label>
                                       <select name="kecamatan" class="custom-select <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" id="kecamatan">
                                          <option value="">-- Pilih Kecamatan --</option>
                                          <?php foreach ($kecamatan as $k) : ?>
                                             <option value="<?= $k['id']; ?>"><?= $k['kecamatan'] ?></option>
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
                                             <option value="<?= $r['id']; ?>"><?= $r['role'] ?></option>
                                          <?php endforeach; ?>
                                       </select>
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('role'); ?></span>
                                       </div>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                       <input name="is_active" type="checkbox" class="custom-control-input" id="is_active" checked="checked">
                                       <label class="custom-control-label" for="is_active">Active</label>
                                    </div>

                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>


                     <hr>
                     <!-- Table Data -->
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th style="width: 10px">#</th>
                              <th>Username</th>
                              <th>Nama</th>
                              <th>No Hp</th>
                              <th>Rest</th>
                              <th>Role</th>
                              <th>Status</th>
                              <th class="text-right">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           foreach ($users as $u) : ?>
                              <tr>
                                 <td><?= $no++; ?></td>
                                 <td><?= $u['username']; ?></td>
                                 <td><?= $u['nama']; ?></td>
                                 <td><?= $u['nohp']; ?></td>
                                 <td>
                                    <?php
                                    foreach ($kecamatan as $kc) {
                                       if ($kc['id'] == $u['kecamatan_id']) {
                                          echo $kc['kecamatan'];
                                          break;
                                       }
                                    }
                                    ?>
                                 </td>
                                 <td>
                                    <?php
                                    foreach ($role as $r) {
                                       if ($u['role_id'] == $r['id']) {
                                          echo $r['role'];
                                          break;
                                       }
                                    }
                                    ?>
                                 </td>
                                 <td>
                                    <?= ($u['is_active'] == 'active') ? '<span class="badge bg-success">active</span>' : '<span class="badge bg-warning">Inactive</span>'; ?>
                                 </td>
                                 <td class="float-right">
                                    <a href="<?= base_url('/users/' . encrypt_url($u['id'])) . '/edit'; ?>" class="btn btn-outline-info"><i class="fas fa-edit"></i></a>

                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal<?= $u['id'] ?>"><i class="fas fa-trash"></i></button>
                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-sm" id="deleteModal<?= $u['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                             <form action="<?= base_url('/users/delete'); ?>" method="POST">
                                                <input type="hidden" name="id" id="id" value="<?= $u['id']; ?>">
                                                <input type="hidden" name="nama" id="nama" value="<?= $u['nama']; ?>">
                                                <div class="modal-header bg-danger">
                                                   <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus data pengguna</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                   </button>
                                                </div>
                                                <div class="modal-body">
                                                   <p>Anda yakin akan menghapus data <b><?= $u['nama']; ?></b> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                                                   <button type="submit" class="btn btn-danger">Hapus pengguna</button>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
                  <!-- /.card-body -->
               </div>
               <!-- /.card -->
            </div>
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>
<?= $this->endSection(); ?>
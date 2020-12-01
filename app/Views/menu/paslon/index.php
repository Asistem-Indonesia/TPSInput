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
                     <h3 class="card-title">Pengelolahan Data Paslon</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah data Paslon</button>
                     <!-- <button type="button" class="btn btn-info toastrDefaultInfo">
                        Launch Info Toast
                     </button> -->
                     <!-- Modal Tambah -->
                     <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <form method="POST" action="<?= base_url('paslon/create') ?>" enctype="multipart/form-data">
                                 <?= csrf_field(); ?>
                                 <div class="modal-header bg-primary">
                                    <h5 class="modal-title font-weight-bold" id="addModalLabel">Form tambah data Paslon</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>

                                 <div class="modal-body">
                                    <div class="form-group">
                                       <label for="no_urut" class="col-form-label">No Urut: </label>
                                       <select name="no_urut" class="custom-select <?= ($validation->hasError('no_urut')) ? 'is-invalid' : ''; ?>" id="no_urut">
                                          <option value="">-- Pilih No--</option>
                                          <?php
                                          for ($i = 1; $i <= 10; $i++) { ?>
                                             <option value="No Urut <?= $i; ?>"> No Urut <?= $i; ?></option>
                                          <?php } ?>
                                       </select>
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('no_urut'); ?></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="nama_calon" class="col-form-label">Nama Calon: </label>
                                       <input type="text" name="nama_calon" class="form-control  <?= ($validation->hasError('nama_calon')) ? 'is-invalid' : ''; ?>" value="<?= old('nama_calon'); ?>" placeholder="nama calon" id="nama_calon">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('nama_calon'); ?></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="nama_wakil_calon" class="col-form-label">Nama Wakil Calon: </label>
                                       <input type="text" name="nama_wakil_calon" class="form-control  <?= ($validation->hasError('nama_wakil_calon')) ? 'is-invalid' : ''; ?>" value="<?= old('nama_wakil_calon'); ?>" placeholder="nama wakil calon" id="nama_wakil_calon">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('nama_wakil_calon'); ?></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="foto" class="col-form-label">Foto paslon: </label>
                                       <div class="custom-file">
                                          <input type="file" class="custom-file-input <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?>" id="foto" name="foto[]" value="<?= old('foto'); ?>">
                                          <label class="custom-file-label" for="foto">Choose file</label>
                                       </div>
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('foto'); ?></span>
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
                     <div class="row">
                        <?php foreach ($paslon as $p) : ?>


                           <div class="col-xl-3 col-md-4 col-sm-2 align-items-stretch">
                              <div class="card bg-light">
                                 <div class="card-header border-bottom-0 text-center">
                                    <h2 class="font-weight-bold"><?= $p['no_urut']; ?></h2>
                                 </div>
                                 <div class="card-body pt-0">
                                    <div class="row">
                                       <div class="col-12 text-center p-3">
                                          <img src="<?= base_url('assets/users/paslon/' . $p['image']); ?>" alt="<?= $p['image']; ?>" class="img-circle img-fluid img-thumbnail" style="width: 120px; height: 120px;">
                                       </div>
                                       <div class="col-12 text-center">
                                          <h2 class="lead"><b><?= $p['nama_calon']; ?></b></h2>
                                          <h2 class="lead"><b><?= $p['nama_wakil_calon']; ?></b></h2>
                                          <p class="text-muted text-sm"><b>Jumlah suara : 500 </b> </p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="card-footer">
                                    <div class="row">
                                       <div class="col-6">

                                          <button type="button" class="btn btn-info w-100" data-toggle="modal" data-target="#editModal<?= $p['id']; ?>">Edit</button>
                                          <!-- Modal Tambah -->
                                          <div class="modal fade" id="editModal<?= $p['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                   <form method="POST" action="<?= base_url('paslon/update') ?>" enctype="multipart/form-data">
                                                      <input type="hidden" name="id" id="id" value="<?= $p['id']; ?>">
                                                      <?= csrf_field(); ?>
                                                      <div class="modal-header bg-primary">
                                                         <h5 class="modal-title font-weight-bold" id="editModalLabel">Form Edit data Paslon</h5>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                         </button>
                                                      </div>

                                                      <div class="modal-body">
                                                         <div class="form-group">
                                                            <label for="no_urut" class="col-form-label">No Urut: </label>
                                                            <select name="no_urut" class="custom-select <?= ($validation->hasError('no_urut')) ? 'is-invalid' : ''; ?>" id="no_urut">
                                                               <option value="">-- Pilih No--</option>
                                                               <?php
                                                               for ($i = 1; $i <= 10; $i++) { ?>
                                                                  <option value="No Urut <?= $i; ?>" <?= ($p['no_urut'] == 'No Urut ' . $i) ? 'selected' : ''; ?>> No Urut <?= $i; ?></option>
                                                               <?php } ?>
                                                            </select>
                                                            <div class="invalid-feedback pl-4">
                                                               <span class="text-danger"><?= $validation->getError('no_urut'); ?></span>
                                                            </div>
                                                         </div>
                                                         <div class="form-group">
                                                            <label for="nama_calon" class="col-form-label">Nama Calon: </label>
                                                            <input type="text" name="nama_calon" class="form-control  <?= ($validation->hasError('nama_calon')) ? 'is-invalid' : ''; ?>" value="<?= $p['nama_calon']; ?>" placeholder="nama calon" id="nama_calon">
                                                            <div class="invalid-feedback pl-4">
                                                               <span class="text-danger"><?= $validation->getError('nama_calon'); ?></span>
                                                            </div>
                                                         </div>
                                                         <div class="form-group">
                                                            <label for="nama_wakil_calon" class="col-form-label">Nama Wakil Calon: </label>
                                                            <input type="text" name="nama_wakil_calon" class="form-control  <?= ($validation->hasError('nama_wakil_calon')) ? 'is-invalid' : ''; ?>" value="<?= $p['nama_wakil_calon']; ?>" placeholder="nama wakil calon" id="nama_wakil_calon">
                                                            <div class="invalid-feedback pl-4">
                                                               <span class="text-danger"><?= $validation->getError('nama_wakil_calon'); ?></span>
                                                            </div>
                                                         </div>
                                                         <div class="form-group">
                                                            <label for="foto" class="col-form-label">Foto paslon: </label>
                                                            <div class="row">
                                                               <div class="col-3">
                                                                  <img src="<?= base_url('assets/users/paslon/' . $p['image']); ?>" alt="" srcset="" class="img-thumbnail">
                                                               </div>
                                                               <div class="col-9">
                                                                  <div class="custom-file">
                                                                     <input type="file" class="custom-file-input <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?>" id="foto" name="foto[]" value="<?= $p['image']; ?>">
                                                                     <label class="custom-file-label" for="foto">Choose file</label>
                                                                  </div>
                                                                  <div class="invalid-feedback pl-4">
                                                                     <span class="text-danger"><?= $validation->getError('foto'); ?></span>
                                                                  </div>
                                                               </div>
                                                            </div>

                                                         </div>
                                                         <div class="custom-control custom-checkbox">
                                                            <input name="is_active" type="checkbox" class="custom-control-input" id="is_active" checked="checked">
                                                            <label class="custom-control-label" for="is_active">Active</label>
                                                         </div>
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                         <button type="submit" class="btn btn-primary">Update</button>
                                                      </div>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>

                                       </div>
                                       <div class="col-6">
                                          <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#deleteModal<?= $p['id'] ?>">Delete</button>
                                          <!-- Modal -->
                                          <div class="modal fade bd-example-modal-sm" id="deleteModal<?= $p['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                   <form action="<?= base_url('/paslon/delete'); ?>" method="POST">
                                                      <input type="hidden" name="id" id="id" value="<?= $p['id']; ?>">
                                                      <input type="hidden" name="no_urut" id="no_urut" value="<?= $p['no_urut']; ?>">
                                                      <div class="modal-header bg-danger">
                                                         <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus data paslon</h5>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <p>Anda yakin akan menghapus data paslon <b><?= $p['no_urut']; ?></b> ?</p>
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                                                         <button type="submit" class="btn btn-danger">Hapus Paslon</button>
                                                      </div>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        <?php endforeach; ?>
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
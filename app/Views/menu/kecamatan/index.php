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
            <div class="col-sm-12 col-md-6 col-lg-6">
               <div class="card card-primary card-outline">
                  <div class="card-header">
                     <h3 class="card-title">Pengelolahan Data Kecamatan</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah data Kecamatan</button>

                     <!-- Modal Tambah -->
                     <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <form action="<?= base_url('/kecamatan/create'); ?>" method="POST">
                                 <?= csrf_field(); ?>
                                 <div class="modal-header bg-primary">
                                    <h5 class="modal-title font-weight-bold" id="addModalLabel">Form tambah data Kecamatan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>

                                 <div class="modal-body">
                                    <div class="form-group">
                                       <label for="kecamatan" class="col-form-label">contoh 'Kecamatan ABC'</label>
                                       <input type="text" name="kecamatan" class="form-control  <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" value="<?= old('kecamatan'); ?>" placeholder="nama kecamatan" id="kecamatan">
                                       <div class="invalid-feedback pl-4">
                                          <span class="text-danger"><?= $validation->getError('kecamatan'); ?></span>
                                       </div>
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
                              <th>Nama Kecamatan</th>
                              <th>Jumlah Kelurahan</th>
                              <th class="text-right">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1 + (5 * ($currentPage - 1));
                           foreach ($kecamatan as $k) : ?>
                              <tr>
                                 <td><?= $no++; ?></td>
                                 <td><?= $k['kecamatan']; ?></td>
                                 <td>
                                    <?php
                                    $i = 0;
                                    foreach ($kelurahan as $kl) {
                                       if ($kl['kecamatan_id'] == $k['id']) {
                                          $i++;
                                       }
                                    }
                                    echo $i;
                                    ?>
                                 </td>
                                 <td class="float-right">
                                    <a href="<?= base_url('kecamatan/' . encrypt_url($k['id'])) . '/edit'; ?>" class="btn btn-outline-info"><i class="fas fa-edit"></i></a>

                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal<?= $k['id'] ?>"><i class="fas fa-trash"></i></button>
                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-sm" id="deleteModal<?= $k['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                             <form action="<?= base_url('/kecamatan/delete'); ?>" method="POST">
                                                <input type="hidden" name="id" id="id" value="<?= $k['id']; ?>">
                                                <input type="hidden" name="kecamatan" id="kecamatan" value="<?= $k['kecamatan']; ?>">
                                                <div class="modal-header bg-danger">
                                                   <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus data kecamatan</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                   </button>
                                                </div>
                                                <div class="modal-body">
                                                   <p>Anda yakin akan menghapus data <b><?= $k['kecamatan']; ?></b> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                                                   <button type="submit" class="btn btn-danger">Hapus Kecamatan</button>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                     <div class="card-footer clearfix">
                        <?= $pager->links('tbl_kecamatan', 'kecamatan_pagination'); ?>
                     </div>
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
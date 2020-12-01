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
            <div class="col-sm-12 col-md-12 col-lg-12">
               <div class="card card-primary card-outline">
                  <div class="card-header">
                     <h3 class="card-title">Pilih Data Kelurahan perkecamatan</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <form action="" method="GET">
                        <select name="kecamatan" class="w-25 custom-select" id="kecamatan">
                           <option value="">-- Pilih Kecamatan --</option>
                           <?php foreach ($kecamatan as $k) : ?>
                              <option value="<?= $k['id']; ?>"><?= $k['kecamatan'] ?></option>
                           <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Lihat</button>
                        <a href="<?= base_url('/kelurahan'); ?>" class="btn btn-secondary">Reset</a>
                     </form>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>




   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
               <div class="card card-primary card-outline">
                  <div class="card-header">
                     <h3 class="card-title">Seluruh data Kelurahan <?= (!empty($kecamatanById)) ? ' di ' . $kecamatanById['kecamatan'] : ''; ?></h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>

                     <?php if (!empty($kecamatanById)) : ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah data Kelurahan <?= (!empty($kecamatanById)) ? ' di ' . $kecamatanById['kecamatan'] : ''; ?></button>
                     <?php else : ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah data Kelurahan</button>
                     <?php endif; ?>
                     <hr>
                     <!-- Table Data -->
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th style="width: 10px">#</th>
                              <th>Nama Kelurahan</th>
                              <th>Nama Kecamatan</th>
                              <th>Jumlah TPS</th>
                              <th>Total Penduduk</th>
                              <th class="text-right">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1 + (10 * ($currentPage - 1));
                           foreach ($kelurahan as $k) : ?>
                              <tr>
                                 <td><?= $no++; ?></td>
                                 <td><?= $k['kelurahan']; ?></td>
                                 <td>
                                    <?php
                                    //nama kecamatan berdasarkan kelurahan
                                    foreach ($kecamatan as $kc) {
                                       if ($kc['id'] == $k['kecamatan_id']) {
                                          echo $kc['kecamatan'];
                                          break;
                                       }
                                    }
                                    ?>
                                 </td>
                                 <td>
                                    <?php

                                    //result jumlah tps per kelurahan
                                    $result = $db->table('tbl_tps')->where(['kelurahan_id' => $k['id']])->get()->getResultArray();
                                    echo count(array_column($result, 'tps'));

                                    ?>
                                 </td>
                                 <td>
                                    <?= $k['total']; ?>
                                 </td>
                                 <td class="float-right">
                                    <a href="<?= base_url('kelurahan/' . encrypt_url($k['id'])) . '/edit'; ?>" class="btn btn-outline-info"><i class="fas fa-edit"></i></a>

                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal<?= $k['id'] ?>"><i class="fas fa-trash"></i></button>
                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-sm" id="deleteModal<?= $k['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                             <form action="<?= base_url('/kelurahan/delete'); ?>" method="POST">
                                                <input type="hidden" name="id" id="id" value="<?= $k['id']; ?>">
                                                <input type="hidden" name="kelurahan" id="kelurahan" value="<?= $k['kelurahan']; ?>">
                                                <div class="modal-header bg-danger">
                                                   <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus data kelurahan</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                   </button>
                                                </div>
                                                <div class="modal-body">
                                                   <p>Anda yakin akan menghapus data <b><?= $k['kelurahan']; ?></b> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                                                   <button type="submit" class="btn btn-danger">Hapus Kelurahan</button>
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
                        <?= $pager->links('tbl_kelurahan', 'kelurahan_pagination'); ?>
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
<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="<?= base_url('/kelurahan/create'); ?>" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-header bg-primary">
               <h5 class="modal-title font-weight-bold" id="addModalLabel">Form tambah data Kelurahan <?= (!empty($kecamatanById)) ? ' di ' . $kecamatanById['kecamatan'] : ''; ?></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>

            <div class="modal-body">
               <div class="form-group">
                  <?php if (!empty($kecamatanById)) : ?>
                     <label for="kecamatan" class="col-form-label">Nama Kecamatan</label>
                     <div class="form-control border-0"><?= $kecamatanById['kecamatan']; ?></div>
                     <input type="hidden" name="kecamatan" id="kecamatan" value="<?= $kecamatanById['id']; ?>">
                     <input type="hidden" name="kecamatanById" id="kecamatan" value="<?= $kecamatanById['id']; ?>">
                  <?php else : ?>
                     <label for="kecamatan" class="col-form-label">Pilih Kecamatan</label>
                     <select name="kecamatan" class="custom-select <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" id="kecamatan">
                        <option value="">-- Pilih Kecamatan --</option>
                        <?php foreach ($kecamatan as $k) : ?>
                           <option value="<?= $k['id']; ?>"><?= $k['kecamatan'] ?></option>
                        <?php endforeach; ?>
                     </select>
                  <?php endif; ?>

               </div>
               <div class="form-group">
                  <label for="kelurahan" class="col-form-label">Nama Kelurahan</label>
                  <input type="text" name="kelurahan" class="form-control  <?= ($validation->hasError('kelurahan')) ? 'is-invalid' : ''; ?>" value="<?= old('kelurahan'); ?>" placeholder="contoh 'kelurahan ABC'" id="kelurahan">
                  <div class="invalid-feedback pl-4">
                     <span class="text-danger"><?= $validation->getError('kelurahan'); ?></span>
                  </div>
               </div>
               <div class="form-group">
                  <label for="total" class="col-form-label">Total Penduduk</label>
                  <input type="text" name="total" class="form-control  <?= ($validation->hasError('total')) ? 'is-invalid' : ''; ?>" value="<?= old('total'); ?>" placeholder="total penduduk" id="total">
                  <div class="invalid-feedback pl-4">
                     <span class="text-danger"><?= $validation->getError('total'); ?></span>
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
<?= $this->endSection(); ?>
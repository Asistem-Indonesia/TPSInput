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
                     <h3 class="card-title">Pilih Data TPS perKelurahan</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <form action="" method="GET">
                        <input type="text" name="search" id="search" class="w-25 form-control float-left mr-2" placeholder="Nama Kelurahan">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="<?= base_url('/tps'); ?>" class="btn btn-secondary">Reset</a>
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
                     <h3 class="card-title">Seluruh data TPS <?= (!empty($kelurahanByid)) ? ' di ' . $kelurahanByid['kelurahan'] : ''; ?></h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <?php if (session()->getFlashdata('pesan')) : ?>
                        <?= session()->getFlashdata('pesan'); ?>
                     <?php endif; ?>

                     <?php if (!empty($kelurahanByid)) : ?>
                        <a href="<?= base_url('tps/create?kecamatan=' . $kelurahanByid['kecamatan_id']); ?>" class="btn btn-primary">Tambah data TPS <?= (!empty($kelurahanByid)) ? ' di ' . $kelurahanByid['kelurahan'] : ''; ?></a>
                     <?php else : ?>
                        <a href="<?= base_url('tps/create'); ?>" class="btn btn-primary">Tambah data TPS</a>
                     <?php endif; ?>
                     <hr>
                     <!-- Table Data -->
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th style="width: 10px">#</th>
                              <th>Nama TPS</th>
                              <th>Nama Kelurahan</th>
                              <th>Jumlah Suara</th>
                              <th class="text-right">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1 + (10 * ($currentPage - 1));
                           foreach ($tps as $tps) : ?>
                              <tr>
                                 <td><?= $no++; ?></td>
                                 <td><?= $tps['tps']; ?></td>
                                 <td>
                                    <?php
                                    foreach ($kelurahan as $kl) {
                                       if ($kl['id'] == $tps['kelurahan_id']) {
                                          echo $kl['kelurahan'];
                                          break;
                                       }
                                    }
                                    ?>
                                 </td>
                                 <td>0</td>
                                 <td class="float-right">
                                    <a href="<?= base_url('tps/' . encrypt_url($tps['id'])) . '/edit'; ?>" class="btn btn-outline-info"><i class="fas fa-edit"></i></a>

                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal<?= $tps['id'] ?>"><i class="fas fa-trash"></i></button>
                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-sm" id="deleteModal<?= $tps['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                             <form action="<?= base_url('/tps/delete'); ?>" method="POST">
                                                <input type="hidden" name="id" id="id" value="<?= $tps['id']; ?>">
                                                <input type="hidden" name="tps" id="tps" value="<?= $tps['tps']; ?>">
                                                <div class="modal-header bg-danger">
                                                   <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus data TPS</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                   </button>
                                                </div>
                                                <div class="modal-body">
                                                   <p>Anda yakin akan menghapus data <b><?= $tps['tps']; ?></b> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                                                   <button type="submit" class="btn btn-danger">Hapus TPS</button>
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
<?= $this->endSection(); ?>
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
            <div class="col-6">
               <!-- Default box -->
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Laporan</h3>

                     <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                           <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                           <i class="fas fa-times"></i>
                        </button>
                     </div>
                  </div>
                  <div class="card-body">
                     <a href="<?= base_url('cetak/excel'); ?>" class="btn btn-primary">Cetak Excel <i class="fas fa-print"></i></a>


                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">

                  </div>
                  <!-- /.card-footer-->
               </div>
               <!-- /.card -->
            </div>
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>
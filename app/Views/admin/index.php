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
            <?php
            $db
            ?>
            <?php foreach ($menuMenu as $m) : ?>


               <div class="col-lg-2 col-md-4 col-sm-12">
                  <a href="<?= base_url('/' . $m['url']); ?>">
                     <div class="card p-2" style="height: 180px;">
                        <div class="card-body text-center text-secondary">
                           <div class="row">
                              <div class="col-12 mb-3">

                                 <i class="<?= $m['icon']; ?> fa-4x"></i>
                              </div>
                              <div class="col-12">
                                 <h4><?= $m['submenu']; ?></h4>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            <?php endforeach; ?>
            <!-- /.card -->
         </div>
      </div>

   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>
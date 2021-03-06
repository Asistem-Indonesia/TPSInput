<?php


$db = db_connect();

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?= $title; ?></title>
   <link rel="icon" href="<?= base_url() ?>/favicon.gif" type="image/gif">

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
   <!-- overlayScrollbars -->
   <link rel="stylesheet" href="<?= base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
   <!-- IonIcons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">

   <!-- Toastr -->
   <link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.min.css'); ?>">
   <!-- Theme style -->
   <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
   <!-- Site wrapper -->
   <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
         <!-- Left navbar links -->
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
         </ul>
         <!-- Right navbar links -->
         <ul class="navbar-nav ml-auto">
            <li class="nav-item">
               <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?= base_url('/logout'); ?>">
                  <span> <i class="fas fa-sign-out-alt"></i> Logout</span>
               </a>
            </li>
         </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
         <!-- Brand Logo -->
         <a class="brand-link">
            <img src="<?= base_url('assets/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: .8">
            <span class="brand-text font-weight-light font-weight-bold">Aplikasi TPS <small class="font-weight-light">(Beta)</small></span>
         </a>

         <!-- Sidebar -->
         <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
                  <img src="<?= base_url('assets/users/' . $user['image']); ?>" class="img-circle elevation-2" alt="User Image">
               </div>
               <div class="info">
                  <a href="#" class="d-block text-capitalize"><?= $user['nama']; ?></a>
               </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
               <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                     <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                     </button>
                  </div>
               </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <?php
                  $menu = $db->table('tbl_user_access_menu')->join('tbl_menu', 'tbl_menu.id = tbl_user_access_menu.menu_id')
                     ->where(['tbl_user_access_menu.role_id' => session()->get('role_id')])->get()->getResultArray();

                  foreach ($menu as $m) : ?>
                     <li class="nav-header"><?= $m['menu']; ?></li>
                     <?php

                     $subMenu = $db->table('tbl_sub_menu')->where(['menu_id' => $m['id']])->get()->getResultArray();
                     foreach ($subMenu as $sm) : ?>
                        <li class="nav-item">
                           <a href="<?= base_url($sm['url']); ?>" class="nav-link  <?= ($sm['submenu'] == $titleMenu) ? 'active' : ''; ?>">
                              <i class="nav-icon fas <?= $sm['icon']; ?>"></i>
                              <p>
                                 <?= $sm['submenu']; ?>
                              </p>
                           </a>
                        </li>
                     <?php endforeach; ?>
                  <?php endforeach; ?>
                  <?php if ($user['role_id'] != 1) : ?>
                     <li class="nav-header">Input Data</li>
                  <?php endif; ?>
                  <?php
                  $resultsKel = $db->table('tbl_kelurahan')->orderBy('kelurahan', 'ASC')->where(['kecamatan_id' => $user['kecamatan_id']])->get()->getResultArray();
                  foreach ($resultsKel as $kl) : ?>

                     <li class="nav-item">
                        <a href="<?= base_url('/inputdata/' . $kl['id']); ?>" class="nav-link">
                           <i class="nav-icon fas fa-edit"></i>
                           <p> <?= $kl['kelurahan']; ?></p>
                        </a>
                     </li>



                  <?php endforeach; ?>











                  <li class="nav-header">Semua Kecamatan</li>
                  <?php
                  $resultsKec = $db->table('tbl_kecamatan')->orderBy('kecamatan', 'ASC')->get()->getResultArray();
                  foreach ($resultsKec as $kc) : ?>
                     <?php
                     $resultsKel = $db->table('tbl_kelurahan')->orderBy('kelurahan', 'ASC')->getWhere(['kecamatan_id' => $kc['id']])->getResultArray();
                     if ($resultsKel != null) : ?>
                        <li class="nav-item">
                           <a href="#" class="nav-link">
                              <i class="nav-icon fas fa-folder"></i>
                              <p> <?= $kc['kecamatan']; ?> <i class="fas fa-angle-left right"></i></p>
                           </a>


                        <?php endif; ?>
                        <?php
                        foreach ($resultsKel as $kl) : ?>
                           <ul class="nav nav-treeview">
                              <li class="nav-item pl-2">
                                 <a href="<?= base_url('/inputdata/' . $kl['id']) ?>" class="nav-link <?= ($titleMenu == $kl['kelurahan']) ? 'active' : ''; ?>">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p><?= $kl['kelurahan']; ?></p>
                                 </a>
                              </li>
                           </ul>
                        <?php endforeach; ?>
                        </li>
                     <?php endforeach; ?>

               </ul>
            </nav>
            <!-- /.sidebar-menu -->
         </div>
         <!-- /.sidebar -->
      </aside>

      <?= $this->renderSection('app_content'); ?>

      <footer class="main-footer">
         <div class="float-right d-none d-sm-block">
            <b>Version</b>(Beta)
         </div>
         <strong>Copyright &copy; 2020 Aplikasi TPS.</strong> All rights reserved.
      </footer>

      <div class="modal fade" id="modal-overlay">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="overlay d-flex justify-content-center align-items-center">
                  <i class="fas fa-2x fa-sync fa-spin"></i>
               </div>
               <div class="modal-header">
                  <h4 class="modal-title">Default Modal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <p>One fine body&hellip;</p>
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
         <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
   </div>
   <!-- ./wrapper -->



   <!-- jQuery -->
   <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
   <!-- Bootstrap 4 -->
   <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
   <!-- overlayScrollbars -->
   <script src="<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
   <!-- SweetAlert2 -->
   <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
   <!-- Toastr -->
   <script src="<?= base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
   <!-- AdminLTE App -->
   <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
   <!-- OPTIONAL SCRIPTS -->
   <script src="<?= base_url('assets/plugins/chart.js/Chart.min.js'); ?>"></script>


   <!-- AdminLTE for demo purposes -->
   <script src="<?= base_url('assets/dist/js/demo.js'); ?>"></script>
   <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
   <script src="<?= base_url('assets/dist/js/pages/dashboard3.js'); ?>"></script>

   <script>
      //images
      $('.custom-file-input').on('change', function() {
         let fileName = $(this).val().split('\\').pop();
         $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });


      $('.custom-control-input').on('click', function() {
         const menuId = $(this).data('menu');
         const roleId = $(this).data('role');

         $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
               menuId: menuId,
               roleId: roleId
            },
            success: function() {
               document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
         });
      });
   </script>

</body>

</html>
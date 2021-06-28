<!DOCTYPE html>
<html lang="en">

<?= $this->include('layout/header') ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src=<?= base_url('assets/dist/img/AdminLTELogo.png') ?> alt="AdminLTELogo" height="60" width="60">
  </div>
  <?= $this->include('layout/navbar') ?>  
  <!-- Main Sidebar Container -->
  <?= $this->include('layout/sidebar') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
        
    <!-- Main content -->
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- small box -->
                <?php if($tittle != 'do'):?>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 class="text-center"><?php echo $jmldata ?></h3>
                            <p class="text-center">Jumlah Data</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 class="text-center"><?php echo $jmltrain ?></h3>
                            <p class="text-center">Jumlah Data Training</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="text-center"><?php echo $jmltest ?></h3>
                            <p class="text-center">Jumlah Data Test</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 class="text-center"><?php echo $positif ?> / <?php echo $negatif ?></h3>
                            <p class="text-center">Positif / Negatif</p>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <!-- end small box -->
            </div>

            <!-- content -->
            
            <?= $this->renderSection('content') ?>
            
            <!-- end content -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--footer class="main-footer">
    
  </footer-->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src=<?= base_url('assets/plugins/jquery/jquery.min.js') ?>></script>
<!-- jQuery UI 1.11.4 -->
<script src=<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src=<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>></script>
<!-- ChartJS -->
<script src=<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>></script>
<!-- Sparkline -->
<script src=<?= base_url('assets/plugins/sparklines/sparkline.js') ?>></script>
<!-- JQVMap -->
<script src=<?= base_url('assets/plugins/jqvmap/jquery.vmap.min.js') ?>></script>
<script src=<?= base_url('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') ?>></script>
<!-- jQuery Knob Chart -->
<script src=<?= base_url('assets/plugins/jquery-knob/jquery.knob.min.js') ?>></script>
<!-- daterangepicker -->
<script src=<?= base_url('assets/plugins/moment/moment.min.js') ?>></script>
<script src=<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src=<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>></script>
<!-- Summernote -->
<script src=<?= base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>></script>
<!-- overlayScrollbars -->
<script src=<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>></script>
<!-- AdminLTE App -->
<script src=<?= base_url('assets/dist/js/adminlte.js') ?>></script>
<!-- AdminLTE for demo purposes -->
<script src=<?= base_url('assets/dist/js/demo.js') ?>></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src=<?= base_url('assets/dist/js/pages/dashboard.js') ?>></script>
</body>
</html>

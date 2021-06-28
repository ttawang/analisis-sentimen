<aside class="main-sidebar sidebar-dark-primary elevation-4" style="weight=700px">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src=<?= base_url('assets/dist/img/AdminLTELogo.png') ?> alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Analisis Sentimen</span>
    </a>
    <!--?= base_url('') ?-->

    <!-- Sidebar -->
    <div class="sidebar">
    
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item mt-3">
            <a href=<?= base_url('/home') ?> class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Data Tweet</p>
            </a>
          </li>
          <li class="nav-item mt-3">
            <a href="<?= base_url('/training') ?>" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Data Training</p>
            </a>
          </li>
          <li class="nav-item mt-3">
            <a href=<?= base_url('/testing') ?> class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Data Testing</p>
            </a>
          </li>
          <li class="nav-item mt-3">
            <a href=<?= base_url('/preprocessing') ?> class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Data Prepocessing</p>
            </a>
          </li>
          <li class="nav-item mt-3">
          <?php foreach($k as $b):?>
              <a href=<?= base_url('k/'.$b['id']) ?> class="nav-link"> 
              <i class="far fa-circle nav-icon"></i>
              <p>Klasifikasi</p>
              </a>
          <?php endforeach ?>
          </li>
          <li class="nav-item mt-3">
            <a href="<?= base_url(); ?>/logout" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #5a5c69;">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text" style="font-size: 12px;">PhD-DsC Hisobot Platformasi</div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= $this->base_url('user/dashboard') ?>">
          <i class="fas fa-fw fa-home"></i>
          <span>Bosh sahifa</span>
        </a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading"> MENYU </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'portfolio') !== false) ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Tizim</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Komponentlar:</h6>
            <a class="collapse-item" href="<?= $this->base_url('user/portfolio') ?>">Portfolio</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Chat -->
      <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'chat') !== false) ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= $this->base_url('user/chat') ?>">
          <i class="fas fa-fw fa-comments"></i>
          <span>Admin bilan chat</span>
          <!-- Bildirishnoma sonini ko'rsatish -->
          <span class="badge badge-danger badge-counter float-center" style="position: relative; float: right; left: -10px; top: 10px;">
            <?= $notificationsCount; ?>
          </span>
        </a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->

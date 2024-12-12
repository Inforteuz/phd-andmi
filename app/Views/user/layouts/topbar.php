<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Dropdown - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger badge-counter"><?= count($userEvents) ?></span>
                    </a>
                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header"> Bildirishnomalar </h6>
                        <?php foreach ($userEvents as $event): ?>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle <?= $event['user_id'] === $_SESSION['user_id'] ? 'bg-primary' : 'bg-secondary' ?>">
                                        <i class="fas <?= $event['user_id'] === $_SESSION['user_id'] ? 'fa-user' : 'fa-calendar' ?> text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500"><?= date('d-m-Y H:i', strtotime($event['event_date'])) ?></div>
                                    <span class="<?= $event['user_id'] === $_SESSION['user_id'] ? 'font-weight-bold text-primary' : '' ?>">
                                        <?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                        <?php if (empty($userEvents)): ?>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Bildirishnomalar yo'q</a>
                        <?php endif; ?>
                    </div>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['fullname'] ?? 'undefined' ?><br><?= $_SESSION['degree'] ?? 'undefined' ?></span>
                        <img class="img-profile rounded-circle" src="<?= $this->base_url($image_url); ?>">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="login_history">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Kirish tarixi
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Chiqish
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->

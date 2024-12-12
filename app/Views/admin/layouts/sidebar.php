
<body id="page-top">
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

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>

            <!-- Sidebar Navigation -->
            <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= $this->base_url('admin/dashboard'); ?>">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Bosh sahifa</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'add_events') !== false) ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= $this->base_url('admin/add_events'); ?>">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Taqvim</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'activity_documents') !== false || 
                                    strpos($_SERVER['REQUEST_URI'], 'guide_documents') !== false || 
                                    strpos($_SERVER['REQUEST_URI'], 'article_documents') !== false ||
                                    strpos($_SERVER['REQUEST_URI'], 'patent_documents') !== false ||
                                    strpos($_SERVER['REQUEST_URI'], 'textbook_documents') !== false ||
                                    strpos($_SERVER['REQUEST_URI'], 'language_documents') !== false) ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDocuments" aria-expanded="true" aria-controls="collapseDocuments">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Kelib tushgan hujjatlar</span>
                </a>
               <div id="collapseDocuments" class="collapse" aria-labelledby="headingDocuments" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Hujjatlar turlari:</h6>
                        <a class="collapse-item <?= (strpos($_SERVER['REQUEST_URI'], 'activity_documents') !== false) ? 'active' : ''; ?>" href="<?= $this->base_url('admin/activity_documents'); ?>">Faoliyat 
                            <span style="float: right;" class="badge badge-pill badge-danger"><?= $documentCounts['faoliyat'] ?></span>
                        </a>
                        <a class="collapse-item <?= (strpos($_SERVER['REQUEST_URI'], 'guide_documents') !== false) ? 'active' : ''; ?>" href="<?= $this->base_url('admin/guide_documents'); ?>">Mundarija 
                            <span style="float: right;" class="badge badge-pill badge-danger"><?= $documentCounts['mundarija'] ?></span>
                        </a>
                        <a class="collapse-item <?= (strpos($_SERVER['REQUEST_URI'], 'article_documents') !== false) ? 'active' : ''; ?>" href="<?= $this->base_url('admin/article_documents'); ?>">Maqolalar 
                            <span style="float: right;" class="badge badge-pill badge-danger"><?= $documentCounts['maqola'] ?></span>
                        </a>
                        <a class="collapse-item <?= (strpos($_SERVER['REQUEST_URI'], 'patent_documents') !== false) ? 'active' : ''; ?>" href="<?= $this->base_url('admin/patent_documents'); ?>">Patent 
                            <span style="float: right;" class="badge badge-pill badge-danger"><?= $documentCounts['patents'] ?></span>
                        </a>
                        <a class="collapse-item <?= (strpos($_SERVER['REQUEST_URI'], 'textbook_documents') !== false) ? 'active' : ''; ?>" href="<?= $this->base_url('admin/textbook_documents'); ?>">Darslik 
                            <span style="float: right;" class="badge badge-pill badge-danger"><?= $documentCounts['works'] ?></span>
                        </a>
                        <a class="collapse-item <?= (strpos($_SERVER['REQUEST_URI'], 'language_documents') !== false) ? 'active' : ''; ?>" href="<?= $this->base_url('admin/language_documents'); ?>">Til 
                            <span style="float: right;" class="badge badge-pill badge-danger"><?= $documentCounts['certificates'] ?></span>
                        </a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'users_management') !== false) ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= $this->base_url('admin/users_management'); ?>">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Foydalanuvchilarni boshqarish</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], 'chat_with_users') !== false) ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= $this->base_url('admin/chat_with_users'); ?>">
                    <i class="fas fa-comments"></i>
                    <span>Foydalanuvchilar<br> bilan chat</span>
                    <span class="badge badge-danger badge-counter float-center" style="position: relative; float: right; left: -10px; top: 7px;"><?= $notificationsCount; ?></span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

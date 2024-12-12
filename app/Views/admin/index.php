<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Bosh sahifa</h1>
    <div class="row">
        <!-- Card for Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Sayt foydalanuvchilari
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalUsers ?> ta</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Total Uploaded Files -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Yuklangan fayllar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $uploadedFiles ?> ta</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-upload fa-2x text-success"></i> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Files Under Review -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tekshiruvdagi fayllar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= array_sum($statusCounts['kutilmoqda']) ?> ta</div> 
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-spin fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Approved Files -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tasdiqlangan fayllar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= array_sum($statusCounts['tasdiqlandi']) ?> ta</div> 
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Rejected Files -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rad etilgan fayllar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= array_sum($statusCounts['raddetildi']) ?> ta</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-danger"></i> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End Page Content -->
<?php include 'layouts/footer.php'; ?>
<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/scripts.php'; ?>

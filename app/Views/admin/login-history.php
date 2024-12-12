<?php

require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kirish tarixi</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Login History Table -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Kirish Tarixi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="historyTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">#</th>
                                    <th>FIO</th>
                                    <th>IP Manzil</th>
                                    <th>Login</th>
                                    <th>Status</th>
                                    <th>Yaratilgan sana</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($login_history) && !empty($login_history)): ?>
                                    <?php $counter = 1; ?>
                                    <?php foreach ($login_history as $login): ?>
                                        <tr>
                                            <td><?= $counter++ ?></td>
                                            <td><?= htmlspecialchars($login['fullname']) ?></td>
                                            <td><?= htmlspecialchars($login['ip_address']) ?></td>
                                            <td><?= htmlspecialchars($login['login']) ?></td>
                                            <td>
                                                <?php 
                                                    if ($login['status'] === 'success') {
                                                        echo '<span class="text-success">Muvaffaqiyatli</span>';
                                                    } else {
                                                        echo '<span class="text-danger">Muvaffaqiyatsiz</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($login['created_at']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Kirish tarixi mavjud emas.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->

<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/scripts.php'; ?>
</body>
</html>
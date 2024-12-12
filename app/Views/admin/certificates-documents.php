<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Til Jadvali -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="float-left">
                <h6 class="m-0 font-weight-bold text-primary">Til-sertifikatlari jadvali</h6>
            </div>
            <div class="float-right">
                <!-- Excelga eksport qilish tugmasi, icon bilan -->
                <button class="btn btn-success" id="exportTil">
                    <i class="fas fa-file-excel"></i> Excelga yuklash
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table id="tilTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Yuboruvchi</th>
                        <th>Til turi</th>
                        <th>Til</th>
                        <th>Daraja</th>
                        <th>Olingan sana</th>
                        <th>Til fayli</th>
                        <th>Status</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($certificates as $index => $certificate): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($certificate['user_login']) ?></td>
                            <td><?= htmlspecialchars($certificate['certificate_type']) ?></td>
                            <td><?= htmlspecialchars($certificate['language_name']) ?></td>
                            <td><?= htmlspecialchars($certificate['language_level']) ?></td>
                            <td><?= htmlspecialchars($certificate['certificate_date']) ?></td>
                           <td>
                                <a href="<?php echo htmlspecialchars(($protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $certificate['certificate_file']); ?>" class="btn btn-info btn-" download>
                                    <i class="fas fa-download"></i> <?php echo htmlspecialchars(basename($certificate['certificate_file'])); ?>
                                </a>
                            </td>
                            <td>
                                <span class="badge 
                                    <?php 
                                    if ($certificate['status'] == 'Rad etildi') {
                                        echo 'badge-danger';
                                    } elseif ($certificate['status'] == 'Tasdiqlandi') {
                                        echo 'badge-success';
                                    } else {
                                        echo 'badge-warning';
                                    }
                                    ?>">
                                    <?= htmlspecialchars($certificate['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($certificate['status'] == 'Kutilmoqda'): ?>
                                    <a href="#" class="btn btn-primary btn-circle approveBtn" id="approveBtn<?php echo $certificate['id']; ?>" data-id="<?php echo $certificate['id']; ?>">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle cancelBtn" id="cancelBtn<?php echo $certificate['id']; ?>" data-id="<?php echo $certificate['id']; ?>" data-toggle="modal" data-target="#cancelModal<?php echo $certificate['id']; ?>">
                                            <i class="fas fa-ban" title="Bekor qilish"></i>
                                        </a>
                                <?php elseif ($certificate['status'] == 'Rad etildi' || $certificate['status'] == 'Tasdiqlandi'): ?>
                                <a href="#" class="btn btn-danger btn-circle deleteBtn" data-id="<?php echo $certificate['id']; ?>" title="O'chirish">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Cancel Modal for each certificate -->
                        <div class="modal fade" id="cancelModal<?= $certificate['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel<?= $certificate['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelModalLabel<?= $certificate['id']; ?>">Bekor qilish</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="cancelReason<?= $certificate['id']; ?>">Sababini kiriting:</label>
                                            <textarea class="form-control" id="cancelReason<?= $certificate['id']; ?>" rows="5" placeholder="Bekor qilish sababini kiriting..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                                        <button type="button" class="btn btn-primary saveCancelReasonBtn" data-id="<?= $certificate['id']; ?>">Saqlash</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- End Page Content -->

<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/footer.php'; ?>
<?php include 'layouts/scripts.php'; ?>
<script>$(document).ready(function(){$('.cancelBtn').on('click',function(){var certificateId=$(this).data('id');$('#cancelModal'+certificateId).modal('show');});$('.saveCancelReasonBtn').on('click',function(){var certificateId=$(this).data('id');var reason=$('#cancelReason'+certificateId).val().trim();if(reason){$.ajax({url:'/admin/cancelSertifikatDocument',method:'POST',data:{certificate_id:certificateId,cancel_reason:reason},success:function(response){var result=JSON.parse(response);if(result.status==='success'){new Notyf().success(result.message);setTimeout(function(){location.reload();},1200);}else{new Notyf().error(result.message);}},error:function(xhr,status,error){console.error("AJAX xatolik:",error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});$('#cancelModal'+certificateId).modal('hide');}else{alert("Iltimos, sababni kiriting.");}});$('.approveBtn').on('click',function(){var certificateId=$(this).data('id');var confirmApprove=confirm("Chindan ham tasdiqlaysizmi?");if(confirmApprove){$.ajax({url:'/admin/approveSertifikatDocument',method:'POST',data:{certificate_id:certificateId},success:function(response){var result=JSON.parse(response);if(result.status==='success'){new Notyf().success(result.message);setTimeout(function(){location.reload();},1200);}else{new Notyf().error(result.message);}},error:function(xhr,status,error){console.error("AJAX xatolik:",error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('.deleteBtn').on('click',function(){var certificateId=$(this).data('id');var confirmDelete=confirm("Haqiqatan ham o'chirishni istaysizmi?");if(confirmDelete){$.ajax({url:'/admin/deleteSertifikatDocument',method:'POST',data:{certificate_id:certificateId},success:function(response){var result=JSON.parse(response);if(result.status==='success'){new Notyf().success(result.message);setTimeout(function(){location.reload();},1200);}else{new Notyf().error(result.message);}},error:function(xhr,status,error){console.error("AJAX xatolik:",error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('#tilTable').DataTable({"language":{"url":"/assets/vendor/json/uzbek.json"}});$('#exportTil').on('click',function(){window.location.href='/admin/export_certificates_to_excel';});});</script>
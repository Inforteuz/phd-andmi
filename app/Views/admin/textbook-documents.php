<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Ishlanmalar Jadvali -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="float-left">
                <h6 class="m-0 font-weight-bold text-primary">Ishlanmalar jadvali</h6>
            </div>
            <div class="float-right">
                <!-- Excelga eksport qilish tugmasi, icon bilan -->
                <button class="btn btn-success" id="exportIshlanma">
                    <i class="fas fa-file-excel"></i> Excelga yuklash
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table id="ishlanmaTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Yuboruvchi</th>
                        <th>Ishlanma turi</th>
                        <th>Nomi</th>
                        <th>Guvohnoma raqami</th>
                        <th>Sanasi</th>
                        <th>Mualliflar soni</th>
                        <th>Mualliflar</th>
                        <th>Ishlanma fayli</th>
                        <th>Status</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($works as $index => $work): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($work['user_login']) ?></td>
                            <td><?= htmlspecialchars($work['work_type']) ?></td>
                            <td><?= htmlspecialchars($work['work_name']) ?></td>
                            <td><?= htmlspecialchars($work['certificate_number']) ?></td>
                            <td><?= htmlspecialchars($work['work_date']) ?></td>
                            <td><?= (int)$work['author_count'] ?></td>
                            <td><?= htmlspecialchars($work['authors']) ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars(($protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $work['file_name']); ?>" class="btn btn-info btn-primary" download>
                                    <i class="fas fa-download"></i> <?= htmlspecialchars(basename($work['file_name'])) ?>
                                </a>
                            </td>
                            <td>
                                <span class="badge 
                                    <?php 
                                    if ($work['status'] == 'Rad etildi') {
                                        echo 'badge-danger';
                                    } elseif ($work['status'] == 'Tasdiqlandi') {
                                        echo 'badge-success';
                                    } else {
                                        echo 'badge-warning';
                                    }
                                    ?>">
                                    <?= htmlspecialchars($work['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($work['status'] == 'Kutilmoqda'): ?>
                                    <a href="#" class="btn btn-primary btn-circle approveBtn" id="approveIshlanma<?= $work['id']; ?>" data-id="<?= $work['id']; ?>">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle cancelBtn" id="cancelIshlanma<?= $work['id']; ?>" data-id="<?= $work['id']; ?>" data-toggle="modal" data-target="#cancelModal<?= $work['id']; ?>">
                                        <i class="fas fa-ban" title="Bekor qilish"></i>
                                    </a>
                                <?php elseif ($work['status'] == 'Rad etildi' || $work['status'] == 'Tasdiqlandi'): ?>
                                    <a href="#" class="btn btn-danger btn-circle deleteBtn" data-id="<?= $work['id']; ?>" title="O'chirish">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Cancel Modal for each work -->
                        <div class="modal fade" id="cancelModal<?= $work['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel<?= $work['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelModalLabel<?= $work['id']; ?>">Bekor qilish</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="cancelReason<?= $work['id']; ?>">Sababini kiriting:</label>
                                            <textarea class="form-control" id="cancelReason<?= $work['id']; ?>" rows="5" placeholder="Bekor qilish sababini kiriting..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                                        <button type="button" class="btn btn-primary saveCancelReasonBtn" data-id="<?= $work['id']; ?>">Saqlash</button>
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
<script>$(document).ready(function() {$('.cancelBtn').on('click', function() {var workId = $(this).data('id');$('#cancelModal' + workId).modal('show');});$('.saveCancelReasonBtn').on('click', function() {var workId = $(this).data('id');var reason = $('#cancelReason' + workId).val().trim();if (reason) {$.ajax({url: '/admin/cancelIshlanmaDocument',method: 'POST',data: {work_id: workId,cancel_reason: reason},success: function(response) {var result = JSON.parse(response);if (result.status === 'success') {new Notyf().success(result.message);setTimeout(function() {location.reload();}, 1200);} else {new Notyf().error(result.message);}},error: function(xhr, status, error) {console.error("AJAX xatolik:", error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});$('#cancelModal' + workId).modal('hide');} else {alert("Iltimos, sababni kiriting.");}});$('.approveBtn').on('click', function() {var workId = $(this).data('id');var confirmApprove = confirm("Chindan ham tasdiqlaysizmi?");if (confirmApprove) {$.ajax({url: '/admin/approveIshlanmaDocument',method: 'POST',data: {work_id: workId},success: function(response) {var result = JSON.parse(response);if (result.status === 'success') {new Notyf().success(result.message);setTimeout(function() {location.reload();}, 1200);} else {new Notyf().error(result.message);}},error: function(xhr, status, error) {console.error("AJAX xatolik:", error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('.deleteBtn').on('click', function() {var workId = $(this).data('id');var confirmDelete = confirm("Haqiqatan ham o'chirishni istaysizmi?");if (confirmDelete) {$.ajax({url: '/admin/deleteIshlanmaDocument',method: 'POST',data: {work_id: workId},success: function(response) {var result = JSON.parse(response);if (result.status === 'success') {new Notyf().success(result.message);setTimeout(function() {location.reload();}, 1200);} else {new Notyf().error(result.message);}},error: function(xhr, status, error) {console.error("AJAX xatolik:", error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('#ishlanmaTable').DataTable({"language": {"url": "/assets/vendor/json/uzbek.json"},"initComplete": function() {var api = this.api();api.columns().every(function() {var column = this;var columnTitle = $(column.header()).text();if (columnTitle !== 'Harakatlar' && columnTitle !== 'Ishlanma fayli') {var select = $('<select class="form-control select2"><option value="">' + columnTitle + '</option></select>').appendTo($(column.header()).empty()).on('change', function() {var val = $.fn.dataTable.util.escapeRegex($(this).val());column.search(val ? '^' + val + '$' : '', true, false).draw();});column.data().unique().sort().each(function(d, j) {var cleanValue = d.replace(/<[^>]*>/g, '').trim();select.append('<option value="' + cleanValue + '">' + cleanValue + '</option>');});select.select2({width: '100%',});}});}});$('#exportIshlanma').on('click', function() {window.location.href = '/admin/export_darslik_to_excel';});});</script>
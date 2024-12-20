<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Maqola Jadvali -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="float-left">
                <h6 class="m-0 font-weight-bold text-primary">Maqola jadvali</h6>
            </div>
            <div class="float-right">
                <button class="btn btn-success" id="exportMaqolalar">
                    <i class="fas fa-file-excel"></i> Excelga yuklash
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table id="articleTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Yuboruvchi</th>
                        <th>Jurnal turi</th>
                        <th>Nashr etilgan davlat nomi</th>
                        <th>Jurnal nomi</th>
                        <th>Maqola nomi</th>
                        <th>Nashr yili va oyi</th>
                        <th>Materialning internet havolasi</th>
                        <th>Mualliflar soni</th>
                        <th>Mualliflar</th>
                        <th>Maqola fayli</th>
                        <th>Status</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articleDocuments as $index => $document): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($document['user_login']) ?></td>
                            <td><?= htmlspecialchars($document['journalType']) ?></td>
                            <td><?= htmlspecialchars($document['publishCountry']) ?></td>
                            <td><?= htmlspecialchars($document['journalName']) ?></td>
                            <td><?= htmlspecialchars($document['articleTitle']) ?></td>
                            <td><?= htmlspecialchars($document['publishDate']) ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($document['articleLink']) ?>" target="_blank"><?= htmlspecialchars($document['articleLink']) ?></a>
                            </td>
                            <td><?= (int)$document['authorCount'] ?></td>
                            <td><?= htmlspecialchars($document['authors']) ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars(($protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $document['articleFile']); ?>" class="btn btn-info btn-" download>
                                    <i class="fas fa-download"></i> <?php echo htmlspecialchars(basename($document['articleFile'])); ?>
                                </a>
                            </td>
                            <td>
                                <span class="badge 
                                    <?php 
                                    if ($document['status'] == 'Rad etildi') {
                                        echo 'badge-danger';
                                    } elseif ($document['status'] == 'Tasdiqlandi') {
                                        echo 'badge-success';
                                    } else {
                                        echo 'badge-warning';
                                    }
                                    ?>">
                                    <?php echo htmlspecialchars($document['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($document['status'] == 'Kutilmoqda'): ?>
                                    <a href="#" class="btn btn-primary btn-circle approveBtn" id="approveBtn<?php echo $document['id']; ?>" data-id="<?php echo $document['id']; ?>">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle cancelBtn" id="cancelBtn<?php echo $document['id']; ?>" data-id="<?php echo $document['id']; ?>" data-toggle="modal" data-target="#cancelModal<?php echo $document['id']; ?>">
                                            <i class="fas fa-ban" title="Bekor qilish"></i>
                                        </a>
                                <?php elseif ($document['status'] == 'Rad etildi' || $document['status'] == 'Tasdiqlandi'): ?>
                                <a href="#" class="btn btn-danger btn-circle deleteBtn" data-id="<?php echo $document['id']; ?>" title="O'chirish">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Cancel Modal for each document -->
                        <div class="modal fade" id="cancelModal<?php echo $document['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel<?php echo $document['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelModalLabel<?php echo $document['id']; ?>">Bekor qilish</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="cancelReason<?php echo $document['id']; ?>">Sababini kiriting:</label>
                                            <textarea class="form-control" id="cancelReason<?php echo $document['id']; ?>" rows="5" placeholder="Bekor qilish sababini kiriting..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                                        <button type="button" class="btn btn-primary saveCancelReasonBtn" data-id="<?php echo $document['id']; ?>">Saqlash</button>
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
<script>$(document).ready(function() {$('.cancelBtn').on('click', function() {var documentId = $(this).data('id');$('#cancelModal' + documentId).modal('show');});$('.saveCancelReasonBtn').on('click', function() {var documentId = $(this).data('id');var reason = $('#cancelReason' + documentId).val().trim();if (reason) {$.ajax({url: '/admin/cancelArticleDocument', method: 'POST', data: {document_id: documentId, cancel_reason: reason}, success: function(response) {var result = JSON.parse(response);if (result.status === 'success') {new Notyf().success(result.message);setTimeout(function() {location.reload();}, 1200);} else {new Notyf().error(result.message);}}, error: function(xhr, status, error) {console.error("AJAX xatolik:", error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});$('#cancelModal' + documentId).modal('hide');} else {alert("Iltimos, sababni kiriting.");}});$('.approveBtn').on('click', function() {var documentId = $(this).data('id');var confirmApprove = confirm("Chindan ham tasdiqlaysizmi?");if (confirmApprove) {$.ajax({url: '/admin/approveArticleDocument', method: 'POST', data: {document_id: documentId}, success: function(response) {var result = JSON.parse(response);if (result.status === 'success') {new Notyf().success(result.message);setTimeout(function() {location.reload();}, 1200);} else {new Notyf().error(result.message);}}, error: function(xhr, status, error) {console.error("AJAX xatolik:", error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('.deleteBtn').on('click', function() {var documentId = $(this).data('id');var confirmDelete = confirm("Haqiqatan ham o'chirishni istaysizmi?");if (confirmDelete) {$.ajax({url: '/admin/deleteArticleDocument', method: 'POST', data: {document_id: documentId}, success: function(response) {var result = JSON.parse(response);if (result.status === 'success') {new Notyf().success(result.message);setTimeout(function() {location.reload();}, 1200);} else {new Notyf().error(result.message);}}, error: function(xhr, status, error) {console.error("AJAX xatolik:", error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('#articleTable').DataTable({"language": {"url": "/assets/vendor/json/uzbek.json"},"initComplete": function() {var api = this.api();api.columns().every(function() {var column = this;var columnTitle = $(column.header()).text();if (columnTitle !== 'Harakatlar' && columnTitle !== 'Maqola fayli') {var select = $('<select class="form-control select2"><option value="">' + columnTitle + '</option></select>').appendTo($(column.header()).empty()).on('change', function() {var val = $.fn.dataTable.util.escapeRegex($(this).val());column.search(val ? '^' + val + '$' : '', true, false).draw();});column.data().unique().sort().each(function(d, j) {var cleanValue = d.replace(/<[^>]*>/g, '').trim();select.append('<option value="' + cleanValue + '">' + cleanValue + '</option>');});select.select2({width: '100%'});}});}});$('#exportMaqolalar').on('click', function() {window.location.href = '/admin/export_articles_to_excel';});});</script>

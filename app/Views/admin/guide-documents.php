<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Mundarija Jadvali -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="float-left">
                <h6 class="m-0 font-weight-bold text-primary">Mundarija jadvali</h6>
            </div>
            <div class="float-right">
                <!-- Excelga eksport qilish tugmasi, icon bilan -->
                <button class="btn btn-success" id="exportMundarija">
                    <i class="fas fa-file-excel"></i> Excelga yuklash
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table id="guideTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Yuboruvchi</th>
                        <th>Ta'lim turi</th>
                        <th>Bosqich</th>
                        <th>Raqami</th>
                        <th>Bajarilgan ishlar</th>
                        <th>Yuklangan hujjat vazifasi</th>
                        <th>Qo'shimcha ish bajarilishi bo'yicha izoh</th>
                        <th>Fayl nomi</th>
                        <th>Status</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($guideDocuments as $document): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($document['id']); ?></td>
                            <td><?php echo htmlspecialchars($document['user_login']); ?></td>
                            <td><?php echo htmlspecialchars($document['education_type']); ?></td>
                            <td><?php echo htmlspecialchars($document['stage']); ?></td>
                            <td><?php echo htmlspecialchars($document['number']); ?></td>
                            <td><?php echo htmlspecialchars($document['planned_works']); ?></td>
                            <td><?php echo htmlspecialchars($document['researcher_tasks']); ?></td>
                            <td><?php echo htmlspecialchars($document['additional_work']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars(($protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $document['file_url']); ?>" class="btn btn-info btn-" download>
                                    <i class="fas fa-download"></i> <?php echo htmlspecialchars(basename($document['file_url'])); ?>
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
<script>$(document).ready(function(){$('.cancelBtn').on('click',function(){var documentId=$(this).data('id');$('#cancelModal'+documentId).modal('show');});$('.saveCancelReasonBtn').on('click',function(){var documentId=$(this).data('id');var reason=$('#cancelReason'+documentId).val().trim();if(reason){$.ajax({url:'/admin/cancelGuideDocument',method:'POST',data:{document_id:documentId,cancel_reason:reason},success:function(response){var result=JSON.parse(response);if(result.status==='success'){new Notyf().success(result.message);setTimeout(function(){location.reload();},1200);}else{new Notyf().error(result.message);}},error:function(xhr,status,error){console.error("AJAX xatolik:",error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});$('#cancelModal'+documentId).modal('hide');}else{alert("Iltimos, sababni kiriting.");}});$('.deleteBtn').on('click',function(){var documentId=$(this).data('id');var confirmDelete=confirm("Haqiqatan ham o'chirishni istaysizmi?");if(confirmDelete){$.ajax({url:'/admin/deleteGuideDocument',method:'POST',data:{document_id:documentId},success:function(response){var result=JSON.parse(response);if(result.status==='success'){new Notyf().success(result.message);setTimeout(function(){location.reload();},1200);}else{new Notyf().error(result.message);}},error:function(xhr,status,error){console.error("AJAX xatolik:",error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('.approveBtn').on('click',function(){var documentId=$(this).data('id');var confirmApprove=confirm("Chindan ham tasdiqlaysizmi?");if(confirmApprove){$.ajax({url:'/admin/approveGuideDocument',method:'POST',data:{document_id:documentId},success:function(response){var result=JSON.parse(response);if(result.status==='success'){new Notyf().success(result.message);setTimeout(function(){location.reload();},1200);}else{new Notyf().error(result.message);}},error:function(xhr,status,error){console.error("AJAX xatolik:",error);new Notyf().error("Xatolik yuz berdi, iltimos qayta urinib ko'ring.");}});}});$('#guideTable').DataTable({"language":{"url":"/assets/vendor/json/uzbek.json"},"initComplete":function(){var api=this.api();api.columns().every(function(){var column=this;var columnTitle=$(column.header()).text();if(columnTitle!=='Harakatlar'&&columnTitle!=='Maqola fayli'&&columnTitle!=='Fayl nomi'){var select=$('<select class="form-control select2"><option value="">'+columnTitle+'</option></select>').appendTo($(column.header()).empty()).on('change',function(){var val=$.fn.dataTable.util.escapeRegex($(this).val());column.search(val?'^'+val+'$':'',true,false).draw();});column.data().unique().sort().each(function(d,j){var cleanValue=d.replace(/<[^>]*>/g,'').trim();select.append('<option value="'+cleanValue+'">'+cleanValue+'</option>');});select.select2({width:'100%'});}});}});$('#exportMundarija').on('click',function(){window.location.href='/admin/export_guide_to_excel';});});</script>
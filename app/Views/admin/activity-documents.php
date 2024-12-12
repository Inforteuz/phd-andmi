<?php

require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';

?>

<!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Faoliyat Jadvali -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left">
                                <h6 class="m-0 font-weight-bold text-primary">Faoliyat jadvali</h6>
                            </div>
                            <div class="float-right">
                                <!-- Excelga eksport qilish tugmasi, icon bilan -->
                                <button class="btn btn-success" id="exportFaoliyat">
                                    <i class="fas fa-file-excel"></i> Excelga yuklash
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive card-body">
                            <table id="faoliyatTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Yuboruvchi</th>
                                        <th>F.I.O</th>
                                        <th>Pasport seriyasi</th>
                                        <th>Doktorantura ixtisosligi</th>
                                        <th>Ilmiy rahbar F.I.O</th>
                                        <th>Ixtisoslik fayli</th>
                                        <th>Yakka tartibdagi reja fayli</th>
                                        <th>Stajirovka fayli</th>
                                        <th>Batafsil</th>
                                        <th>Yaratilgan sana</th>
                                        <th>Harakatlar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($activityDocuments as $document): ?>
                                        <tr>
                                            <td><?= $document['id'] ?></td>
                                            <td><?= $document['user_login'] ?></td>
                                            <td><?= $document['fio'] ?></td>
                                            <td><?= $document['passportNumber'] ?></td>
                                            <td><?= $document['doctorateSpecialty'] ?></td>
                                            <td><?= $document['supervisorFio'] ?></td>
                                            <td>
                                                <a href="<?= $this->base_url($document['theoreticalProgramFile']) ?>" class="btn btn-sm btn-info" download>
                                                    <i class="fas fa-download"></i> Ixtisoslik fayli
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= $this->base_url($document['individualPlanFile']) ?>" class="btn btn-sm btn-info" download>
                                                    <i class="fas fa-download"></i> Yakka tartibdagi reja fayli
                                                </a>
                                            </td>
                                            <td>
                                            <?php if (!empty($document['academicFile'])): ?>
                                                <a href="<?= $this->base_url($document['academicFile']) ?>" class="btn btn-sm btn-info" download>
                                                    <i class="fas fa-download"></i> Stajirovka fayli
                                                </a>
                                            <?php else: ?>
                                                <span class="text-primary">Fayl mavjud emas.</span>
                                            <?php endif; ?>
                                        </td>
                                            <td>
                                            <a href="#" class="btn btn-sm btn-info btn-detail" data-user_id="<?= $document['user_id'] ?>">
                                                <i class="fas fa-file-excel"></i> Batafsil
                                            </a>
                                        </td>
                                        <td><?= $document['created_at'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger btn-delete" data-user_id="<?= $document['user_id'] ?>">
                                                <i class="fas fa-trash"></i> O'chirish
                                            </button>
                                        </td>
                                        </tr>
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
<script>$(document).ready(function() { var notyf = new Notyf(); $('#faoliyatTable').DataTable({ "language": { "url": "/assets/vendor/json/uzbek.json" }, "initComplete": function() { var api = this.api(); api.columns().every(function() { var column = this; var columnTitle = $(column.header()).text(); if (columnTitle !== 'Harakatlar' && columnTitle !== 'Ixtisoslik fayli' && columnTitle !== 'Yakka tartibdagi reja fayli' && columnTitle !== 'Stajirovka fayli' && columnTitle !== 'Batafsil') { var select = $('<select class="form-control select2"><option value="">' + columnTitle + '</option></select>').appendTo($(column.header()).empty()).on('change', function() { var val = $.fn.dataTable.util.escapeRegex($(this).val()); column.search(val ? '^' + val + '$' : '', true, false).draw(); }); column.data().unique().sort().each(function(d, j) { var cleanValue = d.replace(/<[^>]*>/g, '').trim(); select.append('<option value="' + cleanValue + '">' + cleanValue + '</option>'); }); select.select2({ width: '100%' }); } }); document.getElementById('exportFaoliyat').addEventListener('click', function() { window.location.href = '/admin/export_activity_documents_to_excel'; }); $('.btn-detail').on('click', function() { var user_id = $(this).data('user_id'); $.ajax({ url: '/admin/export_user_activity_documents_to_excel', method: 'POST', data: { user_id: user_id }, dataType: 'json', success: function(response) { console.log(response); console.log("URL:" + response.download_url); if (response.success) { window.location.href = response.download_url; notyf.success('Fayl muvaffaqiyatli yuklandi!'); } else { notyf.error('Xatolik yuz berdi: ' + (response.message || 'Noma’lum xato')); } }, error: function(jqXHR, textStatus, errorThrown) { console.error("AJAX Error: " + textStatus, errorThrown); notyf.error('Tarmoq xatosi yuz berdi!'); } }); }); $('.btn-delete').on('click', function() { var user_id = $(this).data('user_id'); if (confirm('Haqiqatan ham ushbu foydalanuvchini ma’lumotlarini o’chirmoqchimisiz?')) { $.ajax({ url: '/admin/delete_activity_document', method: 'POST', data: { user_id: user_id }, dataType: 'json', success: function(response) { if (response.success) { notyf.success('Foydalanuvchining ma’lumotlari muvaffaqiyatli o’chirildi!'); setTimeout(function() { location.reload(); }, 1000); } else { notyf.error('Xatolik yuz berdi!'); } }, error: function(jqXHR, textStatus, errorThrown) { console.error('AJAX xatolik:', textStatus, errorThrown); notyf.error('Tarmoq xatosi yuz berdi!'); } }); } }); } }); });</script>
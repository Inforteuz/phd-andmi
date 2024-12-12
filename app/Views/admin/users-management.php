<?php

require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';

?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Foydalanuvchilar Jadvali -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="float-left">
                <h6 class="m-0 font-weight-bold text-primary">Foydalanuvchilarni boshqarish</h6>
            </div>
            <div class="float-right">
                <!-- Excelga eksport qilish tugmasi, icon bilan -->
                <button class="btn btn-success" id="exportUsers">
                    <i class="fas fa-file-excel"></i> Excelga yuklash
                </button>
                <!-- Foydalanuvchi qo'shish tugmasi -->
                <button class="btn btn-primary" id="addUserBtn">
                    <i class="fas fa-user-plus"></i> Yangi foydalanuvchi qo'shish
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table id="usersTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 3%;">#</th>
                        <th style="width: 3%;">Foydalanuvchi rasmi</th>
                        <th>Platforma IDsi</th>
                        <th>Login</th>
                        <th>Parol</th>
                        <th>FIO</th>
                        <th>Otasini ismi</th>
                        <th>Jinsi</th>
                        <th>Ta'lim turi</th>
                        <th>Ixtisosligi raqami</th>
                        <th>Ixtisosligi nomi</th>
                        <th>Pasport seriyasi</th>
                        <th>PNIFL (JSHSHIR)</th>
                        <th>Akkaunt statusi</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($this->base_url($user['image_url'])) ?>" class="img-thumbnail" width="60" height="60" />
                            </td>
                            <td><?= htmlspecialchars($user['user_id'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['login'] ?? 'Noma’lum') ?></td>
                            <td>***********</td>
                            <td><?= htmlspecialchars($user['fullname'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['middlename'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['gender'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['degree'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['speciality_number'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['speciality_name'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['passportSeries'] ?? 'Noma’lum') ?></td>
                            <td><?= htmlspecialchars($user['pnifl'] ?? 'Noma’lum') ?></td>
                            <td>
                                <span class="badge <?= $user['status'] == 'active' ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $user['status'] == 'active' ? 'Faol' : 'Nofaol' ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-circle editUserBtn" data-user-id="<?= htmlspecialchars($user['id']) ?>" data-toggle="modal" data-target="#editUserModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-circle deleteUserBtn" data-user-id="<?= htmlspecialchars($user['user_id']) ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Page Content -->

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Yangi foydalanuvchi qo'shish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" id="login" name="login" placeholder="Login kiriting" required>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Familya va ismi</label>
                        <input type="text" class="form-control" id="fio" name="fullname" placeholder="Familya va ismini kiriting" required>
                    </div>
                    <div class="form-group">
                        <label for="middlename">Otasining ismi</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Otasining ismini kiriting" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Jinsi</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="" disabled selected>Jinsini belgilang</option>
                            <option value="Erkak">Erkak</option>
                            <option value="Ayol">Ayol</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">Foydalanuvchi rasmi</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="password">Parol</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Parol kiriting" required>
                    </div>
                    <div class="form-group">
                        <label for="educationType">Ta'lim turi</label>
                        <select class="form-control" id="educationType" name="educationType" required>
                            <option value="" disabled selected>Ta'lim turini belgilang</option>
                            <option value="Stajor taqiqotchi (PhD)">Stajor taqiqotchi (PhD)</option>
                            <option value="Tayanch doktorant (PhD)">Tayanch doktorant (PhD)</option>
                            <option value="Maqsadli tayanch doktorant (PhD)">Maqsadli tayanch doktorant (PhD)</option>
                            <option value="Mustaqil izlanuvchi (PhD)">Mustaqil izlanuvchi (PhD)</option>
                            <option value="Doktorant (DSc)">Doktorant (DSc)</option>
                            <option value="Maqsadli doktorantura (DSc)">Maqsadli doktorantura (DSc)</option>
                            <option value="Mustaqil izlanuvchi (DSc)">Mustaqil izlanuvchi (DSc)</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="specialtyNumber">Ixtisosligi raqami</label>
                        <input type="text" class="form-control" name="specialtyNumber" id="specialtyNumber" placeholder="Ixtisosligi raqami" required>
                    </div>
                    <div class="form-group">
                        <label for="specialtyName">Ixtisosligi nomi</label>
                        <input type="text" class="form-control" name="specialtyName" id="specialtyName" placeholder="Ixtisosligi nomi" required>
                    </div>
                    <div class="form-group">
                        <label for="passportSeries">Pasport seriyasi va raqami</label>
                        <input type="text" class="form-control" name="passportSeries" id="passportSeries" placeholder="Pasport seriyasi va raqami (AC3207749)" required>
                         <div id="passportSeriesError" class="text-danger" style="display:none;">Pasport seriyasi va raqami noto'g'ri, iltimos to'g'ri formatda kiriting.</div>
                    </div>
                    <div class="form-group">
                        <label for="pnifl">PNIFL (JSHSHIR)</label>
                        <input type="number" class="form-control" name="pnifl" id="pnifl" placeholder="PNIFL (14 ta raqam)" required>
                        <div id="pniflError" class="text-danger" style="display:none;">PNIFL 14 ta raqamdan iborat bo'lishi kerak!</div>
                    </div>
                    <div class="form-group">
                        <label for="accountStatus">Akkaunt statusi</label>
                        <select class="form-control" id="accountStatus" disabled>
                            <option value="active">Faol</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                <button type="submit" class="btn btn-primary" id="saveAddUserBtn">Saqlash</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Foydalanuvchini tahrirlash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" enctype="multipart/form-data">
                    <!-- Inputlar -->
                    <div class="form-group">
                        <label for="editPlatformId">Platforma IDsi</label>
                        <input type="text" class="form-control" id="editPlatformId" name="user_id" disabled>
                    </div>
                    <div class="form-group">
                        <label for="editLogin">Login</label>
                        <input type="text" class="form-control" id="editLogin" name="editLogin" required>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Familya va ismi</label>
                        <input type="text" class="form-control" id="editFio" name="editFio" placeholder="Familya va ismini kiriting" required>
                    </div>
                    <div class="form-group">
                        <label for="middlename">Otasining ismi</label>
                        <input type="text" class="form-control" id="editMiddlename" name="editMiddlename" placeholder="Otasining ismini kiriting" required>
                    </div>
                    <div class="form-group">
                        <label for="editGender">Jinsi</label>
                        <select class="form-control" id="editGender" name="editGender" required>
                            <option value="" disabled selected>Jinsini belgilang</option>
                            <option value="Erkak">Erkak</option>
                            <option value="Ayol">Ayol</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPhoto">Foydalanuvchi rasmi</label>
                        <input type="file" class="form-control" id="editPhoto" name="editPhoto" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="editPassword">Parol</label>
                        <input type="password" class="form-control" id="editPassword" name="editPassword" placeholder="Parolni kiriting" required>
                    </div>
                    <div class="form-group">
                        <label for="editEducationType">Ta'lim turi</label>
                        <select class="form-control" id="editEducationType" name="editEducationType" required>
                            <option value="Stajor taqiqotchi (PhD)">Stajor taqiqotchi (PhD)</option>
                            <option value="Tayanch doktorant (PhD)">Tayanch doktorant (PhD)</option>
                            <option value="Maqsadli tayanch doktorant (PhD)">Maqsadli tayanch doktorant (PhD)</option>
                            <option value="Mustaqil izlanuvchi (PhD)">Mustaqil izlanuvchi (PhD)</option>
                            <option value="Doktorant (DSc)">Doktorant (DSc)</option>
                            <option value="Maqsadli doktorantura (DSc)">Maqsadli doktorantura (DSc)</option>
                            <option value="Mustaqil izlanuvchi (DSc)">Mustaqil izlanuvchi (DSc)</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editSpecialtyNumber">Ixtisosligi raqami</label>
                        <input type="text" class="form-control" name="editSpecialtyNumber" id="editSpecialtyNumber" placeholder="Ixtisosligi raqami" required>
                    </div>
                    <div class="form-group">
                        <label for="editSpecialtyName">Ixtisosligi nomi</label>
                        <input type="text" class="form-control" name="editSpecialtyName" id="editSpecialtyName" placeholder="Ixtisosligi nomi" required>
                    </div>
                    <div class="form-group">
                        <label for="editPassportSeries">Pasport seriyasi va raqami</label>
                        <input type="text" class="form-control" name="editPassportSeries" id="editPassportSeries" placeholder="Pasport seriyasi va raqami (AC3207749)" required>
                        <div id="editPassportSeriesError" class="text-danger" style="display:none;">Pasport seriyasi va raqami noto'g'ri, iltimos to'g'ri formatda kiriting.</div>
                    </div>
                    <div class="form-group">
                        <label for="editPnifl">PNIFL (JSHSHIR)</label>
                        <input type="number" class="form-control" name="editPnifl" id="editPnifl" placeholder="PNIFL (14 ta raqam)" required>
                        <div id="editPniflError" class="text-danger" style="display:none;">PNIFL 14 ta raqamdan iborat bo'lishi kerak!</div>
                    </div>
                    <div class="form-group">
                        <label for="editAccountStatus">Akkaunt statusi</label>
                        <select class="form-control" id="editAccountStatus" disabled>
                            <option value="active">Faol</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                <button type="button" class="btn btn-primary" id="saveEditUserBtn">Saqlash</button>
            </div>
        </div>
    </div>
</div>
</div>
<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/footer.php'; ?>
<?php include 'layouts/scripts.php'; ?>
<script>document.addEventListener('DOMContentLoaded',function(){const notyf=new Notyf(),passportRegex=/^[A-Z]{2}\d{7}$/,pniflRegex=/^\d{14}$/,validatePassportAndPnilf=(e,t)=>{let n=!0;return passportRegex.test(e)?document.getElementById('passportSeriesError').style.display='none':(document.getElementById('passportSeriesError').style.display='block',n=!1),pniflRegex.test(t)?document.getElementById('pniflError').style.display='none':(document.getElementById('pniflError').style.display='block',n=!1),n};function handleInputValidation(e,t,n){e.addEventListener('input',function(){const i=e.value.trim();n.test(i)?t.style.display='none':t.style.display='block'})}const pniflInput=document.getElementById('pnifl'),passportSeriesInput=document.getElementById('passportSeries'),saveAddUserBtn=document.getElementById('saveAddUserBtn'),editPniflInput=document.getElementById('editPnifl'),editPassportSeriesInput=document.getElementById('editPassportSeries');handleInputValidation(pniflInput,document.getElementById('pniflError'),pniflRegex),handleInputValidation(passportSeriesInput,document.getElementById('passportSeriesError'),passportRegex),handleInputValidation(editPniflInput,document.getElementById('editPniflError'),pniflRegex),handleInputValidation(editPassportSeriesInput,document.getElementById('editPassportSeriesError'),passportRegex),saveAddUserBtn&&saveAddUserBtn.addEventListener('click',function(e){e.preventDefault();const t=new FormData($('#addUserForm')[0]),n=document.getElementById('passportSeries').value.trim(),i=document.getElementById('pnifl').value.trim();validatePassportAndPnilf(n,i)&&$.ajax({url:'save_user',type:'POST',data:t,processData:!1,contentType:!1,success:function(){notyf.success({message:"Foydalanuvchi muvaffaqiyatli qo’shildi",duration:2800}),setTimeout(function(){location.reload()},1200)},error:function(){notyf.error("Foydalanuvchi qo’shishda xatolik yuz berdi")}})}),$(document).on('click','.editUserBtn',function(){const e=$(this).data('user-id');$.ajax({url:'get_user',type:'POST',data:{id:e},dataType:'json',success:function(e){if(e.success){const t=e.data;$('#editPlatformId').val(t.user_id),$('#editLogin').val(t.login),$('#editPassword').val(t.password),$('#editGender').val(t.gender),$('#editMiddlename').val(t.middlename),$('#editFio').val(t.fullname),$('#editEducationType').val(t.degree),$('#editSpecialtyNumber').val(t.speciality_number),$('#editSpecialtyName').val(t.speciality_name),$('#editPassportSeries').val(t.passportSeries),$('#editPnifl').val(t.pnifl),$('#editAccountStatus').val(t.status),'Administrator'===t.degree?($('#editEducationType').prop('disabled',!0),$('#editEducationType').val('Administrator')):$('#editEducationType').prop('disabled',!1)}else notyf.error("Foydalanuvchi topilmadi")},error:function(){notyf.error("Foydalanuvchi ma’lumotlarini olishda xatolik yuz berdi")}})}),$("#saveEditUserBtn").on('click',function(e){e.preventDefault();const t=$("#editPlatformId").val(),n=new FormData($('#editUserForm')[0]),i=$('#editPassword').val();n.append('user_id',t),i&&n.append('editPassword',i),$.ajax({url:'update_user',type:'POST',data:n,processData:!1,contentType:!1,success:function(e){JSON.parse(e).success?(notyf.success({message:"Foydalanuvchi muvaffaqiyatli yangilandi",duration:2800}),setTimeout(function(){location.reload()},1200)):notyf.error("Foydalanuvchi yangilashda xatolik yuz berdi")},error:function(){notyf.error("Foydalanuvchi yangilashda xatolik yuz berdi")}})}),$(document).on('click','.deleteUserBtn',function(){const e=$(this).data('user-id');confirm("Siz bu foydalanuvchini o’chirmoqchimisiz?")&&$.ajax({url:'delete_user',type:'POST',data:{id:e},success:function(){notyf.success({message:"Foydalanuvchi o’chirildi",duration:2800}),setTimeout(function(){location.reload()},1200)},error:function(){notyf.error("Foydalanuvchi o’chirishda xatolik yuz berdi")}})});const addUserBtn=document.getElementById('addUserBtn');addUserBtn&&addUserBtn.addEventListener('click',function(){$('#addUserModal').modal('show')});var tables=[{tableId:'usersTable'}];tables.forEach(function(e){try{$.fn.dataTable.isDataTable('#'+e.tableId)&&($('#'+e.tableId).DataTable().destroy(),console.log('Destroy success for table: '+e.tableId))}catch(e){console.log('Destroy failed for table: '+e.tableId)}$('#'+e.tableId).DataTable({language:{url:'/assets/vendor/json/uzbek.json'},initComplete:function(){this.api().columns().every(function(){const e=this,t=$(e.header()).text();if('Harakatlar'!==t){const n=$('<select class="form-control select2"><option value="">'+t+'</option></select>').appendTo($(e.header()).empty()).on('change',function(){const t=$.fn.dataTable.util.escapeRegex($(this).val());e.search(t?'^'+t+'$':'',!0,!1).draw()});e.data().unique().sort().each(function(e){n.append('<option value="'+e.replace(/<[^>]*>/g,'').trim()+'">'+e+'</option>')}),n.select2({width:'100%'})}})}})}),document.getElementById('exportUsers').addEventListener('click',function(){window.location.href='/admin/export_users_to_excel'})});</script>
</body>
</html>
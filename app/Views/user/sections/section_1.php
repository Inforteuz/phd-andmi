<!-- Section 1 - Faoliyat -->
    <div class="tab-pane fade show active" id="section1" role="tabpanel" aria-labelledby="section1-tab">
      <h5><i class="fas fa-user-graduate"></i> Doktorant faoliyati samaradorligi</h5>
      <form action="/user/saveFaoliyat" method="POST" enctype="multipart/form-data" id="faoliyat">
        <!-- F.I.O, Jinsi va Tug'ilgan joyi -->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="fio"><i class="fas fa-id-card"></i> F.I.O <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="fio" name="fio" value="<?= $_SESSION['fullname'] ?>" placeholder="<?= $_SESSION['fullname'] ?>" disabled required>
            </div>
          </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="gender"><i class="fas fa-venus-mars"></i> Jinsi <span class="text-danger">*</span></label>
          <select class="form-control" id="gender" name="gender" required>
            <option value="" disabled selected>Jinsingizni belgilang</option>
            <option value="Erkak">Erkak</option>
            <option value="Ayol">Ayol</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Tug'ilgan sanasi va yashash joyi -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="birthplace"><i class="fas fa-map-marker-alt"></i> Tug'ilgan joyi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="birthplace" name="birthplace" placeholder="Tug'ilgan joyingiz" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="birthdate"><i class="fas fa-calendar-day"></i> Tug'ilgan sanasi <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="birthdate" name="birthdate" required>
        </div>
      </div>
    </div>

    <!-- Yashash joyi va holati -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="residence"><i class="fas fa-home"></i> Hozirgi yashash joyi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="residence" name="residence" placeholder="Ayni vaqtdagi istiqomat joyi" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="residenceStatus"><i class="fas fa-bed"></i> Yashash joyi holati <span class="text-danger">*</span></label>
          <select class="form-control" id="residenceStatus" name="residenceStatus" required>
            <option value="" disabled selected>Tanlang</option>
            <option value="Doimiy">Doimiy</option>
            <option value="Vaqtinchalik">Vaqtinchalik</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Passport, JSHSHIR, Ish joyi, Lavozim -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="passportNumber"><i class="fas fa-passport"></i> Passport seriya va raqami <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="passportNumber" name="passportNumber" placeholder="Passport seriya va raqamini kiriting" required>
          <small id="passportNumberError" class="form-text text-danger" style="display: none;"></small>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="pnifl"><i class="fas fa-id-card"></i> PNIFL (JSHSHIR) <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="pnifl" name="pnifl" placeholder="JSHSHIRni kiriting" required>
          <small id="pniflError" class="form-text text-danger" style="display: none;"></small>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="currentJob"><i class="fas fa-briefcase"></i> Ayni damdagi ish joyi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="currentJob" name="currentJob" placeholder="Ish joyini kiriting" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="position"><i class="fas fa-cogs"></i> Lavozimi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="position" name="position" placeholder="Lavozimni kiriting" required>
        </div>
      </div>
    </div>

    <!-- Bakalaviriat va Diplom -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="bachelor"><i class="fas fa-graduation-cap"></i> Bakalaviriat (Mutaxasislik nomi) <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="bachelor" name="bachelor" placeholder="Informatika va AT" required>
        </div>
        <div class="form-group">
          <label for="bachelorDiploma"><i class="fas fa-certificate"></i> Diplom seriya va raqami <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="bachelorDiploma" name="bachelorDiploma" placeholder="B 00001" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="bachelorDate"><i class="fas fa-calendar-alt"></i> Bakalaviriat diplomi berilgan sana <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="bachelorDate" name="bachelorDate" required>
        </div>
      </div>
    </div>

    <!-- Magistratura va Diplom -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="master"><i class="fas fa-graduation-cap"></i> Magistratura (Mutaxasislik nomi) <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="master" name="master" placeholder="Informatika va AT" required>
        </div>
        <div class="form-group">
          <label for="masterDiploma"><i class="fas fa-certificate"></i> Diplom seriya va raqami <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="masterDiploma" name="masterDiploma" placeholder="M 00001" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="masterDate"><i class="fas fa-calendar-alt"></i> Magistratura diplomi berilgan sana <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="masterDate" name="masterDate" required>
        </div>
      </div>
    </div>
    <hr>

<!-- Doktorantura va ixtisoslik qismi -->
<h5 class="text-center mb-4"><i class="fas fa-graduation-cap"></i> Doktorantura va ixtisoslik</h5>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="doctorateSpecialty"><i class="fas fa-cogs"></i> Doktorantura ixtisosligi (shifr, nomi) <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="doctorateSpecialty" name="doctorateSpecialty" placeholder="Ixtisoslik shifri va nomi" required>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="directionName"><i class="fas fa-arrow-right"></i> Yo'nalish nomi <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="directionName" name="directionName" placeholder="Yo'nalish nomini kiriting" required>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="dissertationTopic"><i class="fas fa-book"></i> Dissertatsiya mavzusi <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="dissertationTopic" name="dissertationTopic" placeholder="Dissertatsiya mavzusini kiriting" required>
    </div>
  </div>
</div>

<hr>

<!-- Ilmiy rahbar -->
<h5 class="text-center"><i class="fas fa-chalkboard-teacher"></i> Ilmiy rahbar (maslahatchi)ning ma'lumotlari</h5><br>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="supervisorFio"><i class="fas fa-id-card"></i> F.I.O <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="supervisorFio" name="supervisorFio" placeholder="Ilmiy rahbarning F.I.O" required>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="supervisorWorkplace"><i class="fas fa-building"></i> Ish joyi <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="supervisorWorkplace" name="supervisorWorkplace" placeholder="Ilmiy rahbarning ish joyi" required>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="supervisorDegree"><i class="fas fa-graduation-cap"></i> Ilmiy darajasi <span class="text-danger">*</span></label>
      <select class="form-control" id="supervisorDegree" name="supervisorDegree" required>
        <option value="" disabled selected>Tanlang</option>
        <option value="Fan nomzodi">Fan nomzodi</option>
        <option value="Fan doktori">Fan doktori</option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="supervisorTitle"><i class="fas fa-crown"></i> Ilmiy unvoni <span class="text-danger">*</span></label>
      <select class="form-control" id="supervisorTitle" name="supervisorTitle" required>
        <option value="" disabled selected>Tanlang</option>
        <option value="Dotsent">Dotsent</option>
        <option value="Professor">Professor</option>
        <option value="Akademik">Akademik</option>
      </select>
    </div>
  </div>
</div>
<hr>
    <!-- Oliy ta'limdan keyingi ta'lim instituti -->
    <h5 class="text-center"><i class="fas fa-university"></i> Oliy ta'limdan keyingi ta'lim instituti</h5><br>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="admissionYear"><i class="fas fa-calendar-check"></i> Qabul qilingan yili <span class="text-danger">*</span></label>
          <select class="form-control" id="admissionYear" name="admissionYear" required>
            <option value="" disabled selected>O'quv yilini tanlang</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2024">2025</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="stage"><i class="fas fa-layer-group"></i> Bosqich <span class="text-danger">*</span></label>
          <select class="form-control" id="stage" name="stage" required>
            <option value="" disabled selected>Bosqichni tanlang</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="educationType"><i class="fas fa-graduation-cap"></i> Ta'lim turi <span class="text-danger">*</span></label>
          <select class="form-control" id="educationType" name="educationType" required>
            <option value="" disabled selected>Ta'lim turini tanlang</option>
            <option value="Stajor taqiqotchi (PhD)">Stajor taqiqotchi (PhD)</option>
            <option value="Tayanch doktorant (PhD)">Tayanch doktorant (PhD)</option>
            <option value="Maqsadli tayanch doktorant (PhD)">Maqsadli tayanch doktorant (PhD)</option>
            <option value="Mustaqil izlanuvchi (PhD)">Mustaqil izlanuvchi (PhD)</option>
            <option value="Doktorant (DSc)">Doktorant (DSc)</option>
            <option value="Maqsadli doktorantura (DSc)">Maqsadli doktorantura (DSc)</option>
            <option value="Mustaqil izlanuvchi (DSc)">Mustaqil izlanuvchi (DSc)</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="orderNumber"><i class="fas fa-file-alt"></i> Buyruq raqami va sanasi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="orderNumber" name="orderNumber" placeholder="Buyruq raqami va sanasi" required>
        </div>
      </div>
    </div>

<!-- Ixtisoslik bo'yicha nazariy-metodologik dastur -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="theoreticalProgramText"><i class="fas fa-cogs"></i> Ixtisoslik bo'yicha nazariy-metodologik dastur (tashkilotning kengashi bayoni sanasi va raqami) <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="theoreticalProgramText" name="theoreticalProgramText" placeholder="Tashkilotning kengashi bayoni sanasi va raqami" required>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="theoreticalProgramFile"><i class="fas fa-file-alt"></i> Fayl yuklash <span class="text-danger">*</span></label>
      <input type="file" class="form-control-file" id="theoreticalProgramFile" name="theoreticalProgramFile" required>
      <small class="form-text text-muted">Asoslovchi hujjat tasdiqlangan holda (PDF shaklida ilova qilinadi)</small>
    </div>
  </div>
</div>

<!-- Yakka tartibdagi rejaning mavjudligi -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="individualPlanText"><i class="fas fa-cogs"></i> Yakka tartibdagi rejaning mavjudligi (tashkilotning kengashi bayoni sanasi va raqami) <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="individualPlanText" name="individualPlanText" placeholder="Tashkilotning kengashi bayoni sanasi va raqami" required>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="individualPlanFile"><i class="fas fa-file-alt"></i> Fayl yuklash <span class="text-danger">*</span></label>
      <input type="file" class="form-control-file" id="individualPlanFile" name="individualPlanFile" required>
      <small class="form-text text-muted">Asoslovchi hujjat tasdiqlangan holda (PDF shaklida ilova qilinadi)</small>
    </div>
  </div>
</div>

<hr>

<!-- Akademik harakatchanlik -->
<h5 class="text-center mb-4"><i class="fas fa-trophy"></i> Akademik harakatchanlik</h5>
<div class="row justify-content-center">
  <div class="col-md-6">
    <!-- Fayl yuklash va Select ni yonma-yon markazlash -->
    <div class="form-group d-flex justify-content-center align-items-center">
      <!-- Select bo'limi -->
      <div class="mr-3">
        <label for="participationInCompetitions"><i class="fas fa-trophy"></i> Ishtiroki </label>
        <select class="form-control" id="participationInCompetitions" name="participationInCompetitions">
          <option value="" disabled selected>Tanlang</option>
          <option value="Ha">Ha</option>
          <option value="Yo'q">Yo'q</option>
        </select>
      </div>

      <!-- Fayl yuklash -->
        <div class="ml-3">
          <label for="academicFile" class="d-block"><i class="fas fa-file-alt"></i> Fayl yuklash </label>
          <input type="file" class="form-control-file" id="academicFile" name="academicFile">
          <small class="form-text text-muted">Asoslovchi hujjat tasdiqlangan holda (PDF shaklida ilova qilinadi)</small>
        </div>
      </div>
    </div>
  </div>
  <hr>

<!-- Stajirovka bo'limi -->
<h5 class="text-center"><i class="fas fa-building"></i> Xorijiy ilmiy va oliy ta'lim muassasalariga stajirovkalarga yuborilganlik holati</h5><br>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="organizationSent"><i class="fas fa-building"></i> Stajirovkaga yuborgan tashkilot nomi </label>
      <input type="text" class="form-control" id="organizationSent" name="organizationSent" placeholder="Tashkilot nomini kiriting">
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="organizationReceived"><i class="fas fa-building"></i> Stajirovkaga o'tgan tashkilot nomi </label>
      <input type="text" class="form-control" id="organizationReceived" name="organizationReceived" placeholder="O'tgan tashkilot nomi">
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="country"><i class="fas fa-globe"></i> Stajirovka o'tagan davlati nomi </label>
      <input type="text" class="form-control" id="country" name="country" placeholder="Davlat nomini kiriting">
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="startDate"><i class="fas fa-calendar-day"></i> Muddatidan (Boshlanish sanasi) </label>
      <input type="date" class="form-control" id="startDate" name="startDate">
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="endDate"><i class="fas fa-calendar-day"></i> Muddatigacha (Tugash sanasi) </label>
      <input type="date" class="form-control" id="endDate" name="endDate">
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="fileUpload"><i class="fas fa-upload"></i> Fayl yuklash </label>
      <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept=".pdf">
      <small class="form-text text-muted">Asoslovchi hujjat tasdiqlangan holda (PDF shaklida ilova qilinadi)</small>
    </div>
  </div>
</div>
<hr>

<!-- Saqlash tugmasi -->
<div class="form-group text-center">
  <button type="submit" class="btn btn-primary">
    <i class="fas fa-check"></i> Saqlash
  </button>
</div>
</form>
</div>

<?php if (isset($successMessage)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notyf = new Notyf();
            notyf.open({
                type: 'success',
                message: '<?= $successMessage ?>',
                position: {
                    x: 'right',
                    y: 'bottom'
                }
            });

            setTimeout(function() {
                window.location.href = "<?= $this->base_url('/user/portfolio#section1') ?>";
            }, 1600);
        });
    </script>
<?php endif; ?>

<?php if (isset($errorMessage)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notyf = new Notyf();
            notyf.open({
                type: 'error',
                message: '<?= $errorMessage ?>',
                position: {
                    x: 'right',
                    y: 'bottom'
                }
            });
            setTimeout(function() {
                window.location.href = "<?= $this->base_url('/user/portfolio#section1') ?>";
            }, 1600);
        });
    </script>
<?php endif; ?>
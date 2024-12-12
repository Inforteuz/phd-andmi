<!-- Section 6 - Xorijiy tillar bo'yicha egallangan sertifikatlar -->
<div class="tab-pane fade" id="section6" role="tabpanel" aria-labelledby="section6-tab">
  <h5><i class="fas fa-language"></i> Xorijiy tillar bo'yicha egallangan sertifikatlar</h5>
  <form action="saveSertifikat" method="POST" enctype="multipart/form-data">
    <div class="row">
      <!-- Til turi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="certificateType"><i class="fas fa-certificate"></i> Til turi <span class="text-danger">*</span></label></label>
          <select class="form-control" id="certificateType" name="certificateType" required>
            <option value="" disabled selected>Til turini tanlang</option>
            <option value="Milliy sertifikat">Milliy sertifikat</option>
            <option value="Xalqaro sertifikat">Xalqaro sertifikat</option>
          </select>
        </div>
      </div>

      <!-- Tilni yozing -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="languageName"><i class="fas fa-font"></i> Tilni yozing <span class="text-danger">*</span></label></label>
          <input type="text" class="form-control" id="languageName" name="languageName" placeholder="Tilni kiriting" required>
        </div>
      </div>

      <!-- Tilni bilish darajasi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="languageLevel"><i class="fas fa-clipboard"></i> Tilni bilish darajasi <span class="text-danger">*</span></label></label>
          <select class="form-control" id="languageLevel" name="languageLevel" required>
            <option value="" disabled selected>Darajani tanlang</option>
            <option value="A1">A1</option>
            <option value="A2">A2</option>
            <option value="B1">B1</option>
            <option value="B2">B2</option>
            <option value="C1">C1</option>
            <option value="C2">C2</option>
          </select>
        </div>
      </div>

      <!-- Olingan sanani kiriting -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="certificateDate"><i class="fas fa-calendar"></i> Olingan sanani kiriting <span class="text-danger">*</span></label></label>
          <input type="date" class="form-control" id="certificateDate" name="certificateDate" required>
        </div>
      </div>

      <!-- Fayl yuklash -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="certificateFile"><i class="fas fa-file-upload"></i> Sertifikat faylini yuklash <span class="text-danger">*</span></label></label>
          <input type="file" class="form-control" id="certificateFile" name="certificateFile" accept=".pdf,.docx" required>
          <small class="form-text text-muted">PDF yoki Word hujjatlarini yuklang</small>
        </div>
      </div>

      <!-- Saqlash tugmasi -->
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-check"></i> Saqlash
        </button>
      </div>
    </div>
  </form>

  <!-- HR chizig'i -->
  <hr>

  <!-- Sertifikatlar jadvali -->
  <h6><center><i class="fas fa-table"></i> Xorijiy tillar bo'yicha egallangan sertifikatlar</center></h6><br>
  <div class="table-responsive">
    <table class="table table-bordered" id="certificateTable">
      <thead>
        <tr>
          <th><i class="fas fa-hashtag"></i></th>
          <th><i class="fas fa-certificate"></i> Til turi</th>
          <th><i class="fas fa-font"></i> Til</th>
          <th><i class="fas fa-clipboard"></i> Daraja</th>
          <th><i class="fas fa-calendar"></i> Olingan sana</th>
          <th><i class="fas fa-file"></i> Fayl nomi</th>
          <th><i class="fas fa-info-circle"></i> Holat</th>
          <th><i class="fas fa-cogs"></i> Harakatlar</th>
        </tr>
      </thead>
      <tbody>
        <!-- Jadvaldagi satrlar -->
        <?php if (empty($sertifikatlar)): ?>
          <tr>
            <td colspan="8" class="text-center">Hozircha hech qanday sertifikat mavjud emas.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($sertifikatlar as $sertifikat): ?>
            <tr>
              <td><?= htmlspecialchars($sertifikat['id']) ?></td>
              <td><?= htmlspecialchars($sertifikat['certificate_type']) ?></td>
              <td><?= htmlspecialchars($sertifikat['language_name']) ?></td>
              <td><?= htmlspecialchars($sertifikat['language_level']) ?></td>
              <td><?= htmlspecialchars($sertifikat['certificate_date']) ?></td>
              <td><?= htmlspecialchars(basename($sertifikat['certificate_file'])) ?></td>
              <td>
                <?php if ($sertifikat['status'] == 'Tasdiqlandi'): ?>
                  <span class="badge badge-success">Tasdiqlandi</span>
                <?php elseif ($sertifikat['status'] == 'Kutilmoqda'): ?>
                  <span class="badge badge-warning">Kutilmoqda</span>
                <?php elseif ($sertifikat['status'] == 'Rad etildi'): ?>
                  <span class="badge badge-danger">Rad etildi</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($sertifikat['status'] == 'Tasdiqlandi'): ?>
                  <span class="text-muted">Ushbu fayl uchun harakat imkonsiz.</span>
                <?php elseif ($sertifikat['status'] == 'Kutilmoqda'): ?>
                  <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteSertifikat(<?= $sertifikat['id'] ?>)">
                    <i class="fas fa-trash-alt"></i> O'chirish
                  </button>
                <?php elseif ($sertifikat['status'] == 'Rad etildi'): ?>
                  <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#sertifikatModal-<?= $sertifikat['id'] ?>"><i class="fas fa-question-circle"></i> Sababi</button>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal (Rad etilgan sababi) -->
<?php foreach ($sertifikatlar as $sertifikat): ?>
  <?php if ($sertifikat['status'] == 'Rad etildi'): ?>
    <div class="modal fade" id="sertifikatModal-<?= $sertifikat['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="sertifikatModalLabel-<?= $sertifikat['id'] ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="sertifikatModalLabel-<?= $sertifikat['id'] ?>">Rad etilgan sababi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>Sababi:</strong> <?= htmlspecialchars($sertifikat['rejected_text']) ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php endforeach; ?>

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
                window.location.href = "<?= $this->base_url('/user/portfolio#section6') ?>";
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section6') ?>";
            }, 1600);
        }); 
    </script>
<?php endif; ?>
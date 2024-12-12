<!-- Section 5 - Darslik -->
<div class="tab-pane fade" id="section5" role="tabpanel" aria-labelledby="section5-tab">
  <h5><i class="fas fa-book"></i> Joriy chorakda yozib tayyorlangan darslik va o'quv qo'llanmalar</h5>
  <form action="saveDarslik" method="POST" enctype="multipart/form-data">
    <div class="row">
      <!-- Ishlanma turi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="workType"><i class="fas fa-briefcase"></i> Ishlanma turi <span class="text-danger">*</span></label>
          <select class="form-control" id="workType" name="workType" required>
            <option value="" disabled selected>Ishlanma turini tanlang</option>
            <option value="O’quv qo’llanma">O'quv qo'llanma</option>
            <option value="Darslik">Darslik</option>
            <option value="Monografiya">Monografiya</option>
          </select>
        </div>
      </div>

      <!-- Nomi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="workName"><i class="fas fa-book-open"></i> Nomi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="workName" name="workName" placeholder="Darslik nomini kiriting" required>
        </div>
      </div>

      <!-- Guvohnoma raqami -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="certificateNumber"><i class="fas fa-hashtag"></i> Guvohnoma raqami <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="certificateNumber" name="certificateNumber" placeholder="Guvohnoma raqamini kiriting" required>
        </div>
      </div>

      <!-- Sanasi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="workDate"><i class="fas fa-calendar"></i> Sanasi <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="workDate" name="workDate" required>
        </div>
      </div>

      <!-- Mualliflar soni -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="authorCount"><i class="fas fa-users"></i> Mualliflar soni <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="authorCount" name="authorCountD" placeholder="Mualliflar sonini kiriting" required>
        </div>
      </div>

      <!-- Mualliflar -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="authors"><i class="fas fa-user"></i> Mualliflar <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="authors" name="authorsD" placeholder="Mualliflarni kiriting" required>
        </div>
      </div>

      <!-- Fayl yuklash -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="workFile"><i class="fas fa-file-upload"></i> Fayl yuklash <span class="text-danger">*</span></label>
          <input type="file" class="form-control" id="workFile" name="workFile" accept=".pdf,.docx" required>
          <small class="form-text text-muted">PDF yoki Word hujjatlarini yuklang</small>
        </div>
      </div>

      <!-- Saqlash tugmasi (markazda) -->
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-check"></i> Saqlash
        </button>
      </div>
    </div>
  </form>

  <!-- HR chizig'i -->
  <hr>

  <!-- Joriy chorakda nashr etilgan darsliklar va guvohnomalar jadvali -->
  <h6><center><i class="fas fa-table"></i> Joriy chorakda nashr etilgan monografiyalar, Intellektual mulk, axborot-kommunikatsiya texnologiyalariga oid dasturlar va elektron bazalari uchun olingan guvohnomalar</h6></center><br>
  <div class="table-responsive">
    <table class="table table-bordered" id="workTable">
      <thead>
        <tr>
          <th style="width: 3%;">#</th>
          <th><i class="fas fa-briefcase"></i> Ishlanma turi</th>
          <th><i class="fas fa-book-open"></i> Nomi</th>
          <th><i class="fas fa-hashtag"></i> Guvohnoma raqami</th>
          <th><i class="fas fa-calendar"></i> Sanasi</th>
          <th><i class="fas fa-users"></i> Mualliflar soni</th>
          <th><i class="fas fa-user"></i> Mualliflar</th>
          <th> <i class="fas fa-file-upload"></i> Fayl nomi</th>
          <th> <i class="fas fa-circle"></i> Holat</th>
          <th> <i class="fas fa-cogs"></i> Harakatlar</th>
        </tr>
      </thead>
      <tbody>
        <!-- Jadvaldagi satrlar -->
        <?php if (empty($darsliklar)): ?>
          <tr>
            <td colspan="10" class="text-center">Hozircha hech qanday ma'lumot mavjud emas.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($darsliklar as $darslik): ?>
            <tr>
              <td><?= htmlspecialchars($darslik['id']) ?></td>
              <td><?= htmlspecialchars($darslik['work_type']) ?></td>
              <td><?= htmlspecialchars($darslik['work_name']) ?></td>
              <td><?= htmlspecialchars($darslik['certificate_number']) ?></td>
              <td><?= htmlspecialchars($darslik['work_date']) ?></td>
              <td><?= htmlspecialchars($darslik['author_count']) ?></td>
              <td><?= htmlspecialchars($darslik['authors']) ?></td>
              <td><?= htmlspecialchars(basename($darslik['file_name'])) ?></td>
              <td>
                <?php if ($darslik['status'] == 'Tasdiqlandi'): ?>
                  <span class="badge badge-success">Tasdiqlandi</span>
                <?php elseif ($darslik['status'] == 'Kutilmoqda'): ?>
                  <span class="badge badge-warning">Kutilmoqda</span>
                <?php elseif ($darslik['status'] == 'Rad etildi'): ?>
                  <span class="badge badge-danger">Rad etildi</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($darslik['status'] == 'Tasdiqlandi'): ?>
                  <span class="text-muted">Ushbu fayl uchun harakat imkonsiz.</span>
                <?php elseif ($darslik['status'] == 'Kutilmoqda'): ?>
                  <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteDarslik(<?= $darslik['id'] ?>)">
                    <i class="fas fa-trash-alt"></i> O'chirish
                  </button>
                <?php elseif ($darslik['status'] == 'Rad etildi'): ?>
                  <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#darslikModal-<?= $darslik['id'] ?>"><i class="fas fa-question-circle"></i> Sababi</button>
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
<?php foreach ($darsliklar as $darslik): ?>
  <?php if ($darslik['status'] == 'Rad etildi'): ?>
    <div class="modal fade" id="darslikModal-<?= $darslik['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="darslikModalLabel-<?= $darslik['id'] ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="darslikModalLabel-<?= $darslik['id'] ?>">Rad etilgan sababi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>Sababi:</strong> <?= htmlspecialchars($darslik['rejected_text']) ?></p>
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section5') ?>";
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section5') ?>";
            }, 1600);
        }); 
    </script>
<?php endif; ?>
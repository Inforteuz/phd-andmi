<!-- Section 4 - Patent -->
<div class="tab-pane fade" id="section4" role="tabpanel" aria-labelledby="section4-tab">
  <h5><i class="fas fa-cogs"></i> Patentlar</h5>
  <form action="savePatent" method="POST" enctype="multipart/form-data">
    <div class="row">
      <!-- Ishlanma turi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="patentType"><i class="fas fa-briefcase"></i> Ishlanma turi <span class="text-danger">*</span></label>
          <select class="form-control" id="patentType" name="patentType" required>
            <option value="" disabled selected>Patent turi tanlang</option>
            <option value="Intellektual mulk (patent, foydali modellar)">Intellektual mulk (patent, foydali modellar)</option>
            <option value="Axborot-kommunikatsiya texnologiyalariga oid dasturlar va elektron bazalari uchun olingan guvohnomalar">Axborot-kommunikatsiya texnologiyalariga oid dasturlar va elektron bazalari uchun olingan guvohnomalar</option>
          </select>
        </div>
      </div>

      <!-- Int.mulk nomi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="intellectualPropertyName"><i class="fas fa-file-alt"></i> Int.mulk nomi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="intellectualPropertyName" name="intellectualPropertyName" placeholder="Intellektual mulk nomini kiriting" required>
        </div>
      </div>

      <!-- Int.mulk raqami -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="intellectualPropertyNumber"><i class="fas fa-hashtag"></i> Int.mulk raqami <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="intellectualPropertyNumber" name="intellectualPropertyNumber" placeholder="Intellektual mulk raqamini kiriting" required>
        </div>
      </div>

      <!-- Sanasi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="patentDate"><i class="fas fa-calendar"></i> Sanasi <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="patentDate" name="patentDate" required>
        </div>
      </div>

      <!-- Mualliflar soni -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="authorCount"><i class="fas fa-users"></i> Mualliflar soni <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="authorCountP" name="authorCountP" placeholder="Mualliflar sonini kiriting" required>
        </div>
      </div>

      <!-- Mualliflar -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="authors"><i class="fas fa-user"></i> Mualliflar <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="authors" name="authorsP" placeholder="Mualliflarni kiriting" required>
        </div>
      </div>

      <!-- Fayl yuklash -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="patentFile"><i class="fas fa-file-upload"></i> Fayl yuklash <span class="text-danger">*</span></label>
          <input type="file" class="form-control" id="patentFile" name="patentFile" accept=".pdf,.docx" required>
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

<!-- Joriy chorakdagi patent, ishlanma va intellektual mulklar jadvali -->
<h6><center><i class="fas fa-table"></i> Joriy chorakdagi patent, ishlanma va intellektual mulklar jadvali</h6></center><br>
<div class="table-responsive">
  <table class="table table-bordered" id="patentTable">
    <thead>
      <tr>
        <th style="width: 3%;"><i class="fas fa-hashtag"></i></th>
        <th><i class="fas fa-cogs"></i> Ishlanma turi</th>
        <th><i class="fas fa-heading"></i> Nomi</th>
        <th><i class="fas fa-sort-numeric-up"></i> Raqami</th>
        <th><i class="fas fa-users"></i> Mualliflar</th>
        <th><i class="fas fa-user-friends"></i> Mualliflar soni</th>
        <th><i class="fas fa-calendar-alt"></i> Sanasi</th>
        <th><i class="fas fa-file"></i> Fayl nomi</th>
        <th><i class="fas fa-check-circle"></i> Holat</th>
        <th><i class="fas fa-cogs"></i> Harakatlar</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($patents)): ?>
        <tr>
          <td colspan="10" class="text-center">Hozircha hech qanday ma'lumot mavjud emas.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($patents as $patent): ?>
          <tr>
            <td><?= htmlspecialchars($patent['id']) ?></td>
            <td><?= htmlspecialchars($patent['patent_type']) ?></td>
            <td><?= htmlspecialchars($patent['intellectual_property_name']) ?></td>
            <td><?= htmlspecialchars($patent['intellectual_property_number']) ?></td>
            <td><?= htmlspecialchars($patent['authors']) ?></td>
            <td><?= htmlspecialchars($patent['author_count']) ?></td>
            <td><?= htmlspecialchars($patent['patent_date']) ?></td>
            <td><?= htmlspecialchars(basename($patent['patent_file'])) ?></td>
            <td>
              <?php if ($patent['status'] == 'Tasdiqlandi'): ?>
                <span class="badge badge-success">Tasdiqlandi</span>
              <?php elseif ($patent['status'] == 'Kutilmoqda'): ?>
                <span class="badge badge-warning">Kutilmoqda</span>
              <?php elseif ($patent['status'] == 'Rad etildi'): ?>
                <span class="badge badge-danger">Rad etildi</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($patent['status'] == 'Tasdiqlandi'): ?>
                <span class="text-muted">Ushbu fayl uchun harakat imkonsiz.</span>
              <?php elseif ($patent['status'] == 'Kutilmoqda'): ?>
              <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeletePatent(<?= $patent['id'] ?>)">
                <i class="fas fa-trash-alt"></i> O'chirish
              </button>
              <?php elseif ($patent['status'] == 'Rad etildi'): ?>
                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#cancelPatentModal-<?= $patent['id'] ?>"><i class="fas fa-question-circle"></i> Sababi</button>
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
<?php foreach ($patents as $patent): ?>
  <?php if ($patent['status'] == 'Rad etildi'): ?>
    <div class="modal fade" id="cancelPatentModal-<?= $patent['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="cancelPatentModalLabel-<?= $patent['id'] ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cancelPatentModalLabel-<?= $patent['id'] ?>">Rad etilgan sababi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Rad etilgan sababi: <?= htmlspecialchars($patent['rejected_text'] ?? 'Sababi ko\'rsatilmagan') ?>
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section4') ?>";
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section4') ?>";
            }, 1600);
        }); 
    </script>
<?php endif; ?>
<!-- Section 3 - Maqola -->
<div class="tab-pane fade" id="section3" role="tabpanel" aria-labelledby="section3-tab">
  <h5><i class="fas fa-pencil-alt"></i> Maqola</h5>
  <form action="saveMaqola" method="POST" enctype="multipart/form-data">
    <div class="row">
      <!-- Jurnal turi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="journalType"><i class="fas fa-book"></i> Jurnal turi <span class="text-danger">*</span></label>
          <select class="form-control" id="journalType" name="journalType" required>
            <option value="" disabled selected>Jurnal turini tanlang</option>
            <option value="Xorijiy_(Web_of_Science, Scopus)">Xorijiy (Web of Science, Scopus)</option>
            <option value="Mahalliy_oak">Mahalliy OAK</option>
            <option value="Xalqaro_Impakt">Xalqaro (impakt faktori yuqori)</option>
            <option value="Mahalliy_konferensiya">Mahalliy konferensiya</option>
            <option value="Xalqaro_konferensiya">Xalqaro konferensiya</option>
          </select>
        </div>
      </div>

      <!-- Nashr etilgan davlat nomi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="publishCountry"><i class="fas fa-globe"></i> Nashr etilgan davlat nomi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="publishCountry" name="publishCountry" placeholder="Nashr etilgan davlatni kiriting" required>
        </div>
      </div>

      <!-- Jurnal nomi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="journalName"><i class="fas fa-newspaper"></i> Jurnal-nomi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="journalName" name="journalName" placeholder="Jurnal nomini kiriting" required>
        </div>
      </div>

      <!-- Maqola nomi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="articleTitle"><i class="fas fa-heading"></i> Maqola nomi <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="articleTitle" name="articleTitle" placeholder="Maqola nomini kiriting" required>
        </div>
      </div>

      <!-- Nashr yili va oyi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="publishDate"><i class="fas fa-calendar-alt"></i> Nashr yili va oyi <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="publishDate" name="publishDate" placeholder="Yil va oyni kiriting" required>
        </div>
      </div>

      <!-- Materialning internet havolasi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="articleLink"><i class="fas fa-link"></i> Materialning internet havolasi</label>
          <input type="text" class="form-control" id="articleLink" name="articleLink" placeholder="Havolani kiriting">
        </div>
      </div>

      <!-- Mualliflar soni -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="authorCount"><i class="fas fa-users"></i> Mualliflar soni <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="authorCount" name="authorCountM" placeholder="Mualliflar sonini kiriting" required>
        </div>
      </div>

      <!-- Mualliflar -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="authors"><i class="fas fa-user"></i> Mualliflar <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="authors" name="authorsM" placeholder="Mualliflarni kiriting" required>
        </div>
      </div>

      <!-- Fayl yuklash -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="articleFile"><i class="fas fa-file-upload"></i> Maqola fayli yuklash <span class="text-danger">*</span></label>
          <input type="file" class="form-control" id="articleFile" name="articleFile" accept=".pdf,.docx" required>
          <small class="form-text text-muted">PDF yoki Word hujjatlarini yuklang</small>
        </div>
      </div>

      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-check"></i> Saqlash
        </button>
      </div>
    </div>
  </form>

  <!-- HR chizig'i -->
  <hr>

  <!-- Joriy chorakdagi ilmiy maqolalar jadvali -->
  <h6><center><i class="fas fa-table"></i> Joriy chorakdagi ilmiy maqolalar</h6></center><br>
  <div class="table-responsive">
    <table class="table table-bordered" id="maqolaTable">
      <thead>
        <tr>
          <th style="width: 3%;"><i class="fas fa-hashtag"></i></th>
          <th><i class="fas fa-book"></i> Jurnal turi</th>
          <th><i class="fas fa-globe"></i> Nashr etilgan davlat nomi</th>
          <th><i class="fas fa-newspaper"></i> Jurnal nomi</th>
          <th><i class="fas fa-heading"></i> Maqola nomi</th>
          <th><i class="fas fa-calendar-alt"></i> Nashr yili va oyi</th>
          <th><i class="fas fa-link"></i> Materialning internet havolasi</th>
          <th><i class="fas fa-users"></i> Mualliflar soni</th>
          <th><i class="fas fa-user"></i> Mualliflar</th>
          <th><i class="fas fa-file-upload"></i> Fayl nomi</th>
          <th><i class="fas fa-circle"></i> Holat</th>
          <th><i class="fas fa-cogs"></i> Harakatlar</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($maqolalar)): ?>
          <tr>
            <td colspan="10" class="text-center">Hozircha hech qanday ma'lumot mavjud emas.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($maqolalar as $maqola): ?>
            <tr>
              <td><?= htmlspecialchars($maqola['id']) ?></td>
              <td><?= htmlspecialchars($maqola['journalType']) ?></td>
              <td><?= htmlspecialchars($maqola['publishCountry']) ?></td>
              <td><?= htmlspecialchars($maqola['journalName']) ?></td>
              <td><?= htmlspecialchars($maqola['articleTitle']) ?></td>
              <td><?= htmlspecialchars($maqola['publishDate']) ?></td>
              <td><a href="<?= htmlspecialchars($maqola['articleLink']) ?>" target="_blank"><?= htmlspecialchars($maqola['articleLink']) ?></a></td>
              <td><?= htmlspecialchars($maqola['authorCount']) ?></td>
              <td><?= htmlspecialchars($maqola['authors']) ?></td>
              <td><?= htmlspecialchars(basename($maqola['articleFile'])) ?></td>
              <td>
                <?php if ($maqola['status'] == 'Tasdiqlandi'): ?>
                  <span class="badge badge-success">Tasdiqlandi</span>
                <?php elseif ($maqola['status'] == 'Kutilmoqda'): ?>
                  <span class="badge badge-warning">Kutilmoqda</span>
                <?php elseif ($maqola['status'] == 'Rad etildi' && $maqola['is_rejected'] == 1): ?>
                  <span class="badge badge-danger">Rad etildi</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($maqola['status'] == 'Tasdiqlandi'): ?>
                  <span class="text-muted">Ushbu fayl uchun harakat imkonsiz.</span>
                <?php elseif ($maqola['status'] == 'Kutilmoqda'): ?>
                  <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteMaqola(<?= $maqola['id'] ?>)">
                    <i class="fas fa-trash"></i> O'chirish
                <?php elseif ($maqola['status'] == 'Rad etildi' && $maqola['is_rejected'] == 1): ?>
                  <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#cancelMaqolaModal-<?= $maqola['id'] ?>"><i class="fas fa-question-circle"></i> Sababi</button>
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
<?php foreach ($maqolalar as $maqola): ?>
  <?php if ($maqola['status'] == 'Rad etildi' && $maqola['is_rejected'] == 1): ?>
    <div class="modal fade" id="cancelMaqolaModal-<?= $maqola['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="cancelMaqolaModalLabel-<?= $maqola['id'] ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cancelMaqolaModalLabel-<?= $maqola['id'] ?>">Rad etilgan sababi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Rad etilgan sababi: <?= htmlspecialchars($maqola['rejected_text'] ?? 'Sababi ko\'rsatilmagan') ?>
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section3') ?>";
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section3') ?>";
            }, 1600);
        }); 
    </script>
<?php endif; ?>
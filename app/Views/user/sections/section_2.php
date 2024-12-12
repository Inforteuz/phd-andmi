<!-- Section 2 - Mundarija -->
<div class="tab-pane fade" id="section2" role="tabpanel" aria-labelledby="section2-tab">
  <h5><i class="fas fa-graduation-cap"></i> Ilmiy ishning mundarija asosida bajarilishi</h5>
  <form action="saveMundarija" method="POST" id="section2Form" enctype="multipart/form-data">
    <div class="row">
      <!-- Ta'lim turi -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="educationType1"><i class="fas fa-graduation-cap"></i> Ta'lim turi <span class="text-danger">*</span></label>
          <select class="form-control" id="educationType1" name="educationType" required>
            <option value="" disabled selected>Ta'lim turini tanlang</option>
            <option value="Stajor_taqiqotchi_(PhD)">Stajor taqiqotchi (PhD)</option>
            <option value="Tayanch_doktorant_(PhD)">Tayanch doktorant (PhD)</option>
            <option value="Maqsadli_tayanch_doktorant_(PhD)">Maqsadli tayanch doktorant (PhD)</option>
            <option value="Mustaqil_izlanuvchi_(PhD)">Mustaqil izlanuvchi (PhD)</option>
            <option value="Doktorant_(DSc)">Doktorant (DSc)</option>
            <option value="Maqsadli_doktorantura_(DSc)">Maqsadli doktorantura (DSc)</option>
            <option value="Mustaqil_izlanuvchi_(DSc)">Mustaqil izlanuvchi (DSc)</option>
          </select>
        </div>
      </div>

      <!-- Bosqich -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="stage1"><i class="fas fa-layer-group"></i> Bosqich <span class="text-danger">*</span></label>
          <select class="form-control" id="stage1" name="stage" required>
            <option value="" disabled selected>Bosqichni tanlang</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Raqami -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="number"><i class="fas fa-hashtag"></i> Raqami <span class="text-danger">*</span></label>
          <select class="form-control" id="number" name="number" required>
            <option value="" disabled selected>Raqamni tanlang</option>
            <!-- Raqamlar avtomatik qo'shiladi -->
          </select>
        </div>
      </div>
    </div>

    <!-- Jadval -->
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th><i class="fas fa-tasks"></i> Bajarilishi rejalashtirilgan ishlar</th>
            <th><i class="fas fa-file-upload"></i> Tadqiqotchi tomonidan saytga yuklanadigan hujjatlar</th>
          </tr>
        </thead>
        <tbody id="taskTable">
          <!-- Jadval ma'lumotlari avtomatik qo'shiladi -->
        </tbody>
      </table>
    </div>

    <!-- Qo'shimcha ish haqida izoh -->
    <div class="row">
      <div class="col-md-8">
        <div class="form-group">
          <label for="additionalWork"><i class="fas fa-comment"></i> Qo'shimcha ish bajarilishi bo'yicha izoh <span class="text-danger">*</span></label>
          <textarea class="form-control" id="additionalWork" rows="4" name="additionalWork" placeholder="Ish haqida qo'shimcha izoh kiriting" required></textarea>
        </div>
      </div>
    </div>

    <!-- Fayl yuklash va saqlash -->
    <div class="form-group">
      <label for="fileUpload"><i class="fas fa-file-upload"></i> Fayl yuklash <span class="text-danger">*</span></label>
      <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept=".pdf,.docx" required>
      <small class="form-text text-muted">PDF yoki Word hujjatlarini yuklang</small>
    </div>

    <!-- Pie chart -->
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div style="display: flex; justify-content: center;">
            <h6><i class="fas fa-chart-pie"></i> Umumiy yuklangan fayllar</h6>
            <canvas id="pieChartContainer"></canvas>
          </div>
          <h6>Bajarilgan vazifalar</h6>
          <ul id="taskNames"></ul>
          <p id="totalTasks"></p>
        </div>
      </div>
    </div>

    <!-- Saqlash tugmasi -->
    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-check"></i> Saqlash
      </button>
    </div>
  </form>

  <!-- HR line - Sectionni ajratib turuvchi chiziq -->
  <hr>
  <h6><center><i class="fas fa-table"></i> Qilingan ishlar jadvali</h6></center><br>
  <!-- Qilingan ishlar jadvali -->
  <div class="table-responsive">
    <table class="table table-bordered" id="myTable">
      <thead>
        <tr>
          <th style="width: 3%;"><i class="fas fa-hashtag"></i></th>
          <th><i class="fas fa-graduation-cap"></i> Ta'lim turi</th>
          <th><i class="fas fa-layer-group"></i> Bosqich</th>
          <th><i class="fas fa-hashtag"></i> Raqami</th>
          <th><i class="fas fa-tasks"></i> Bajarilgan ishlar</th>
          <th><i class="fas fa-upload"></i> Yuklangan hujjat vazifasi</th>
          <th><i class="fas fa-comment"></i> Qo'shimcha ish bajarilishi bo'yicha izoh</th>
          <th><i class="fas fa-file"></i> Fayl nomi</th>
          <th><i class="fas fa-circle"></i> Holat</th>
          <th><i class="fas fa-cogs"></i> Harakatlar</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($mundarijaData)): ?>
          <?php foreach ($mundarijaData as $index => $row): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($row['education_type']) ?></td>
              <td><?= htmlspecialchars($row['stage']) ?>-bosqich</td>
              <td><?= htmlspecialchars($row['number']) ?></td>
              <td><?= htmlspecialchars($row['planned_works']) ?></td>
              <td><?= htmlspecialchars($row['researcher_tasks']) ?></td>
              <td><?= htmlspecialchars($row['additional_work']) ?></td>
              <td><?= htmlspecialchars(basename($row['file_url'])) ?></td>
              <td>
                <?php if ($row['status'] === 'Tasdiqlandi'): ?>
                  <span class="badge badge-success"><?= htmlspecialchars($row['status']) ?></span>
                <?php elseif ($row['status'] === 'Kutilmoqda'): ?>
                  <span class="badge badge-warning"><?= htmlspecialchars($row['status']) ?></span>
                <?php else: ?>
                  <span class="badge badge-danger"><?= htmlspecialchars($row['status']) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($row['status'] === 'Tasdiqlandi'): ?>
                  Harakatlar mavjud emas.
                <?php elseif ($row['status'] === 'Kutilmoqda'): ?>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteMundarija(<?= $row['id'] ?>)">
                  <i class="fas fa-trash"></i> O'chirish
                </button>
                <?php elseif ($row['status'] === 'Rad etildi'): ?>
                  <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#reasonModal<?= $row['id'] ?>">
                    <i class="fas fa-question-circle"></i> Sababi
                  </button>
                  <div class="modal fade" id="reasonModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Rad etilgan sababi</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <?= htmlspecialchars($row['rejected_text'] ?: 'Sabab ko\'rsatilmagan.') ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php else: ?>
                  Harakatlar mavjud emas.
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="10" class="text-center">Hozircha ma'lumot mavjud emas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section2') ?>";
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
                window.location.href = "<?= $this->base_url('/user/portfolio#section2') ?>";
            }, 1600);
        }); 
    </script>
<?php endif; ?>
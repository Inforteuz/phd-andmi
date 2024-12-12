<!-- Chiqish Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Akkauntdan chiqish</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><b><?= $_SESSION['fullname'] ?></b> chindan ham akkauntingizdan chiqishni hohlaysizmi?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Bekor qilish</button>
          <a class="btn btn-primary" href="logout">Chiqish</a>
        </div>
      </div>
    </div>
  </div>
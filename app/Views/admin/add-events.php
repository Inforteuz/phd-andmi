<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Event Table on the left side -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tadbirlar Ro'yxati</h6>
                </div>
                <div class="table-responsive card-body">
                    <table class="table table-bordered" id="eventsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tadbir nomi</th>
                                <th>Tadbir tavsifi</th>
                                <th>Boshlanish sanasi va vaqti</th>
                                <th>Kim uchun</th>
                                <th>Harakatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($events)) {
                                echo "<tr><td colspan='6'><center>Tadbirlar mavjud emas</center></td></tr>";
                            } else {
                                foreach ($events as $event) {
                                    $userId = ($event['user_id'] == 'all') ? 'Barcha foydalanuvchilarga' : $event['user_id'];

                                    echo "<tr data-id='{$event['id']}'>
                                            <td>{$event['id']}</td>
                                            <td>{$event['title']}</td>
                                            <td>{$event['description']}</td>
                                            <td>{$event['event_date']}</td>
                                            <td>{$userId}</td>
                                            <td>
                                                <button type='button' class='btn btn-primary btn-sm editEvent' data-toggle='modal' data-target='#editEventModal' data-id='{$event['id']}'>
                                                    <i class='fas fa-edit'></i> Tahrirlash
                                                </button>
                                                <button type='button' class='btn btn-danger btn-sm deleteEvent' data-toggle='modal' data-target='#deleteModal' data-id='{$event['id']}'>
                                                    <i class='fas fa-trash-alt'></i> O'chirish
                                                </button>
                                            </td>
                                        </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Calendar on the right side -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kalendar</h6>
                </div>
                <div class="card-body">
                    <div id="calendar-container">
                        <div id="calendar-header">
                            <button class="btn btn-link date-today" data-calendar-nav="today">Bugun</button>
                            <button class="btn btn-link" data-calendar-nav="prev">Oldingi</button>
                            <button class="btn btn-link" data-calendar-nav="next">Keyingi</button>
                        </div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Tadbir qo'shish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="eventId" />
                        <div class="form-group">
                            <label for="eventTitle">Tadbir nomi</label>
                            <input type="text" class="form-control" id="eventTitle" placeholder="Tadbir nomini kiriting" required>
                        </div>
                        <div class="form-group">
                            <label for="eventDescription">Tadbir tavsifi</label>
                            <textarea class="form-control" id="eventDescription" rows="3" placeholder="Tadbir haqida qisqacha ma'lumot" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="eventStart">Boshlanish vaqti</label>
                            <input type="datetime-local" class="form-control" id="eventStart" required>
                        </div>
                        <div class="form-group">
                            <label for="eventUser">Kim uchun</label>
                            <input type="text" class="form-control" id="eventUser" placeholder="Loginini kiriting">
                            <small class="form-text text-muted">Agar tadbirni barcha foydalanuvchilar uchun belgilamoqchi bo'lsangiz kichik harflarda «all» so'zini yozing.</small>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Saqlash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Tadbirni tahrirlash</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        <input type="hidden" id="editEventId" />
                        <div class="form-group">
                            <label for="editEventTitle">Tadbir nomi</label>
                            <input type="text" class="form-control" id="editEventTitle" placeholder="Tadbir nomini kiriting" required>
                        </div>
                        <div class="form-group">
                            <label for="editEventDescription">Tadbir tavsifi</label>
                            <textarea class="form-control" id="editEventDescription" rows="3" placeholder="Tadbir haqida qisqacha ma'lumot" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editEventStart">Boshlanish vaqti</label>
                            <input type="datetime-local" class="form-control" id="editEventStart" required>
                        </div>
                        <div class="form-group">
                            <label for="editEventUser">Kim uchun</label>
                            <input type="text" class="form-control" id="editEventUser" placeholder="Loginini kiriting">
                            <small class="form-text text-muted">Agar tadbirni barcha foydalanuvchilar uchun belgilamoqchi bo'lsangiz kichik harflarda «all» so'zini yozing.</small>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Saqlash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Tadbirni o'chirish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ushbu tadbirni o'chirishni tasdiqlaysizmi?</p>
                    <form id="deleteEventForm">
                        <input type="hidden" id="deleteEventId" />
                        <button type="submit" class="btn btn-danger">Ha, o'chirilsin</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Yo'q, qaytish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'layouts/footer.php'; ?>
<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/scripts.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales/uz.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', function () { var calendarEl = document.getElementById('calendar'); var events = <?php echo json_encode($events); ?>; console.log(events); var notyf = new Notyf(); var calendar = new FullCalendar.Calendar(calendarEl, { initialView: 'dayGridMonth', locale: 'uz', events: events.map(event => ({ id: event.id, title: event.title, description: event.description, start: event.event_date, user: event.user_id || 'Barcha foydalanuvchilarga' })), dateClick: function(info) { $('#eventModal').modal('show'); $('#eventStart').val(info.dateStr); }, eventClick: function(info) { var event = info.event; $('#editEventModal').modal('show'); $('#editEventId').val(event.id); $('#editEventTitle').val(event.title); $('#editEventDescription').val(event.extendedProps.description); $('#editEventStart').val(event.start.toISOString().slice(0, 16)); $('#editEventUser').val(event.extendedProps.user); } }); calendar.render(); $('#eventForm').submit(function(e) { e.preventDefault(); var title = $('#eventTitle').val(); var description = $('#eventDescription').val(); var start = $('#eventStart').val(); var user = $('#eventUser').val() || ''; if (title && description && start) { var eventData = { title: title, description: description, event_date: start, user: user }; $.ajax({ url: '/admin/add_events', type: 'POST', data: eventData, success: function(response) { var data = JSON.parse(response); if (data.status === 'success') { notyf.success(data.message); calendar.addEvent(eventData); $('#eventModal').modal('hide'); } else { notyf.error(data.message); } }, error: function(jqXHR, textStatus, errorThrown) { console.error('Event creation error:', textStatus, errorThrown, jqXHR.responseText); notyf.error('Xato yuz berdi! Dasturchiga murojaat qiling.'); } }); } else { notyf.error('Barcha maydonlarni to’ldirish kerak'); } }); $('#editEventForm').submit(function(e) { e.preventDefault(); var id = $('#editEventId').val(); var title = $('#editEventTitle').val(); var description = $('#editEventDescription').val(); var start = $('#editEventStart').val(); var user = $('#editEventUser').val() || ''; if (title && description && start) { var updatedEvent = { id: id, title: title, description: description, event_date: start, user: user }; $.ajax({ url: '/admin/update_event', type: 'POST', data: updatedEvent, success: function(response) { var data = JSON.parse(response); if (data.status === 'success') { notyf.success(data.message); calendar.getEventById(id).remove(); calendar.addEvent(updatedEvent); $('#editEventModal').modal('hide'); window.location.reload(); } else { notyf.error(data.message); } }, error: function(jqXHR, textStatus, errorThrown) { console.error('Event update error:', textStatus, errorThrown, jqXHR.responseText); notyf.error('Xato yuz berdi'); } }); } else { notyf.error('Barcha maydonlarni to’ldirish kerak'); } }); $('#deleteEventForm').submit(function(e) { e.preventDefault(); var id = $('#deleteEventId').val(); $.ajax({ url: '/admin/delete_event', type: 'POST', data: { id: id }, success: function(response) { var data = JSON.parse(response); if (data.status === 'success') { notyf.success(data.message); window.location.reload(); calendar.getEventById(id).remove(); $('#deleteModal').modal('hide'); } else { notyf.error(data.message); } }, error: function(jqXHR, textStatus, errorThrown) { console.error('Event deletion error:', textStatus, errorThrown, jqXHR.responseText); notyf.error('Xato yuz berdi'); } }); }); $(document).on('click', '.deleteEvent', function() { var id = $(this).data('id'); $('#deleteEventId').val(id); }); $(document).on('click', '.editEvent', function() { var id = $(this).data('id'); $('#editEventId').val(id); var tr = $(this).closest('tr'); $('#editEventTitle').val(tr.find('td').eq(1).text()); $('#editEventDescription').val(tr.find('td').eq(2).text()); $('#editEventStart').val(tr.find('td').eq(3).text()); $('#editEventUser').val(tr.find('td').eq(4).text()); }); });</script>
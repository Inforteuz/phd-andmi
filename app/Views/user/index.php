<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bosh sahifa</h1>
    </div>
  
    <!-- Content Row -->
    <div class="row">
        <!-- CHECKING FILES CARD -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">TEKSHIRILMOQDA</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $waitingCount = 0;
                                $statusKeys = ['mundarija', 'maqola', 'patents', 'works', 'certificates'];
                                foreach ($statusKeys as $key) {
                                    $waitingCount += $statusCounts[$key]['Kutilmoqda'] ?? 0;
                                }
                                echo $waitingCount;
                                ?> ta
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-spin fa-2x text-warning" style="color: orange !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- APPROVED FILES CARD -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">TASDIQLANGAN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $approvedCount = 0;
                                foreach ($statusKeys as $key) {
                                    $approvedCount += $statusCounts[$key]['Tasdiqlandi'] ?? 0;
                                }
                                echo $approvedCount;
                                ?> ta
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-checker fa-2x text-gray-300" style="color: green !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- REJECTED FILES CARD -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">RAD ETILGAN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $rejectedCount = 0;
                                foreach ($statusKeys as $key) {
                                    $rejectedCount += $statusCounts[$key]['Rad etildi'] ?? 0;
                                }
                                echo $rejectedCount;
                                ?> ta
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ban fa-2x text-gray-300" style="color: red !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row for Scientific Results and Calendar -->
    <div class="row">
        <!-- Scientific Results Card Example -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ilmiy natijalar</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2"><i class="fas fa-circle text-primary"></i> Maqola: <?php echo $scientificCounts['maqola']; ?></span>
                        <span class="mr-2"><i class="fas fa-circle text-success"></i> Patent: <?php echo $scientificCounts['patents']; ?></span>
                        <span class="mr-2"><i class="fas fa-circle text-info"></i> Darslik: <?php echo $scientificCounts['works']; ?></span>
                        <span class="mr-2"><i class="fas fa-circle text-warning"></i> Til: <?php echo $scientificCounts['certificates']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Card Example -->
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
    
    <!-- End Page Content -->
</div>
<!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php include 'layouts/footer.php'; ?>

<!-- Modal: Tadbir -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Tadbir</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Yopish">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="event-title"></h5>
                <p id="event-description"></p>
                <p id="event-time"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Yopish</button>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/scripts.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales/uz.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', function () { var calendarEl = document.getElementById('calendar'); var userEvents = <?php echo json_encode($userEvents); ?>; var calendar = new FullCalendar.Calendar(calendarEl, { initialView: 'dayGridMonth', locale: 'uz', events: userEvents.map(event => ({ title: event.title, start: event.event_date, extendedProps: { description: event.description } })), eventClick: function(info) { var event = info.event; document.getElementById('event-title').innerText = event.title; document.getElementById('event-description').innerText = event.extendedProps.description || 'Ma\'lumot mavjud emas'; document.getElementById('event-time').innerText = new Date(event.start).toLocaleString(); $('#eventModal').modal('show'); }, buttonText: { today: 'Bugun', month: 'Oy', week: 'Hafta', day: 'Kun', list: 'Ro\'yxat' }, weekNumbers: true, weekNumberCalculation: 'ISO', headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' }, footerToolbar: { left: 'today', center: '', right: 'prev,next' }, dayHeaderFormat: { weekday: 'long' }, }); calendar.render(); Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'; Chart.defaults.global.defaultFontColor = '#858796'; var ctx = document.getElementById("myPieChart"); var myPieChart = new Chart(ctx, { type: 'doughnut', data: { labels: ["Maqola", "Patent", "Darslik", "Til sertifikatlari"], datasets: [{ data: [<?php echo $scientificCounts['maqola']; ?>, <?php echo $scientificCounts['patents']; ?>, <?php echo $scientificCounts['works']; ?>, <?php echo $scientificCounts['certificates']; ?>], backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'], hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#e4b100'], hoverBorderColor: "rgba(234, 236, 244, 1)", }] }, options: { maintainAspectRatio: false, tooltips: { backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", borderColor: '#dddfeb', borderWidth: 1, xPadding: 15, yPadding: 15, displayColors: false, caretPadding: 10 }, legend: { display: true }, cutoutPercentage: 80 } }); });</script>
</body>
</html>
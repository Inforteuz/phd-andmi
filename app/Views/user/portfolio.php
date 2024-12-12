<?php

require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';

?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tizim / Portfolio</h1>
    </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Card with sections -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Portfolio bo'limlari</h6>
            </div>
            <div class="card-body">
                <!-- Navigation tabs for sections -->
                <ul class="nav nav-tabs" id="portfolioTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="section1-tab" data-toggle="tab" href="#section1" role="tab" aria-controls="section1" aria-selected="true">Faoliyat</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="section2-tab" data-toggle="tab" href="#section2" role="tab" aria-controls="section2" aria-selected="false">Mundarija</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="section3-tab" data-toggle="tab" href="#section3" role="tab" aria-controls="section3" aria-selected="false">Maqolalar</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="section4-tab" data-toggle="tab" href="#section4" role="tab" aria-controls="section4" aria-selected="false">Patent</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="section5-tab" data-toggle="tab" href="#section5" role="tab" aria-controls="section5" aria-selected="false">Darslik</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="section6-tab" data-toggle="tab" href="#section6" role="tab" aria-controls="section6" aria-selected="false">Til</a>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content" id="portfolioTabsContent"><br>
                    <?php include 'sections/section_1.php'; ?>
                    <?php include 'sections/section_2.php'; ?>
                    <?php include 'sections/section_3.php'; ?>
                    <?php include 'sections/section_4.php'; ?>
                    <?php include 'sections/section_5.php'; ?>
                    <?php include 'sections/section_6.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Content -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<?php include 'layouts/footer.php'; ?>
<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/scripts.php'; ?>
<script>document.addEventListener('DOMContentLoaded', function() {const passportInput = document.getElementById('passportNumber');passportInput.addEventListener('input', function() {let inputVal = passportInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');if (inputVal.length > 9) inputVal = inputVal.substring(0, 9);if (inputVal.length > 2) inputVal = inputVal.substring(0, 2) + ' ' + inputVal.substring(2);passportInput.value = inputVal;const regex = /^[A-Z]{2} \d{7}$/;const passportError = document.getElementById('passportNumberError');if (!regex.test(inputVal)) {passportError.style.display = 'block';passportError.textContent = 'Iltimos, to\'g\'ri formatda kiriting. Masalan: AC 2102749';} else {passportError.style.display = 'none';}});const pniflInput = document.getElementById('pnifl');pniflInput.addEventListener('input', function() {let inputVal = pniflInput.value.replace(/[^0-9]/g, '');if (inputVal.length > 14) inputVal = inputVal.substring(0, 14);pniflInput.value = inputVal;const regex = /^\d{14}$/;const pniflError = document.getElementById('pniflError');if (!regex.test(inputVal)) {pniflError.style.display = 'block';pniflError.textContent = 'Iltimos, faqat 14 ta raqam kiriting.';} else {pniflError.style.display = 'none';}});const faoliyatForm = document.getElementById('faoliyat');faoliyatForm.addEventListener('submit', function(e) {let isValid = true;let passportVal = passportInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');const passportRegex = /^[A-Z]{2} \d{7}$/;const passportError = document.getElementById('passportNumberError');if (!passportRegex.test(passportVal)) {passportError.style.display = 'block';passportError.textContent = 'Iltimos, to\'g\'ri formatda: 2 harf va 7 raqam kiriting (masalan: AC 2805749)';isValid = false;}let pniflVal = pniflInput.value.replace(/[^0-9]/g, '');const pniflRegex = /^\d{14}$/;const pniflError = document.getElementById('pniflError');if (!pniflRegex.test(pniflVal)) {pniflError.style.display = 'block';pniflError.textContent = 'Iltimos, faqat 14 ta raqam kiriting.';isValid = false;}if (!isValid) {/* e.preventDefault(); */}});});</script><script>$.ajax({url: 'getMundarijaChartData', method: 'POST', data: {user_id: '<?= $_SESSION['user_id'] ?>'}, success: function(response) {if (response && response.chartData) {var data = response.chartData, taskNames = response.taskNames, statuses = response.statuses, totalTasks = response.totalTasks, completedTasks = 0, rejectedTasks = 0;if (taskNames && taskNames.length > 0) {taskNames.forEach(function(task, index) {if (statuses && statuses[index] && (statuses[index] === "Tasdiqlandi" || statuses[index] === "Kutilmoqda")) {completedTasks += 1;}if (statuses && statuses[index] && statuses[index] === "Rad etildi") {rejectedTasks += 1;}});}var completedPercentage = totalTasks > 0 ? (completedTasks / totalTasks) * 100 : 0, rejectedPercentage = totalTasks > 0 ? (rejectedTasks / totalTasks) * 100 : 0;completedPercentage = completedPercentage.toFixed(2);rejectedPercentage = rejectedPercentage.toFixed(2);var options = {responsive: true, maintainAspectRatio: false, tooltips: {enabled: true, callbacks: {label: function(tooltipItem, data) {var currentValue = data.datasets[0].data[tooltipItem.index];var percentage = (currentValue / totalTasks) * 100;return tooltipItem.label + ': ' + percentage.toFixed(2) + '%';}}}, plugins: {datalabels: {formatter: function(value, ctx) {var percentage = (value / totalTasks) * 100;return percentage.toFixed(2) + '%';}, color: '#fff', font: {weight: 'bold', size: 14}}}, legend: {display: true, position: 'right'}, cutoutPercentage: 70};var ctx = document.getElementById("pieChartContainer").getContext('2d');var myChart = new Chart(ctx, {type: 'pie', data: data, options: options});var taskNamesText = "";if (taskNames && taskNames.length > 0) {taskNames.forEach(function(task, index) {taskNamesText += (index + 1) + ". " + task + "<br>";});} else {taskNamesText = "Vazifalar mavjud emas.";}document.getElementById("taskNames").innerHTML = taskNamesText;$('#completedPercentage').text('Bajarilgan vazifalar: ' + completedPercentage + '%');$('#rejectedPercentage').text('Rad etilgan vazifalar: ' + rejectedPercentage + '%');$('#totalTasks').text('Umumiy vazifalar: ' + totalTasks + ' ta');$('#completedTasks').text('Bajarilgan vazifalar: ' + completedTasks);$('#rejectedTasks').text('Rad etilgan vazifalar: ' + rejectedTasks);} else {console.error('Diagramma ma\'lumotlari topilmadi.');}}, error: function(xhr, status, error) {console.error("AJAX xatolik: " + error);}});</script>
</body>
</html>
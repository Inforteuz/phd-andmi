$(document).ready(function() {
  const tableConfig = {
    "language": {
      "url": "../assets/vendor/json/uzbek.json"
    },
    "paging": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false
  };

  const tableIds = ['#myTable', '#maqolaTable', '#workTable', '#certificateTable', '#historyTable', '#patentTable', '#eventsTable'];

  tableIds.forEach(function(tableId) {
    $(tableId).DataTable(tableConfig);
  });
});
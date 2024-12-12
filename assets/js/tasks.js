$(document).ready(function() { 
    $('#educationType1').change(function() {
      var educationType = $(this).val();
      var $stageSelect = $('#stage1');
      var $numberSelect = $('#number');
  
      if (educationType === "Tayanch_doktorant_(PhD)" || educationType === "Maqsadli_tayanch_doktorant_(PhD)" || educationType === "Mustaqil_izlanuvchi_(PhD)" || educationType === "Doktorant_(DSc)" || educationType === "Maqsadli_doktorantura_(DSc)" || educationType === "Mustaqil_izlanuvchi_(DSc)") {
        $stageSelect.html('<option value="" disabled selected>Bosqichni tanlang</option><option value="1">1</option><option value="2">2</option><option value="3">3</option>');
      } else {
        $stageSelect.html('<option value="" disabled selected>Bosqichni tanlang</option><option value="1">1</option>');
      }

      $stageSelect.change(function() {
        var stage = $(this).val();
  
        $numberSelect.empty();
        $numberSelect.append('<option value="" disabled selected>Raqamni tanlang</option>');
  
        if (stage === "2") {
          if (educationType.includes('DSc')) {
            for (var i = 1; i <= 7; i++) {
              $numberSelect.append(`<option value="${i}">${i}</option>`);
            }
          } else {
            for (var i = 1; i <= 10; i++) {
              $numberSelect.append(`<option value="${i}">${i}</option>`);
            }
          }
        } else if (stage === "3") {
          if (educationType.includes('DSc')) {
            for (var i = 1; i <= 5; i++) { 
              $numberSelect.append(`<option value="${i}">${i}</option>`);
            }
          } else {
            for (var i = 1; i <= 12; i++) {
              $numberSelect.append(`<option value="${i}">${i}</option>`);
            }
          }
        } else {
          if (educationType === "Doktorant_(DSc)" || educationType === "Maqsadli_doktorantura_(DSc)" || educationType === "Mustaqil_izlanuvchi_(DSc)") {
            for (var i = 1; i <= 8; i++) {
              $numberSelect.append(`<option value="${i}">${i}</option>`);
            }
          } else {
            for (var i = 1; i <= 12; i++) {
              $numberSelect.append(`<option value="${i}">${i}</option>`);
            }
          }
        }
      });
    });

    $('#number').change(function() {
      var number = $(this).val();
      var educationType = $('#educationType1').val();
      var stage = $('#stage1').val();
      var $taskTable = $('#taskTable');
  
      $taskTable.empty();
  
      var tasks;
      if (educationType.includes('DSc')) {
        if (stage == "1") {
          tasks = tasksStage1Dsc;
        } else if (stage == "2") {
          tasks = tasksStage2Dsc;
        } else {
          tasks = tasksStage3Dsc;
        }
      } else {
        if (stage == "1") {
          tasks = tasksStage1;
        } else if (stage == "2") {
          tasks = tasksStage2;
        } else {
          tasks = tasksStage3;
        }
      }

      if (number && tasks[number - 1]) {
        var task = tasks[number - 1];
        $taskTable.append(`<tr><td>${task[0]}</td><td>${task[1]}</td></tr>`);
      }
    });
    
    var tasksStage1 = [
        ["Dissertatsiya mavzusi bo‘yicha yakka tartibdagi rejaning mavjudligi va uning bajarilishi", "Yakka tartibdagi reja"],
        ["Tadqiqot ishiga oid adabiyotlarni tahlil qilish", "Dissertasiyaning 1-bobi 1 va 2 paragraflari"],
        ["Birinchi chorakda bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Birinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Adabiyotlar tahlili natijasi bo‘yicha 1 ta maqola tayyorlash va nashr ettirish", "Nashr ettirilgan maqola"],
        ["Dissertatsiya mavzusi bo‘yicha ilmiy seminar va konferensiyalarda maruza bilan chiqish", "Tezis materiali"],
        ["Bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Ikkinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan"],
        ["Dissertatsiya ishini 1-bobini yakunlash va xulosalar berish", "Dissertasiyaning 1-bobi to‘liq xulosalari bilan"],
        ["Bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va xisobot topshirish", "Uchinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Tadqiqot ishini asoslash bo‘yicha nazariy tadqiqotlar", "Dissertasiyaning 2-bobi birinchi paragrafi"],
        ["Nazariy tahlillar asosida 1 ta maqola tayyorlanadi", "Nashr ettirilgan maqola"],
        ["Institutda bo‘lib o‘tadigan seminarlar, yig‘ilishlar forumlarda faol ishtirok etish", "Ishtirok etganlik holati"],
        ["Bir yil davomida bajargan ilmiy-tadqiqot ishlari yuzasidan monitoring nazoratidan o‘tish", "Yillik hisobot tasdiqlangan holatda fayli"]
      ];

      var tasksStage2 = [
        ["Dissertatsiya mavzusi bo‘yicha konferensiyalarda (jumladan halqaro) ma’ruza bilan qatnashish", "Nashr ettirilgan konferensiya materiallari tezislar"],
        ["Bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Birinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Nazariy jarayonlarning tadqiqotlari", "Tayyorlangan dissertatsiyaning 2-bobi"],
        ["Nazariy tadqiqot natijasi bo‘yicha maqola tayyorlanadi va Respublikadagi jurnallarda chop etiriladi", "Respublika jurnallarida nashr ettirilgan maqolalar"],
        ["Bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Ikkinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan"],
        ["Eksperimental tadqiqot metodikasi bo‘yicha tajriba-sinovi o‘tkazish metodikasini ishlab chiqish", "Tayyorlangan dissertatsiyaning 3-bobi birinchi paragrafi"],
        ["Bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Uchinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Tajriba sinov natijalari usulini ishlab chiqish tadqiqotlari", "Tayyorlangan dissertatsiyaning 3-bob yakuni"],
        ["Tegishli xorijiy jurnalda dissertatsiya mavzusi bo‘yicha kamida bitta maqola chop etish", "Nashr ettirilgan maqola"],
        ["Ikkinchi yil davomida bajargan ilmiy-tadqiqot ishlari yuzasidan monitoring nazoratidan o‘tish", "Yillik hisobot tasdiqlangan holatda fayli"]
      ];

      var tasksStage3 = [
        ["Dissertatsiya mavzusi bo‘yicha ilmiy seminar va konferensiyalarda (jumladan xalqaro) ma’ruza bilan qatnashish", "Konferensiya materiallari"],
        ["Bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Birinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Dissertatsiya mavzusi bo‘yicha ilmiy seminar va konferensiyalarda (jumladan xalqaro) ma’ruza bilan qatnashish", "Konferensiya materiallari"],
        ["Takomillashtirilgan ishlanmani ishlab chiqarish sinovidan o‘tkazish, amaliyotga joriy etish va iqtisodiy samaradorligini aniqlash", "Dissertatsiyani yozilgan 4-bob"],
        ["Tajriba sinov natijasi bo‘yicha maqola nashr ettirish", "Nashr ettirilgan maqola"],
        ["Bajarilgan ishlar bo‘yicha hisobot topshirish", "Ikkinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Tadqiqot natijalarini iqtisodiy samaradorligini bayon qilish", "Ma’lumotnomalar"],
        ["Bajarilgan ishlar bo‘yicha hisobot topshirish", "Uchinchi chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Dissertatsiya asosida avtoreferat tayyorlanadi", "Avtoreferat"],
        ["Dissertatsiyani yozib yakunlash", "Dissertatsiya"],
        ["Dissertatsiya ishining natijalari bo‘yicha seminar o‘tkazish", "Ixtisoslashgan Ilmiy kengash qoshidagi Ilmiy seminar bayonnomasidan ko‘chirma"],
        ["Uchinchi yil davomida bajargan ilmiy-tadqiqot ishlari yuzasidan monitoring nazoratidan o‘tish", "Yillik hisobot tasdiqlangan holatda fayli"]
      ];
      var tasksStage1Dsc = [
        ["Dissertatsiya mavzusi bo‘yicha yakka tartibdagi rejaning mavjudligi va uning bajarilishi", "Yakka tartibdagi reja"],
        ["Dissertatsiyaning birinchi va ikkinchi boblari tayyorligi", "Dissertatsiyaning birinchi va ikkinchi boblari"],
        ["Har chorakda bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Har chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Dissertatsiya mavzusi bo‘yicha tegishli jurnallarda kamida uchta ilmiy maqola chop etilganligi", "3 ta ilmiy maqolalar"],
        ["Dissertatsiya mavzusi bo‘yicha respublika va xalqaro ilmiy konferensiyalar materiallarida kamida bitta ma’ruza tezisi chop etilganligi", "Tezis"],
        ["Dissertatsiya mavzusi bo‘yicha ilmiy konferensiya yoki seminarda ma’ruza qilish", "Tezis"],
        ["Dissertatsiya mavzusi bo‘yicha tahliliy sharh", "Dissertatsiyaning qisqacha loyihasi"],
        ["Dissertatsiya mavzusi bo‘yicha tahliliy sharh natijalari bo‘yicha seminarda so‘zga chiqish", "Bayonnoma"]
      ];

      var tasksStage2Dsc = [
        ["Dissertatsiyaning uchinchi va to‘rtinchi boblari tayyorligi", "Dissertatsiya 3 va 4-boblari"],
        ["Tegishli jurnallarda dissertatsiya mavzusi bo‘yicha hisobot davrida chop etilgan kamida to‘rtta ilmiy maqola e’lon qilinganligi (jumladan bittasi xorijda)", "4 ta ilmiy maqola (jumladan bittasi xorijda)"],
        ["Dissertatsiya mavzusi bo‘yicha xalqaro va respublika ilmiy konferensiyalar materiallarida chop etilgan", "Tezis (kamida bitta ma’ruza tezisining mavjudligi)"],
        ["Har chorakda bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Har chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Dissertatsiya ishining dastlabki natijalari bo‘yicha seminar o‘tkazish", "Dissertatsiyaning dastlabki nusxasi va bayonnoma"],
        ["Konferensiya yoki seminarda ma’ruza bilan qatnashish (kamida bir marta)", "Konferensiyada ishtirok etganlik materiali va tezis"],
        ["Dissertatsiya mavzusi bo‘yicha yakka tartibdagi rejaning bajarilishi to‘g‘risidagi hisobot", "Yakka tartibdagi rejani bajarilganlik bo‘yicha hisobot"]
      ];

      var tasksStage3Dsc = [
        ["Tegishli jurnallarda dissertatsiya mavzusi bo‘yicha hisobot davrida chop etilgan kamida uchta ilmiy maqola e’lon qilinganligi", "3 ta ilmiy maqola"],
        ["Dissertatsiya natijalari bo‘yicha (ijtimoiy-gumanitar fanlar bo‘yicha) chop etilgan monografiyaning mavjudligi", "Monografiya"],
        ["OAK talablariga muvofiq tayyorlangan tugallangan dissertatsiya ishi va avtoreferatning mavjudligi", "Dissertatsiya va avtoreferat"],
        ["Har chorakda bajarilgan ishlar bo‘yicha kafedrada ilmiy seminar o‘tib berish va hisobot topshirish", "Har chorakdagi hisoboti va kafedra bayonnomasi tasdiqlangan holatdagi fayli"],
        ["Dissertatsiya yoki avtoreferatni ilmiy tashkilot yoki ta’lim muassasasi ilmiy-tashkiliy bo‘linmalarida ko‘rib chiqilganligi va muhokama etilganligi", "Seminar bayonni"]
      ];
  });

$(document).ready(function() {
  $('#section2Form').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    var plannedWorks = [];
    var researcherTasks = [];

    $('#taskTable tr').each(function() {
      var plannedWork = $(this).find('td:nth-child(1)').text().trim();
      var researcherTask = $(this).find('td:nth-child(2)').text().trim();

      if (plannedWork && researcherTask) {
        plannedWorks.push(plannedWork);
        researcherTasks.push(researcherTask);
      }
    });

    formData.append('planned_works', JSON.stringify(plannedWorks));
    formData.append('researcher_tasks', JSON.stringify(researcherTasks));

    $.ajax({
      url: 'saveMundarija',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        const notyf = new Notyf();
        notyf.open({
            type: 'success',
            message: 'Mundarija muvaffaqiyatli saqlandi!',
            position: {
                x: 'right',
                y: 'bottom'
            }
        });
        $('#section2Form')[0].reset();
        setTimeout(function() {
            window.location.href = "/user/portfolio";
        }, 1600);
      },
      error: function(xhr, status, error) {
        // Xatolik yuzaga kelganda bildirishnoma ko'rsatish
        const notyf = new Notyf();
        notyf.open({
            type: 'error',
            message: 'Xato yuz berdi: ' + error,
            position: {
                x: 'right',
                y: 'bottom'
            }
        });
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
        const notyf = new Notyf({
            duration: 3000, 
            position: { x: 'right', y: 'bottom' } 
        });

        function confirmDeleteMundarija(id) {
            if (confirm("Haqiqatan ham ushbu yozuvni o'chirmoqchimisiz?")) {
                $.ajax({
                    url: "/user/deleteMundarija",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            notyf.success(response.message);
                            $("#row-" + id).fadeOut(300, function () {
                                $(this).remove();
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1600);
                        } else {
                            notyf.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        notyf.error("Xatolik yuz berdi. Iltimos, qaytadan urinib ko'ring.");
                    }
                });
            }
        }
        window.confirmDeleteMundarija = confirmDeleteMundarija;
    });

document.addEventListener('DOMContentLoaded', function () {
        const notyf = new Notyf({
            duration: 3000, 
            position: { x: 'right', y: 'bottom' } 
        });

        function confirmDeleteMaqola(id) {
            if (confirm("Haqiqatan ham ushbu yozuvni o'chirmoqchimisiz?")) {
                $.ajax({
                    url: "/user/deleteMaqola",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            notyf.success(response.message);
                            $("#row-" + id).fadeOut(300, function () {
                                $(this).remove();
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1600);
                        } else {
                            notyf.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        notyf.error("Xatolik yuz berdi. Iltimos, qaytadan urinib ko'ring.");
                    }
                });
            }
        }
        window.confirmDeleteMaqola = confirmDeleteMaqola;
    });

document.addEventListener('DOMContentLoaded', function () {
        const notyf = new Notyf({
            duration: 3000, 
            position: { x: 'right', y: 'bottom' } 
        });

        function confirmDeletePatent(id) {
            if (confirm("Haqiqatan ham ushbu yozuvni o'chirmoqchimisiz?")) {
                $.ajax({
                    url: "/user/deletePatent",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            notyf.success(response.message);
                            $("#row-" + id).fadeOut(300, function () {
                                $(this).remove();
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1600);
                        } else {
                            notyf.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        notyf.error("Xatolik yuz berdi. Iltimos, qaytadan urinib ko'ring.");
                    }
                });
            }
        }
        window.confirmDeletePatent = confirmDeletePatent;
    });

document.addEventListener('DOMContentLoaded', function () {
        const notyf = new Notyf({
            duration: 3000, 
            position: { x: 'right', y: 'bottom' } 
        });

        function confirmDeleteDarslik(id) {
            if (confirm("Haqiqatan ham ushbu yozuvni o'chirmoqchimisiz?")) {
                $.ajax({
                    url: "/user/deleteDarslik",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            notyf.success(response.message);
                            $("#row-" + id).fadeOut(300, function () {
                                $(this).remove();
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1600);
                        } else {
                            notyf.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        notyf.error("Xatolik yuz berdi. Iltimos, qaytadan urinib ko'ring.");
                    }
                });
            }
        }
        window.confirmDeleteDarslik = confirmDeleteDarslik;
    });

document.addEventListener('DOMContentLoaded', function () {
        const notyf = new Notyf({
            duration: 3000, 
            position: { x: 'right', y: 'bottom' } 
        });

        function confirmDeleteSertifikat(id) {
            if (confirm("Haqiqatan ham ushbu yozuvni o'chirmoqchimisiz?")) {
                $.ajax({
                    url: "/user/deleteSertifikat",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            notyf.success(response.message);
                            $("#row-" + id).fadeOut(300, function () {
                                $(this).remove();
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1600);
                        } else {
                            notyf.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        notyf.error("Xatolik yuz berdi. Iltimos, qaytadan urinib ko'ring.");
                    }
                });
            }
        }
        window.confirmDeleteSertifikat = confirmDeleteSertifikat;
    });

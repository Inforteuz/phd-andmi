const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('password');

togglePassword.addEventListener('click', function () {
    const type = passwordField.type === 'password' ? 'text' : 'password';
    passwordField.type = type;
    this.classList.toggle('fa-eye-slash');
});

$('#loginForm').on('submit', function (event) {
    event.preventDefault();

    let isValid = true;
    let username = $('#username').val().trim();
    let password = $('#password').val().trim();
    let csrfToken = $('input[name="csrf_frontend"]').val();

    if (username.length < 5) {
        $('#usernameError').show().css('opacity', 1);
        $('#username').css('border', '2px solid #e74a3b');
        $('.input-icon').animate({ top: '26px' }, 300);
        isValid = false;
        console.log("Xatoliklar mavjud! Username to'g'ri kiritilmadi.");
    } else {
        $('#usernameError').hide().css('opacity', 0);
        $('#username').css('border', '2px solid #ccc');
        $('.input-icon').animate({ top: '50%' }, 300);
    }

    if (password.length < 5) {
        $('#passwordError').show().css('opacity', 1);
        $('#password').css('border', '2px solid #e74a3b');
        $('.input-icon').animate({ top: '26px' }, 300);
        $('.show-password-btn').animate({ top: '26px' }, 300);
        isValid = false;
        console.log("Xatoliklar mavjud! Parol to'g'ri kiritilmadi.");
    } else {
        $('#passwordError').hide().css('opacity', 0);
        $('#password').css('border', '2px solid #ccc');
        $('.input-icon').animate({ top: '50%' }, 300);
    }

    if (isValid) {
        $.ajax({
            type: 'POST',
            url: '/authenticate',
            data: {
                username: username,
                password: password,
                csrf_frontend: csrfToken
            },
            success: function (response) {
              //  console.log("Serverdan kelgan javob:", response); 
                if (response.success) {
                    const notyf = new Notyf();
                    notyf.open({
                        type: 'success',
                        message: response.message,
                        position: {
                            x: 'right',
                            y: 'bottom'
                        }
                    });

                    if (response.role === 'superadmin' || response.role === 'admin') {
                        setTimeout(function () {
                            window.location.href = "/admin/dashboard";
                        }, 1000);
                    } else if (response.role === 'user') {
                        setTimeout(function () {
                            window.location.href = "/user/dashboard";
                        }, 1000);
                    } else {
                        const notyf = new Notyf();
                        notyf.open({
                            type: 'error',
                            message: 'Foydalanuvchi roli aniqlanmadi.',
                            position: {
                                x: 'right',
                                y: 'bottom'
                            }
                        });
                    }
                } else {
                    const notyf = new Notyf();
                    notyf.open({
                        type: 'error',
                        message: response.message || 'Noto‘g‘ri login yoki parol!',
                        position: {
                            x: 'right',
                            y: 'bottom'
                        }
                    });
                }
            },
            error: function (error) {
              //  console.log("Serverdan kelgan javob:", error);
                const notyf = new Notyf();
                notyf.open({
                    type: 'error',
                    message: 'Xatolik yuz berdi. Iltimos, qayta urinib ko‘ring.',
                    position: {
                        x: 'right',
                        y: 'bottom'
                    }
                });
            }
        });
    } else {
        console.log("Formada xatoliklar mavjud!");
        setTimeout(function () {
            location.reload();
        }, 2000);
    }
});

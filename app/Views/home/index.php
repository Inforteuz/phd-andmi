<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhD-DsC Hisobot Platformasi | Tizimga kirish</title>
    <!-- Bootstrap CSS -->
    <link href="<?= $this->base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="<?= $this->base_url('assets/css/notyf.min.css') ?>" rel="stylesheet">
    <link href="<?= $this->base_url('assets/css/login.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="logo">
            <img src="<?= $this->base_url('assets/img/logo.gif') ?>" alt="Logo">
        </div>

        <!-- Login Form -->
        <h2>Tizimga kirish</h2>
        <form id="loginForm">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_frontend" value="<?= \System\Security\Csrf::generateToken(); ?>">
            <!-- Username input -->
            <div class="form-group">
                <i class="fas fa-user input-icon"></i>
                <input type="text" id="username" class="form-control" name="username" placeholder="Loginni kiriting" required>
                <div id="usernameError" class="form-error">Foydalanuvchi nomini kamida 5 ta belgi bilan kiriting!</div>
            </div>

            <!-- Password input -->
            <div class="form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" id="password" name="password" class="form-control" placeholder="Parolni kiriting" required>
                <i class="fas fa-eye show-password-btn" id="togglePassword"></i>
                <div id="passwordError" class="form-error">Parolni kamida 5 ta belgi bilan kiriting!</div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-custom">
                <i class="fas fa-sign-in-alt"></i> Kirish
            </button>
        </form>

        <!-- Forgot password link -->
        <a href="#" class="forgot-password">Parolni unutdingizmi?</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= $this->base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="<?= $this->base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= $this->base_url('assets/js/notyf.min.js') ?>"></script>
    <script src="<?= $this->base_url('assets/js/login.js') ?>"></script>

    <?php if (isset($logoutMessage)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const notyf = new Notyf();
                notyf.open({
                    type: 'success',
                    message: '<?= $logoutMessage ?>',
                    position: {
                        x: 'right',
                        y: 'bottom'
                    }
                });

                setTimeout(function() {
                    window.location.href = "<?= $this->base_url('/') ?>";
                }, 1200);
            });
        </script>
    <?php endif; ?>
</body>
</html>
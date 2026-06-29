<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PawLib 🐾</title>
    <!-- Impor Google Font Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Impor Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background: #FFF8EE;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        /* Sisi Kiri: Welcoming Panel */
        .left {
            width: 52%;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: linear-gradient(135deg, #FFF0DF 0%, #FBE7D4 100%);
            position: relative;
            overflow: hidden;
            box-shadow: 8px 0 24px rgba(74, 60, 49, 0.04);
        }

        .left-content {
            z-index: 2;
            text-align: center;
            max-width: 440px;
        }

        .left h1 {
            font-size: 58px;
            font-weight: 700;
            color: #2E2118;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .left p {
            font-size: 1.15rem;
            line-height: 1.6;
            color: #6d5b50;
            font-weight: 500;
        }

        /* Decorative paw background prints */
        .left::before {
            content: "🐾";
            font-size: 260px;
            opacity: .04;
            position: absolute;
            bottom: -50px;
            right: -30px;
            transform: rotate(-15deg);
        }

        .left::after {
            content: "🐾";
            font-size: 140px;
            opacity: .03;
            position: absolute;
            top: -20px;
            left: -10px;
            transform: rotate(20deg);
        }

        /* Sisi Kanan: Form Login */
        .right {
            width: 48%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            padding: 40px;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .logo {
            width: 72px;
            height: 72px;
            border-radius: 22px;
            background: #FFF5EC;
            border: 2px solid #ebd5c5;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
            margin: 0 auto 20px;
            color: #E69C62;
            box-shadow: 0 8px 16px rgba(230, 156, 98, 0.1);
        }

        .title {
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            color: #2E2118;
            margin-bottom: 6px;
        }

        .subtitle {
            text-align: center;
            font-size: 0.95rem;
            color: #8c7b70;
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Alert Box */
        .paw-alert {
            background-color: #FCE8E6;
            color: #C5221F;
            border: 1px solid rgba(197, 34, 31, 0.15);
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .paw-alert-success {
            background-color: #E6F4EA;
            color: #137333;
            border: 1px solid rgba(19, 115, 51, 0.15);
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            font-size: 0.9rem;
            font-weight: 700;
            color: #4a3c31;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i.prefix-icon {
            position: absolute;
            left: 16px;
            color: #c8814a;
            font-size: 1.05rem;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            padding-left: 46px;
            font-size: 0.95rem;
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            border-radius: 16px;
            border: 2px solid #ebd5c5;
            color: #4a3c31;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        input::placeholder {
            color: #c0b3a7;
            font-weight: 500;
        }

        input:focus {
            outline: none;
            border-color: #E69C62;
            box-shadow: 0 0 0 4px rgba(230, 156, 98, 0.12);
        }

        /* Show/Hide Password Suffix */
        .password-toggle-btn {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: #c0b3a7;
            cursor: pointer;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: #E69C62;
        }

        .input-password-field {
            padding-right: 48px;
        }

        /* Button */
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 16px;
            background: #E69C62;
            font-size: 1rem;
            font-family: 'Quicksand', sans-serif;
            font-weight: 700;
            color: white;
            margin-top: 10px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(230, 156, 98, 0.25);
            transition: all 0.2s ease;
        }

        button[type="submit"]:hover {
            background: #c8814a;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(230, 156, 98, 0.35);
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 0.85rem;
            color: #8c7b70;
            font-weight: 600;
        }

        .register-link {
            color: #E69C62;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }

        .register-link:hover {
            color: #c8814a;
            text-decoration: underline;
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .left {
                display: none;
            }
            .right {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Panel Kiri: Sambutan User-Oriented -->
        <div class="left">
            <div class="left-content">
                <h1><i class="fas fa-cat" style="color: #E69C62;"></i> PawLib</h1>
                <p>
                    Jelajahi petualangan baru lewat membaca. Temukan e-book, novel, dan buku favoritmu dengan mudah di PawLib! 🐾
                </p>
            </div>
        </div>

        <!-- Panel Kanan: Form Login -->
        <div class="right">
            <div class="login-box">
                <div class="logo">
                    <i class="fas fa-paw"></i>
                </div>

                <div class="title">Selamat Datang!</div>
                <div class="subtitle">Silakan login untuk mulai membaca di PawLib</div>

                <!-- Tampilan Alert Error/Sukses -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="paw-alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= session()->getFlashdata('error') ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="paw-alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?= session()->getFlashdata('success') ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/login') ?>" method="post">
                    <!-- Username Input -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user prefix-icon"></i>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                placeholder="Masukkan username"
                                required
                                value="<?= old('username') ?>"
                            >
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock prefix-icon"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="input-password-field"
                                placeholder="Masukkan password"
                                required
                            >
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye" id="toggle-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit">
                        Masuk 🐾
                    </button>
                </form>

                <div class="footer">
                    Belum punya akun? <a href="<?= base_url('auth/register') ?>" class="register-link">Daftar sekarang</a>
                    <div style="margin-top: 15px; font-size: 0.8rem; opacity: 0.7;">© 2026 PawLib</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toggles Password Visibility -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

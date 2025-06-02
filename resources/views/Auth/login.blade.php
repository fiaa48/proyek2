<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TechFix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #A89986;
            --secondary-color: #8a7866;
            --accent-color: #c5b5a5;
            --light-bg: #F8F9FA;
            --dark-text: #2D3436;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8e8e8 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            display: flex;
            width: 950px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
            background-color: white;
            animation: fadeIn 0.8s ease-in-out;
        }

        .login-sidebar {
            width: 45%;
            padding: 40px;
            color: white;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: relative;
            overflow: hidden;
        }

        .login-sidebar::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .login-sidebar::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .login-sidebar img {
            width: 180px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
            z-index: 1;
            position: relative;
            animation: bounce 2s infinite alternate;
        }

        .login-sidebar h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            font-weight: 700;
            z-index: 1;
            position: relative;
        }

        .login-sidebar p {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.9;
            z-index: 1;
            position: relative;
        }

        .login-form {
            width: 55%;
            padding: 50px;
            background-color: white;
        }

        .login-form h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            text-align: center;
        }

        .login-form h3::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
            border-radius: 3px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(168, 153, 134, 0.25);
        }

        .btn-login {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(168, 153, 134, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 153, 134, 0.4);
            color: white;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: var(--secondary-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .illustration {
            margin-top: 30px;
            z-index: 1;
            position: relative;
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-15px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                width: 90%;
            }

            .login-sidebar, .login-form {
                width: 100%;
            }

            .login-sidebar {
                padding: 30px 20px;
            }

            .login-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-sidebar">
            <img src="https://cdn-icons-png.flaticon.com/512/2452/2452499.png" alt="TechFix Logo">
            <h2>TechFix</h2>
            <p>Panggil TechFix saja. Teknisi kami siap mendatangi kamu di mana saja, gratis antar jemput, bergaransi, dan hanya bayar ketika servis mu selesai diperbaiki.</p>

        </div>
        <div class="login-form">
            <h3 class="text-center mb-4">Masuk</h3>

            <!-- Tampilkan flash message sukses -->
            @if (session('status'))
                <div class="alert alert-success animate__animated animate__fadeIn">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Tampilkan error jika login gagal -->
            @if ($errors->any())
                <div class="alert alert-danger animate__animated animate__shakeX">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    <a href="{{ route('password.form') }}">Lupa Password?</a>
                </div>
                <button type="submit" class="btn-login mb-3">Masuk</button>

                <p class="text-center mt-4">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none" style="color: var(--accent-color); font-weight: 600;">Daftar Sekarang</a></p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

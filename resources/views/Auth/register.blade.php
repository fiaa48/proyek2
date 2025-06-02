<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TechFix</title>
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
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8e8e8 100%);
        }

        .register-container {
            display: flex;
            min-height: 100vh;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .left-panel {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .left-panel::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .left-panel img {
            width: 180px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
            z-index: 1;
            position: relative;
            animation: bounce 2s infinite alternate;
        }

        .left-panel h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            font-weight: 700;
            z-index: 1;
            position: relative;
        }

        .left-panel p {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.9;
            z-index: 1;
            position: relative;
            max-width: 80%;
        }

        .right-panel {
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
        }

        .register-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 450px;
            animation: fadeIn 0.8s ease-in-out;
        }

        .register-box h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
        }

        .register-box h3::after {
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
            box-shadow: 0 0 0 0.25rem rgba(168, 153, 134, 0.15);
        }

        .btn-techfix {
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

        .btn-techfix:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 153, 134, 0.4);
            color: white;
        }

        .btn-secondary {
            background: white;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: var(--primary-color);
            color: white;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: -10px;
            margin-bottom: 10px;
            display: block;
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .form-check-label a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        hr {
            margin: 25px 0;
            opacity: 0.3;
        }

        .illustration {
            margin-top: 30px;
            z-index: 1;
            position: relative;
        }

        .device-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .device-icon {
            width: 50px;
            height: 50px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
            transition: all 0.3s;
        }

        .device-icon:hover {
            transform: translateY(-5px);
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
            .register-container {
                flex-direction: column;
            }

            .left-panel, .right-panel {
                width: 100%;
                padding: 30px 20px;
            }

            .register-box {
                width: 100%;
                max-width: 400px;
                padding: 30px;
            }

            .left-panel p {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Sidebar Kiri -->
        <div class="left-panel">
            <img src="https://cdn-icons-png.flaticon.com/512/2452/2452499.png" alt="TechFix Logo">
            <h2>TechFix</h2>
            <p>Panggil TechFix saja. Teknisi kami siap mendatangi kamu di mana saja, gratis antar jemput, bergaransi, dan hanya bayar ketika urusan selesai diperbaiki.</p>
        </div>

        <!-- Form Registrasi -->
        <div class="right-panel">
            <div class="register-box">
                <h3 class="text-center">Buat Akun Baru</h3>

                <!-- Menampilkan Error Validasi -->
                @if ($errors->any())
                    <div class="alert alert-danger animate__animated animate__shakeX">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                        @error('name') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Nomor Telepon" value="{{ old('phone') }}" required>
                        @error('phone') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Alamat Email" value="{{ old('email') }}" required>
                        @error('email') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password (minimal 8 karakter)" required>
                        @error('password') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    </div>

                    <!-- Checkbox Syarat & Ketentuan -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">Saya menyetujui <a href="#" class="text-decoration-none">syarat dan ketentuan</a></label>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="btn btn-techfix mb-3">Daftar Sekarang</button>
                </form>

                <hr>

                <!-- Link Login -->
                <p class="text-center mb-3">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="btn btn-secondary">Masuk ke Akun Saya</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

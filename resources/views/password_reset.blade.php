<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #EAE6DF;
        }
        .auth-card {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .auth-header {
            background-color: #A89986;
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        .auth-body {
            padding: 2rem;
            background-color: white;
        }
        .btn-primary {
            background-color: #A89986;
            border-color: #A89986;
            padding: 0.75rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #9a8b78;
            border-color: #9a8b78;
        }
        .form-control {
            padding: 0.75rem;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #A89986;
            box-shadow: 0 0 0 0.25rem rgba(168, 153, 134, 0.25);
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #555;
        }
        .text-link {
            color: #A89986;
            font-weight: 500;
        }
        .text-link:hover {
            color: #8a7b68;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <h4 class="mb-0"><i class="fas fa-key me-2"></i>Reset Password</h4>
                    </div>

                    <div class="auth-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.reset') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password_baru" class="form-label">Password Baru</label>
                                <input type="password" id="password_baru" name="password_baru" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-block py-2">
                                    <i class="fas fa-sync-alt me-2"></i>Reset Password
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-link">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome untuk ikon -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

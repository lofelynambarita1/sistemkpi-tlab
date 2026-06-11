<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem KPI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1d4ed8 0%, #0891b2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
        }
        .login-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #2563eb, #0891b2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
        }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(37,99,235,.2); border-color: #2563eb; }
        .btn-primary { background: #2563eb; border-color: #2563eb; border-radius: 10px; padding: .6rem; font-weight: 600; }
        .btn-primary:hover { background: #1d4ed8; border-color: #1d4ed8; }
        .input-group-text { background: #f1f5f9; border-color: #e2e8f0; }
        .form-control { border-color: #e2e8f0; border-radius: 0 8px 8px 0; }
        .input-group .input-group-text { border-radius: 8px 0 0 8px; }
        .divider { display: flex; align-items: center; gap: .75rem; color: #94a3b8; font-size: .8rem; margin: 1.25rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
        <h4 class="text-center fw-bold mb-1">Sistem KPI</h4>
        <p class="text-center text-muted small mb-4">Masuk ke akun Anda</p>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="nama@perusahaan.com" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="pwdField"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePwd">
                        <i class="bi bi-eye" id="pwdIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <div class="divider">atau</div>

        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100" style="border-radius:10px; font-weight:600;">
            <i class="bi bi-person-plus me-2"></i>Buat Akun Baru
        </a>

        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="bi bi-shield-lock me-1"></i>
                Sistem KPI Perusahaan — Akses Terbatas
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePwd').addEventListener('click', function () {
            const pwd  = document.getElementById('pwdField');
            const icon = document.getElementById('pwdIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pwd.type = 'password';
                icon.className = 'bi bi-eye';
            }
        });
    </script>
</body>
</html>
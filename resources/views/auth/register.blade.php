<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Sistem KPI</title>
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
            padding: 2rem 1rem;
        }
        .register-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            width: 100%;
            max-width: 480px;
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
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(37,99,235,.2);
            border-color: #2563eb;
        }
        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
            border-radius: 10px;
            padding: .6rem;
            font-weight: 600;
        }
        .btn-primary:hover { background: #1d4ed8; border-color: #1d4ed8; }
        .input-group-text {
            background: #f1f5f9;
            border-color: #e2e8f0;
        }
        .form-control, .form-select {
            border-color: #e2e8f0;
        }
        .input-group .input-group-text { border-radius: 8px 0 0 8px; }
        .input-group .form-control { border-radius: 0 8px 8px 0; }
        .form-select { border-radius: 8px; }
        .role-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: .75rem 1rem;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .role-card:hover { border-color: #93c5fd; background: #eff6ff; }
        .role-card.selected { border-color: #2563eb; background: #eff6ff; }
        .role-card .role-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .role-card .role-info small { color: #64748b; font-size: .75rem; }
        .divider { border-top: 1px solid #e2e8f0; margin: 1.25rem 0; }
        .step-badge {
            width: 22px; height: 22px;
            background: #2563eb;
            color: #fff;
            border-radius: 50%;
            font-size: .7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: .4rem;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="login-logo">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
        <h4 class="text-center fw-bold mb-1">Buat Akun Baru</h4>
        <p class="text-center text-muted small mb-4">Daftarkan diri Anda ke Sistem KPI</p>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            {{-- STEP 1: Info Pribadi --}}
            <p class="fw-semibold mb-2 text-secondary" style="font-size:.8rem; text-transform:uppercase; letter-spacing:.05em;">
                <span class="step-badge">1</span> Informasi Pribadi
            </p>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama lengkap" required autofocus>
                </div>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="nama@perusahaan.com" required>
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-2 mb-3">
                <div class="col">
                    <label class="form-label fw-semibold small">Departemen <span class="text-muted fw-normal">(opsional)</span></label>
                    <input type="text" name="department"
                           class="form-control @error('department') is-invalid @enderror"
                           value="{{ old('department') }}"
                           placeholder="Contoh: IT, Finance">
                </div>
                <div class="col">
                    <label class="form-label fw-semibold small">Jabatan <span class="text-muted fw-normal">(opsional)</span></label>
                    <input type="text" name="position"
                           class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position') }}"
                           placeholder="Contoh: Staff, Supervisor">
                </div>
            </div>

            <div class="divider"></div>

            {{-- STEP 2: Role --}}
            <p class="fw-semibold mb-2 text-secondary" style="font-size:.8rem; text-transform:uppercase; letter-spacing:.05em;">
                <span class="step-badge">2</span> Pilih Role
            </p>

            @error('role')
                <div class="text-danger small mb-2">{{ $message }}</div>
            @enderror

            <div class="d-flex flex-column gap-2 mb-3">
                <label class="role-card {{ old('role') == 'staff' ? 'selected' : '' }}">
                    <input type="radio" name="role" value="staff" class="d-none" {{ old('role') == 'staff' ? 'checked' : '' }}>
                    <div class="role-icon" style="background:#eff6ff; color:#2563eb;">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div class="role-info">
                        <div class="fw-semibold small">Staff</div>
                        <small>Input & kelola dokumen KPI pribadi</small>
                    </div>
                    <i class="bi bi-check-circle-fill ms-auto text-primary d-none check-icon"></i>
                </label>

                <label class="role-card {{ old('role') == 'hr' ? 'selected' : '' }}">
                    <input type="radio" name="role" value="hr" class="d-none" {{ old('role') == 'hr' ? 'checked' : '' }}>
                    <div class="role-icon" style="background:#f0fdf4; color:#16a34a;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="role-info">
                        <div class="fw-semibold small">HR</div>
                        <small>Review & kelola KPI seluruh karyawan</small>
                    </div>
                    <i class="bi bi-check-circle-fill ms-auto text-success d-none check-icon"></i>
                </label>

                <label class="role-card {{ old('role') == 'manager' ? 'selected' : '' }}">
                    <input type="radio" name="role" value="manager" class="d-none" {{ old('role') == 'manager' ? 'checked' : '' }}>
                    <div class="role-icon" style="background:#fefce8; color:#ca8a04;">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="role-info">
                        <div class="fw-semibold small">Manager</div>
                        <small>Approval & monitoring KPI tim</small>
                    </div>
                    <i class="bi bi-check-circle-fill ms-auto text-warning d-none check-icon"></i>
                </label>
            </div>

            <div class="divider"></div>

            {{-- STEP 3: Password --}}
            <p class="fw-semibold mb-2 text-secondary" style="font-size:.8rem; text-transform:uppercase; letter-spacing:.05em;">
                <span class="step-badge">3</span> Buat Password
            </p>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="pwdField"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 8 karakter" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePwd">
                        <i class="bi bi-eye" id="pwdIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password_confirmation" id="pwdConfirm"
                           class="form-control"
                           placeholder="Ulangi password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePwdConfirm">
                        <i class="bi bi-eye" id="pwdConfirmIcon"></i>
                    </button>
                </div>
                <div id="pwdMatch" class="small mt-1 d-none"></div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </button>

            <p class="text-center small text-muted mb-0">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Masuk di sini</a>
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon  = document.getElementById(iconId);
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
        document.getElementById('togglePwd').addEventListener('click', () => togglePassword('pwdField', 'pwdIcon'));
        document.getElementById('togglePwdConfirm').addEventListener('click', () => togglePassword('pwdConfirm', 'pwdConfirmIcon'));

        // Password match indicator
        const pwd        = document.getElementById('pwdField');
        const pwdConfirm = document.getElementById('pwdConfirm');
        const matchMsg   = document.getElementById('pwdMatch');
        function checkMatch() {
            if (!pwdConfirm.value) { matchMsg.classList.add('d-none'); return; }
            matchMsg.classList.remove('d-none');
            if (pwd.value === pwdConfirm.value) {
                matchMsg.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i><span class="text-success">Password cocok</span>';
            } else {
                matchMsg.innerHTML = '<i class="bi bi-x-circle-fill text-danger me-1"></i><span class="text-danger">Password tidak cocok</span>';
            }
        }
        pwd.addEventListener('input', checkMatch);
        pwdConfirm.addEventListener('input', checkMatch);

        // Role card selection highlight
        document.querySelectorAll('.role-card').forEach(card => {
            const radio = card.querySelector('input[type=radio]');
            const icon  = card.querySelector('.check-icon');

            if (radio.checked) {
                card.classList.add('selected');
                if (icon) icon.classList.remove('d-none');
            }

            card.addEventListener('click', () => {
                document.querySelectorAll('.role-card').forEach(c => {
                    c.classList.remove('selected');
                    const ci = c.querySelector('.check-icon');
                    if (ci) ci.classList.add('d-none');
                });
                card.classList.add('selected');
                radio.checked = true;
                if (icon) icon.classList.remove('d-none');
            });
        });
    </script>
</body>
</html>
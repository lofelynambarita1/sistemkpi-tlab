<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login — Sistem KPI</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/tailwind.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <style>
        .login-bg {
            background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        }
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        .dark .login-card {
            background: rgba(31,41,55,0.95);
        }
        .user-select-item:hover {
            background-color: #FEF2F2;
        }
        .dark .user-select-item:hover {
            background-color: #374151;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center login-bg">
    <div class="login-card rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-700 rounded-xl mx-auto mb-3 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Sistem KPI</h1>
            <p class="text-gray-500 text-sm dark:text-gray-400">Key Performance Indicator</p>
        </div>

        <?php if($errors->any()): ?>
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <!-- Demo User Selector -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Pilih User (Demo)</label>
            <div class="border border-gray-300 rounded-lg overflow-hidden dark:border-gray-600">
                <div class="user-select-item cursor-pointer p-3 border-b border-gray-200 dark:border-gray-600 flex items-center gap-3" onclick="selectUser('rian.associate@company.com', 'password123', 'Rian Pratama', 'Associate', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">RP</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Rian Pratama</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">rian.associate@company.com | Associate</p>
                    </div>
                </div>
                <div class="user-select-item cursor-pointer p-3 border-b border-gray-200 dark:border-gray-600 flex items-center gap-3" onclick="selectUser('dewi.intermediate@company.com', 'password123', 'Dewi Lestari', 'Intermediate', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">DL</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Dewi Lestari</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">dewi.intermediate@company.com | Intermediate</p>
                    </div>
                </div>
                <div class="user-select-item cursor-pointer p-3 border-b border-gray-200 dark:border-gray-600 flex items-center gap-3" onclick="selectUser('andi.senior@company.com', 'password123', 'Andi Wijaya', 'Senior', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">AW</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Andi Wijaya</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">andi.senior@company.com | Senior</p>
                    </div>
                </div>
                <div class="user-select-item cursor-pointer p-3 border-b border-gray-200 dark:border-gray-600 flex items-center gap-3" onclick="selectUser('sari.principle@company.com', 'password123', 'Sari Indah', 'Principle', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">SI</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Sari Indah</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">sari.principle@company.com | Principle</p>
                    </div>
                </div>
                <div class="user-select-item cursor-pointer p-3 border-b border-gray-200 dark:border-gray-600 flex items-center gap-3" onclick="selectUser('budi.lead@company.com', 'password123', 'Budi Santosa', 'Lead', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">BS</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Budi Santosa</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">budi.lead@company.com | Lead</p>
                    </div>
                </div>
                <div class="user-select-item cursor-pointer p-3 border-b border-gray-200 dark:border-gray-600 flex items-center gap-3" onclick="selectUser('maya.leadhr@company.com', 'password123', 'Maya Putri', 'Lead HR', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">MP</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Maya Putri</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">maya.leadhr@company.com | Lead HR</p>
                    </div>
                </div>
                <div class="user-select-item cursor-pointer p-3 border-b border-gray-200 dark:border-gray-600 flex items-center gap-3" onclick="selectUser('hendra.manager@company.com', 'password123', 'Hendra Kusuma', 'Manager', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">HK</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Hendra Kusuma</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">hendra.manager@company.com | Manager</p>
                    </div>
                </div>
                <div class="user-select-item cursor-pointer p-3 flex items-center gap-3" onclick="selectUser('tata.admin@company.com', 'password123', 'Tata Permana', 'Admin', this)">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 text-xs font-bold">TP</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Tata Permana</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">tata.admin@company.com | Admin</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative flex items-center mb-4">
            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-sm">atau login manual</span>
            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
        </div>

        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" required autocomplete="email" value="<?php echo e(old('email')); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       placeholder="rian.associate@company.com">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password" required autocomplete="current-password" minlength="6"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       placeholder="••••••••">
                <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Password default: <code class="bg-gray-100 px-1 rounded dark:bg-gray-700">password123</code></p>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Role</label>
                <input type="text" id="role" disabled
                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400"
                       placeholder="Role akan terdeteksi otomatis">
            </div>
            <button type="submit" class="btn-primary w-full">Login</button>
        </form>
        <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>Hubungi Admin untuk pembuatan akun</p>
        </div>
    </div>

    <script>
    function selectUser(email, password, name, role, element) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        document.getElementById('role').value = role + ' — ' + name;
        document.querySelectorAll('.user-select-item').forEach(el => el.classList.remove('bg-red-50', 'dark:bg-gray-700'));
        element.classList.add('bg-red-50', 'dark:bg-gray-700');
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('kpi_dark_mode') === 'true') {
            document.body.classList.add('dark');
        }
    });
    </script>
</body>
</html>
<?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/auth/login.blade.php ENDPATH**/ ?>
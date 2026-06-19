<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Sistem KPI</title>
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center login-bg p-4">
    <div class="login-card rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-700 rounded-xl mx-auto mb-3 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Akun Baru</h1>
            <p class="text-gray-500 text-sm dark:text-gray-400">Sistem Key Performance Indicator</p>
        </div>

        @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="255"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="John Doe">
                </div>
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="nama@company.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required minlength="8"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Min. 8 karakter">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Ulangi password">
                </div>
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Departemen</label>
                    <input type="text" id="department" name="department" value="{{ old('department') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Engineering">
                </div>
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Jabatan</label>
                    <input type="text" id="position" name="position" value="{{ old('position') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="Software Engineer">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Role <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['staff' => 'Staff KPI', 'hr' => 'HR', 'manager' => 'Manager'] as $val => $label)
                        <label class="flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition
                                    {{ old('role') == $val ? 'border-red-700 bg-red-50' : 'border-gray-300 hover:border-red-400' }}">
                            <input type="radio" name="role" value="{{ $val }}" {{ old('role') == $val ? 'checked' : '' }} class="sr-only">
                            <span class="text-sm font-medium {{ old('role') == $val ? 'text-red-700' : 'text-gray-700' }}">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-primary w-full mt-6">Daftar</button>
        </form>
        <div class="mt-4 text-center text-sm text-gray-500">
            <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-red-700 hover:underline">Login di sini</a></p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Berakhir — Sistem KPI</title>
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        }
    </style>
</head>
<body class="bg-gradient min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-8 h-8 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Sesi Berakhir</h1>
        <p class="text-gray-500 mb-6">
            Halaman yang Anda akses telah expired karena sesi login tidak valid atau terlalu lama tidak aktif.
            Silakan login kembali untuk melanjutkan.
        </p>
        <a href="{{ route('login') }}" class="inline-block bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-6 rounded-lg transition">
            Kembali ke Login
        </a>
        <p class="mt-4 text-xs text-gray-400">
            Sistem KPI — Internal Login (Sesuai SPOK)
        </p>
    </div>
</body>
</html>

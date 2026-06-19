@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center max-w-md">
        <div class="w-20 h-20 bg-red-100 rounded-full mx-auto mb-5 flex items-center justify-center">
            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m9.364-7.364A9 9 0 1112 3a9 9 0 017.364 4.636z"/>
            </svg>
        </div>
        <h1 class="text-6xl font-bold text-red-700 mb-2">403</h1>
        <p class="text-xl font-semibold text-gray-800 mb-2">Akses Ditolak</p>
        <p class="text-gray-500 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}" class="btn-primary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection

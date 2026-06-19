@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li><a href="{{ route('admin.users.index') }}" class="text-red-700 hover:underline">Manajemen User</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Detail Pengguna</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Detail Pengguna</h1>
    <p class="text-gray-600">Informasi lengkap akun karyawan</p>
</header>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <div class="bg-red-100 text-red-700 rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div><p class="text-gray-500">Role</p><p class="font-medium">{{ $user->role_label }}</p></div>
        <div><p class="text-gray-500">Jabatan</p><p class="font-medium">{{ $user->jabatan ?? '-' }}</p></div>
        <div><p class="text-gray-500">Divisi</p><p class="font-medium">{{ $user->department ?? '-' }}</p></div>
        <div><p class="text-gray-500">Atasan</p><p class="font-medium">{{ $user->atasan->name ?? '-' }}</p></div>
        <div><p class="text-gray-500">Status</p>
            @if($user->is_active)
                <span class="badge badge-aktif">AKTIF</span>
            @else
                <span class="badge badge-dicabut">NONAKTIF</span>
            @endif
        </div>
    </div>
    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Profil Admin')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Profil Saya</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
    <p class="text-gray-600">Kelola informasi akun Anda</p>
</header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Profil Card --}}
    <div class="bg-white rounded-lg shadow p-6 lg:col-span-1">
        <div class="text-center mb-6">
            <div class="w-24 h-24 bg-red-100 rounded-full mx-auto mb-3 flex items-center justify-center text-3xl font-bold text-red-700">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <h2 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            @if($user->is_active)
                <span class="badge badge-aktif mt-2">AKTIF</span>
            @else
                <span class="badge badge-dicabut mt-2">NONAKTIF</span>
            @endif
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Role</span>
                <span class="font-medium text-gray-800">{{ $user->role_label ?? ucfirst(str_replace('_', ' ', $user->role)) }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Jabatan</span>
                <span class="font-medium text-gray-800">{{ $user->jabatan ?? '-' }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Divisi</span>
                <span class="font-medium text-gray-800">{{ $user->divisi ?? '-' }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Tanggal Bergabung</span>
                <span class="font-medium text-gray-800">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Edit Profil --}}
    <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Edit Profil</h2>
        <form method="POST" action="{{ route('admin.profile.update') }}" class="max-w-lg">
            @csrf @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="text" value="{{ $user->email }}" disabled
                       class="w-full px-3 py-2 border border-gray-200 bg-gray-50 rounded-md text-sm text-gray-500">
            </div>
            <div class="mb-4">
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('jabatan') border-red-500 @enderror">
                @error('jabatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                <input type="text" id="divisi" name="divisi" value="{{ old('divisi', $user->divisi) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('divisi') border-red-500 @enderror">
                @error('divisi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <hr class="my-4">
            <p class="text-sm font-medium text-gray-700 mb-4">Ubah Password <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span></p>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password" minlength="8"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('password') border-red-500 @enderror"
                       placeholder="Minimal 8 karakter">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" minlength="8"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700"
                       placeholder="Ulangi password baru">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('dashboard') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

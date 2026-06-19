@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li><a href="{{ route('admin.users.index') }}" class="text-red-700 hover:underline">Manajemen User</a></li>
        <li>/</li>
        <li class="text-gray-700">Edit User</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
    <p class="text-gray-600">Perbaharui informasi akun karyawan</p>
</header>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="255"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('name') border-red-500 @enderror"
                   placeholder="Rian Pratama">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('email') border-red-500 @enderror"
                   placeholder="rian.associate@company.com">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" required maxlength="100"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('jabatan') border-red-500 @enderror"
                   placeholder="Software Engineer">
            @error('jabatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1">Divisi <span class="text-red-500">*</span></label>
            <input type="text" id="divisi" name="divisi" value="{{ old('divisi', $user->department) }}" required maxlength="100"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('divisi') border-red-500 @enderror"
                   placeholder="Engineering">
            @error('divisi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
            <select id="role" name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('role') border-red-500 @enderror">
                <option value="">-- Pilih Role --</option>
                @foreach(['associate','intermediate','senior','lead','principle','lead_hr','hr','manager','admin'] as $r)
                <option value="{{ $r }}" {{ old('role', $user->role) == $r ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $r)) }}</option>
                @endforeach
            </select>
            @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="atasan_id" class="block text-sm font-medium text-gray-700 mb-1">Atasan</label>
            <select id="atasan_id" name="atasan_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
                <option value="">-- Tanpa Atasan --</option>
                @foreach($users as $u)
                <option value="{{ $u->id }}" {{ old('atasan_id', $user->atasan_id) == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->role_label }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input type="password" id="password" name="password" minlength="8" maxlength="255"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 @error('password') border-red-500 @enderror"
                   placeholder="Kosongkan jika tidak diubah">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" minlength="8"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700"
                   placeholder="Kosongkan jika tidak diubah">
        </div>
        <div class="mb-4">
            <label for="status_akun" class="block text-sm font-medium text-gray-700 mb-1">Status Akun</label>
            <select id="status_akun" name="status_akun" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
                <option value="aktif" {{ old('status_akun', $user->is_active ? 'aktif' : 'nonaktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status_akun', $user->is_active ? 'aktif' : 'nonaktif') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection

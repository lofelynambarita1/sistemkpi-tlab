@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-800">Detail Pengguna</h1>
    <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
    </a>
</div>
<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <div class="bg-indigo-100 text-indigo-700 rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div><p class="text-gray-500">Role</p><p class="font-medium">{{ ucfirst(str_replace('_',' ',$user->role)) }}</p></div>
        <div><p class="text-gray-500">Jabatan</p><p class="font-medium">{{ $user->jabatan ?? '-' }}</p></div>
        <div><p class="text-gray-500">Divisi</p><p class="font-medium">{{ $user->divisi ?? '-' }}</p></div>
        <div><p class="text-gray-500">Status</p>
            @if($user->is_active)
                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Aktif</span>
            @else
                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs">Nonaktif</span>
            @endif
        </div>
    </div>
    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" onsubmit="return confirm('Reset password ke password123?')">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Reset Password</button>
        </form>
    </div>
</div>
@endsection

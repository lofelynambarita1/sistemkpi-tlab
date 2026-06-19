@extends('layouts.app')
@section('title', 'Manajemen User')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700">Manajemen User</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
    <p class="text-gray-600">Pengelolaan akun karyawan dan hierarki</p>
</header>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex gap-3 mb-4">
        <form method="GET" class="flex-1 flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari karyawan..." class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
            <button type="submit" class="btn-primary">Cari</button>
            @if(request('search') || request('role') || request('status'))
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.users.export') }}" class="btn-secondary">Export Excel</a>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">+ Tambah User</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Atasan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $u)
                <tr>
                    <td class="px-4 py-4 font-medium text-gray-800">{{ $u->name }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $u->email }}</td>
                    <td class="px-4 py-4"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs">{{ $u->role_label }}</span></td>
                    <td class="px-4 py-4 text-gray-600">{{ $u->jabatan ?? '-' }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $u->atasan->name ?? '-' }}</td>
                    <td class="px-4 py-4">
                        @if($u->is_active)
                            <span class="badge badge-aktif">AKTIF</span>
                        @else
                            <span class="badge badge-dicabut">NONAKTIF</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right">
                        <a href="{{ route('admin.users.edit', $u) }}" class="text-blue-600 hover:underline text-sm mr-3">Edit</a>
                        <form method="POST" action="{{ route('admin.users.toggle-status', $u) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline text-sm mr-3">{{ $u->is_active ? 'Nonaktif' : 'Aktifkan' }}</button>
                        </form>
                        <button type="button"
                            class="text-red-600 hover:underline text-sm"
                            data-delete-url="{{ route('admin.users.destroy', $u) }}"
                            data-delete-desc="User {{ $u->name }} akan dihapus permanen.">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada pengguna ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
<div class="mt-4">{{ $users->links() }}</div>
@endif
@endsection

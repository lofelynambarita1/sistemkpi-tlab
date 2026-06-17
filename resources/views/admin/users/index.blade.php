@extends('layouts.app')
@section('title', 'Management User')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Management User</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola seluruh akun pengguna sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition">
        <i class="fa-solid fa-plus"></i> Tambah Pengguna
    </a>
</div>
<form method="GET" class="mb-4 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, divisi..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1 focus:outline-none focus:ring-2 focus:ring-indigo-300">
    <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm"><i class="fa-solid fa-search"></i></button>
</form>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Role</th>
                <th class="px-4 py-3 text-left">Divisi</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                <td class="px-4 py-3"><span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full text-xs font-medium">{{ $user->role }}</span></td>
                <td class="px-4 py-3 text-gray-600">{{ $user->divisi ?? '-' }}</td>
                <td class="px-4 py-3">
                    @if($user->is_active)
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs">Nonaktif</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-gray-500 hover:text-indigo-600"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-500 hover:text-yellow-600"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">@csrf<button type="submit" class="text-gray-500 hover:text-blue-600"><i class="fa-solid {{ $user->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i></button></form>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">@csrf @method('DELETE')<button type="submit" class="text-gray-500 hover:text-red-600"><i class="fa-solid fa-trash"></i></button></form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection

@extends('layouts.app')
@section('title', 'Export User')
@push('styles')
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
@endpush
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li><a href="{{ route('admin.users.index') }}" class="text-red-700 hover:underline">Manajemen User</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Export User</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Export Data User</h1>
    <p class="text-gray-600">Download informasi profil seluruh user yang terdaftar dalam format Excel</p>
</header>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-center gap-4 mb-4">
        <div class="p-3 bg-green-50 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-800">Export Profil User</h3>
            <p class="text-sm text-gray-500">File akan berisi semua kolom profil: nama, email, role, jabatan, divisi, atasan, dan status akun.</p>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h4 class="font-medium text-gray-800 mb-2">Ringkasan Data:</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white border rounded p-3 text-center">
                <div class="text-2xl font-bold text-red-700">{{ $total }}</div>
                <div class="text-xs text-gray-500">Total User</div>
            </div>
            <div class="bg-white border rounded p-3 text-center">
                <div class="text-2xl font-bold text-green-600">{{ $aktif }}</div>
                <div class="text-xs text-gray-500">Status Aktif</div>
            </div>
            <div class="bg-white border rounded p-3 text-center">
                <div class="text-2xl font-bold text-gray-700">{{ $karyawan }}</div>
                <div class="text-xs text-gray-500">Role Karyawan</div>
            </div>
            <div class="bg-white border rounded p-3 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $adminManager }}</div>
                <div class="text-xs text-gray-500">Role Admin/Manager</div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto mb-4">
        <table class="min-w-full divide-y divide-gray-200" id="preview-table">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Divisi</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Atasan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="preview-rows">
                @foreach($users as $u)
                <tr>
                    <td class="px-4 py-2 text-sm">{{ $u->name }}</td>
                    <td class="px-4 py-2 text-sm">{{ $u->email }}</td>
                    <td class="px-4 py-2 text-sm">{{ $u->role_label }}</td>
                    <td class="px-4 py-2 text-sm">{{ $u->jabatan ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $u->department ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $u->atasan->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @if($u->is_active)
                            <span class="badge badge-aktif">AKTIF</span>
                        @else
                            <span class="badge badge-dicabut">NONAKTIF</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Kembali</a>
        <button onclick="exportUsers()" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download Excel
        </button>
    </div>
</div>

@push('scripts')
<script>
function exportUsers() {
    const rows = [];
    document.querySelectorAll('#preview-rows tr').forEach(tr => {
        const cols = tr.querySelectorAll('td');
        rows.push({
            'Nama': cols[0].textContent.trim(),
            'Email': cols[1].textContent.trim(),
            'Role': cols[2].textContent.trim(),
            'Jabatan': cols[3].textContent.trim(),
            'Divisi': cols[4].textContent.trim(),
            'Atasan': cols[5].textContent.trim(),
            'Status': cols[6].textContent.trim()
        });
    });
    const ws = XLSX.utils.json_to_sheet(rows);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Data User');
    XLSX.writeFile(wb, 'Data_User_Sistem_KPI.xlsx');
}
</script>
@endpush
@endsection

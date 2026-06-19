@extends('layouts.app')
@section('title', 'Dashboard Karyawan')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard KPI</h1>
    <p class="text-gray-600">Ringkasan penilaian kinerja karyawan</p>
    <p class="text-sm text-gray-500 mt-1">Login sebagai: <strong>{{ $user->name }}</strong> ({{ $user->role_label }})</p>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total KPI</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKpi }}</p>
        <p class="text-sm text-gray-400">Total dokumen KPI</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Disetujui</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $approved }}</p>
        <p class="text-sm text-gray-400">KPI telah di-approve</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Menunggu Review</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $submitted }}</p>
        <p class="text-sm text-gray-400">Menunggu persetujuan</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Perlu Revisi</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $needRevision }}</p>
        <p class="text-sm text-gray-400">Dokumen perlu direvisi</p>
    </div>
</div>

@if($latestKpi)
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen KPI Terbaru</h3>
    <div class="flex items-center justify-between mb-3">
        <div>
            <p class="font-semibold text-gray-800">KPI {{ $latestKpi->period_year }}</p>
            <p class="text-sm text-gray-500">Dibuat {{ $latestKpi->created_at->diffForHumans() }}</p>
        </div>
        <span class="badge badge-{{ $latestKpi->status }}">{{ $latestKpi->status_label }}</span>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('kpi.show', $latestKpi->id) }}" class="btn-primary">Lihat</a>
        @if(in_array($latestKpi->status, ['draft', 'need_revision']))
        <a href="{{ route('kpi.edit', $latestKpi->id) }}" class="btn-secondary">Edit</a>
        @endif
    </div>
    @if($draft > 0)
    <div class="mt-3 px-4 py-3 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Kamu punya <strong>{{ $draft }}</strong> dokumen draft yang belum disubmit.
    </div>
    @endif
    @if($needRevision > 0)
    <div class="mt-3 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <strong>{{ $needRevision }}</strong> dokumen perlu direvisi.
    </div>
    @endif
</div>
@endif

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('kpi.create') }}" class="btn-primary">Isi Form KPI</a>
        <a href="{{ route('kpi.index') }}" class="btn-secondary">Lihat History</a>
        <a href="{{ route('profile.show') }}" class="btn-secondary">Profil Saya</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Semua Dokumen KPI</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diperbarui</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($myKpis->take(5) as $doc)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">KPI {{ $doc->period_year }}</td>
                    <td class="px-4 py-3 text-sm"><span class="badge badge-{{ $doc->status }}">{{ $doc->status_label }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $doc->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-sm">
                        <a href="{{ route('kpi.show', $doc->id) }}" class="btn-primary" style="padding:0.25rem 0.75rem;">Lihat</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="mb-3">Belum ada dokumen KPI</p>
                        <a href="{{ route('kpi.create') }}" class="btn-primary">Buat Sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

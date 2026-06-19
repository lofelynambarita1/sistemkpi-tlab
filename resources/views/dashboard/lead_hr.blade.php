@extends('layouts.app')
@section('title', 'Dashboard Lead HR')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard {{ $user->role_label }}</h1>
    <p class="text-gray-600">Kelola &amp; Review Dokumen KPI Seluruh Bawahan</p>
    <p class="text-sm text-gray-500 mt-1">Login sebagai: <strong>{{ $user->name }}</strong> ({{ $user->role_label }})</p>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Bawahan</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBawahan }}</p>
        <p class="text-sm text-gray-400">Seluruh staff di bawah kamu</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Menunggu Review</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $kpiMenunggu }}</p>
        <p class="text-sm text-gray-400">Perlu ditinjau</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Disetujui</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $kpiApproved }}</p>
        <p class="text-sm text-gray-400">Telah di-approve</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Perlu Revisi</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $kpiDitolak }}</p>
        <p class="text-sm text-gray-400">Ditolak / perlu revisi</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Rekap Status KPI Bawahan</h3>
    @php
    $statusColors = [
        'draft' => '#475569', 'submitted' => '#f59e0b',
        'approved' => '#16a34a', 'need_revision' => '#dc2626',
    ];
    $statusLabels = [
        'draft' => 'Draft', 'submitted' => 'Menunggu Review',
        'approved' => 'Disetujui', 'need_revision' => 'Perlu Revisi',
    ];
    $total = max($statusStats->sum(), 1);
    @endphp
    @forelse($statusStats as $status => $count)
    @php
    $color = $statusColors[$status] ?? '#6b7280';
    $label = $statusLabels[$status] ?? ucfirst($status);
    $pct = round(($count / $total) * 100);
    @endphp
    <div class="mb-4 last:mb-0">
        <div class="flex items-center justify-between mb-1">
            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
            <span class="text-sm font-bold" style="color:{{ $color }}">{{ $count }} ({{ $pct }}%)</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="h-2.5 rounded-full" style="width:{{ $pct }}%; background:{{ $color }};"></div>
        </div>
    </div>
    @empty
    <p class="text-gray-500 text-sm">Belum ada dokumen KPI dari bawahan.</p>
    @endforelse
    @if($kpiMenunggu > 0)
    <div class="mt-4">
        <a href="{{ route('hr.kpi.index') }}" class="btn-primary">Review {{ $kpiMenunggu }} Dokumen Sekarang</a>
    </div>
    @endif
</div>
@endsection

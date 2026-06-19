@extends('layouts.app')
@section('title', 'Dashboard — KPI ' . $year)
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard KPI</h1>
    <p class="text-gray-600">Periode {{ $year }} &middot; {{ $user->role_label }}</p>
    <p class="text-sm text-gray-500 mt-1">Login sebagai: <strong>{{ $user->name }}</strong> ({{ $user->role_label }})</p>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Target Tahunan</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($target->target_total, 0) }}</p>
        <p class="text-sm text-gray-400">Target point minimal 1 tahun</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Total Capaian</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($target->capaian_total, 0) }}</p>
        <p class="text-sm text-gray-400">Capaian saat ini</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Persentase Capaian</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $target->persentase_total }}%</p>
        <p class="text-sm text-gray-400">{{ $year }} &mdash; Progres</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600">
        <p class="text-sm text-gray-500">Dokumen KPI</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $recentDocs->count() }}</p>
        <p class="text-sm text-gray-400">Total dokumen tersedia</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Target Capaian Tahunan {{ $year }}</h3>
        @php
        $items = [
            ['label' => 'Jobdesc', 'color' => '#2563eb', 'pct' => $target->persentase_jobdesc, 'capaian' => $target->capaian_jobdesc, 'target' => $target->target_jobdesc],
            ['label' => 'Continues Improvement', 'color' => '#16a34a', 'pct' => $target->persentase_ci, 'capaian' => $target->capaian_continues_improvement, 'target' => $target->target_continues_improvement],
            ['label' => 'Self Development', 'color' => '#ca8a04', 'pct' => $target->persentase_sd, 'capaian' => $target->capaian_self_development, 'target' => $target->target_self_development],
            ['label' => 'HR Activity', 'color' => '#7c3aed', 'pct' => $target->persentase_hr, 'capaian' => $target->capaian_hr_activity, 'target' => $target->target_hr_activity],
            ['label' => 'Kinerja Perilaku', 'color' => '#0891b2', 'pct' => $target->persentase_perilaku, 'capaian' => $target->capaian_kinerja_perilaku, 'target' => $target->target_kinerja_perilaku],
        ];
        @endphp
        <div class="space-y-4">
            @foreach($items as $item)
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ $item['label'] }}</span>
                    <span class="text-sm font-bold" style="color:{{ $item['color'] }}">{{ $item['pct'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="h-2.5 rounded-full" style="width:{{ $item['pct'] }}%; background:{{ $item['color'] }};"></div>
                </div>
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-500">Capaian: <strong>{{ number_format($item['capaian'], 1) }}</strong></span>
                    <span class="text-xs text-gray-500">Target: <strong>{{ number_format($item['target'], 1) }}</strong></span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen KPI Terbaru</h3>
        @forelse($recentDocs as $doc)
        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
            <div>
                <p class="font-semibold text-gray-800 text-sm">KPI {{ $doc->period_year }}</p>
                <p class="text-xs text-gray-500">Diperbarui {{ $doc->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge badge-{{ $doc->status }}">{{ $doc->status_label }}</span>
                <a href="{{ route('kpi.show', $doc->id) }}" class="btn-secondary text-xs" style="padding:0.25rem 0.75rem;">Lihat</a>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="mb-3">Belum ada dokumen KPI</p>
            <a href="{{ route('kpi.create') }}" class="btn-primary">Buat Sekarang</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

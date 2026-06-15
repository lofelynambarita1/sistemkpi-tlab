@extends('layouts.app')

@section('title', 'Dashboard Lead HR')

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard {{ $user->role_label }}
        </h4>
        <small class="text-muted">Kelola & Review Dokumen KPI Seluruh Bawahan</small>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
            <i class="bi bi-people stat-icon"></i>
            <div class="stat-value">{{ $totalBawahan }}</div>
            <div class="stat-label">Total Bawahan</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#fbbf24);">
            <i class="bi bi-hourglass-split stat-icon"></i>
            <div class="stat-value">{{ $kpiMenunggu }}</div>
            <div class="stat-label">Menunggu Review</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#16a34a,#22c55e);">
            <i class="bi bi-check-circle-fill stat-icon"></i>
            <div class="stat-value">{{ $kpiApproved }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#dc2626,#f87171);">
            <i class="bi bi-x-circle-fill stat-icon"></i>
            <div class="stat-value">{{ $kpiDitolak }}</div>
            <div class="stat-label">Perlu Revisi</div>
        </div>
    </div>
</div>

{{-- Status Breakdown --}}
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-bar-chart-fill text-primary me-2"></i>Rekap Status KPI Bawahan
    </div>
    <div class="card-body">
        @php
            $statusColors = [
                'draft'         => ['bg' => '#475569', 'label' => 'Draft'],
                'submitted'     => ['bg' => '#f59e0b', 'label' => 'Menunggu Review'],
                'approved'      => ['bg' => '#16a34a', 'label' => 'Disetujui'],
                'need_revision' => ['bg' => '#dc2626', 'label' => 'Perlu Revisi'],
            ];
            $total = $statusStats->sum() ?: 1;
        @endphp

        @forelse($statusStats as $status => $count)
            @php
                $color = $statusColors[$status]['bg'] ?? '#6b7280';
                $label = $statusColors[$status]['label'] ?? ucfirst($status);
                $pct   = round(($count / $total) * 100);
            @endphp
            <div class="target-item">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="target-label">{{ $label }}</span>
                    <span class="fw-semibold" style="color:{{ $color }}">{{ $count }} ({{ $pct }}%)</span>
                </div>
                <div class="progress-kpi">
                    <div class="progress-bar" style="width:{{ $pct }}%; background:{{ $color }};"></div>
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada dokumen KPI dari bawahan.</p>
        @endforelse

        @if($kpiMenunggu > 0)
        <div class="mt-4">
            <a href="{{ route('hr.kpi.index') }}" class="btn btn-warning">
                <i class="bi bi-eye me-1"></i>Review {{ $kpiMenunggu }} Dokumen Sekarang
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
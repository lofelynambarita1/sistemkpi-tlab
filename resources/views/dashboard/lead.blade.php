@extends('layouts.app')

@section('title', 'Dashboard Lead')

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard {{ $user->role_label }}
        </h4>
        <small class="text-muted">Pantau Status KPI Tim Kamu</small>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6">
        <div class="stat-card" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
            <i class="bi bi-people stat-icon"></i>
            <div class="stat-value">{{ $totalEmployee }}</div>
            <div class="stat-label">Total Employee</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#fbbf24);">
            <i class="bi bi-hourglass-split stat-icon"></i>
            <div class="stat-value">{{ $totalSubmitted }}</div>
            <div class="stat-label">KPI Menunggu Review</div>
        </div>
    </div>
</div>

{{-- Info Panel --}}
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-info-circle text-primary me-2"></i>Ringkasan Tim
    </div>
    <div class="card-body">
        <p class="mb-2">
            Terdapat <strong>{{ $totalEmployee }}</strong> employee (Associate, Intermediate, Senior)
            di bawah pengawasan kamu.
        </p>
        <p class="mb-0">
            Saat ini <strong class="text-warning">{{ $totalSubmitted }}</strong> dokumen KPI sedang menunggu review.
        </p>
        @if($totalSubmitted > 0)
        <div class="mt-3">
            <a href="{{ route('hr.kpi.index') }}" class="btn btn-warning">
                <i class="bi bi-eye me-1"></i>Review Sekarang
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
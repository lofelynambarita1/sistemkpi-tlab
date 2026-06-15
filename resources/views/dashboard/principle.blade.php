@extends('layouts.app')

@section('title', 'Dashboard Principle')

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard KPI
        </h4>
        <small class="text-muted">Selamat datang, {{ $user->name }} · {{ $user->role_label }}</small>
    </div>
    <div class="col-auto">
        <a href="{{ route('kpi.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Buat Dokumen KPI
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
            <i class="bi bi-files stat-icon"></i>
            <div class="stat-value">{{ $totalKpi }}</div>
            <div class="stat-label">Total Dokumen KPI</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#16a34a,#22c55e);">
            <i class="bi bi-check-circle-fill stat-icon"></i>
            <div class="stat-value">{{ $approved }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#fbbf24);">
            <i class="bi bi-hourglass-split stat-icon"></i>
            <div class="stat-value">{{ $submitted }}</div>
            <div class="stat-label">Menunggu Review</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#dc2626,#f87171);">
            <i class="bi bi-arrow-counterclockwise stat-icon"></i>
            <div class="stat-value">{{ $needRevision }}</div>
            <div class="stat-label">Perlu Revisi</div>
        </div>
    </div>
</div>

<div class="row g-3">
    @if($latestKpi)
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header fw-semibold">
                <i class="bi bi-file-earmark-text text-primary me-2"></i>Dokumen KPI Terbaru
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="fw-bold">KPI {{ $latestKpi->period_year }}</div>
                        <small class="text-muted">Dibuat {{ $latestKpi->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="status-badge {{ $latestKpi->status_badge_class }}">{{ $latestKpi->status_label }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('kpi.show', $latestKpi->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye me-1"></i>Lihat
                    </a>
                    @if(in_array($latestKpi->status, ['draft', 'need_revision']))
                    <a href="{{ route('kpi.edit', $latestKpi->id) }}" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    @endif
                </div>
                @if($draft > 0)
                <div class="alert alert-warning mt-3 mb-0 py-2 small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Kamu punya <strong>{{ $draft }}</strong> dokumen draft yang belum disubmit.
                </div>
                @endif
                @if($needRevision > 0)
                <div class="alert alert-danger mt-3 mb-0 py-2 small">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    <strong>{{ $needRevision }}</strong> dokumen perlu direvisi.
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="col-lg-{{ $latestKpi ? '7' : '12' }}">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-clock-history text-primary me-2"></i>Semua Dokumen KPI</span>
                <a href="{{ route('kpi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($myKpis->take(5) as $doc)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">KPI {{ $doc->period_year }}</div>
                            <div class="text-muted" style="font-size:.8rem;">
                                Diperbarui {{ $doc->updated_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="status-badge {{ $doc->status_badge_class }}">{{ $doc->status_label }}</span>
                            <a href="{{ route('kpi.show', $doc->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-file-earmark-x" style="font-size:2.5rem;"></i>
                        <p class="mt-2 mb-0">Belum ada dokumen KPI</p>
                        <a href="{{ route('kpi.create') }}" class="btn btn-primary btn-sm mt-3">
                            <i class="bi bi-plus-lg me-1"></i>Buat Sekarang
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
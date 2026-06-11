@extends('layouts.app')

@section('title', 'Dashboard — KPI ' . $year)

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard KPI
        </h4>
        <small class="text-muted">Periode {{ $year }} · {{ $user->role_label }} · {{ $user->name }}</small>
    </div>
    <div class="col-auto">
        <a href="{{ route('kpi.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Buat Dokumen KPI
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
            <i class="bi bi-bullseye stat-icon"></i>
            <div class="stat-value">{{ number_format($target->target_total, 0) }}</div>
            <div class="stat-label">Total Target Tahunan</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#16a34a,#22c55e);">
            <i class="bi bi-check2-circle stat-icon"></i>
            <div class="stat-value">{{ number_format($target->capaian_total, 0) }}</div>
            <div class="stat-label">Total Capaian</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#ca8a04,#fbbf24);">
            <i class="bi bi-percent stat-icon"></i>
            <div class="stat-value">{{ $target->persentase_total }}%</div>
            <div class="stat-label">Persentase Capaian</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#0891b2,#22d3ee);">
            <i class="bi bi-file-earmark-text stat-icon"></i>
            <div class="stat-value">{{ $recentDocs->count() }}</div>
            <div class="stat-label">Dokumen KPI</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Target Capaian --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Target Capaian Tahunan {{ $year }}</span>
                <span class="badge bg-primary-subtle text-primary">{{ $user->role_label }}</span>
            </div>
            <div class="card-body">
                @php
                    $items = [
                        ['label' => 'Jobdesc',              'color' => '#2563eb', 'pct' => $target->persentase_jobdesc,  'capaian' => $target->capaian_jobdesc,               'target' => $target->target_jobdesc,               'icon' => 'bi-briefcase'],
                        ['label' => 'Continues Improvement','color' => '#16a34a', 'pct' => $target->persentase_ci,       'capaian' => $target->capaian_continues_improvement, 'target' => $target->target_continues_improvement, 'icon' => 'bi-arrow-repeat'],
                        ['label' => 'Self Development',     'color' => '#ca8a04', 'pct' => $target->persentase_sd,       'capaian' => $target->capaian_self_development,      'target' => $target->target_self_development,      'icon' => 'bi-person-check'],
                        ['label' => 'HR Activity',          'color' => '#7c3aed', 'pct' => $target->persentase_hr,       'capaian' => $target->capaian_hr_activity,           'target' => $target->target_hr_activity,           'icon' => 'bi-people'],
                        ['label' => 'Kinerja Perilaku',     'color' => '#0891b2', 'pct' => $target->persentase_perilaku, 'capaian' => $target->capaian_kinerja_perilaku,      'target' => $target->target_kinerja_perilaku,      'icon' => 'bi-star'],
                    ];
                @endphp

                @foreach($items as $item)
                    <div class="target-item">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="target-label">
                                <i class="bi {{ $item['icon'] }} me-1" style="color:{{ $item['color'] }}"></i>
                                {{ $item['label'] }}
                            </span>
                            <span class="target-pct" style="color:{{ $item['color'] }}">{{ $item['pct'] }}%</span>
                        </div>
                        <div class="progress-kpi">
                            <div class="progress-bar"
                                 style="width:{{ $item['pct'] }}%; background:{{ $item['color'] }};"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Capaian: <strong>{{ number_format($item['capaian'], 1) }}</strong></small>
                            <small class="text-muted">Target: <strong>{{ number_format($item['target'], 1) }}</strong></small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent Documents --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-clock-history text-primary me-2"></i>Dokumen KPI Terbaru</span>
                <a href="{{ route('kpi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentDocs as $doc)
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

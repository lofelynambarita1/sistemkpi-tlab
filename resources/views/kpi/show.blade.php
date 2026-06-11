@extends('layouts.app')

@section('title', 'Detail KPI ' . $kpiDocument->period_year)

@push('styles')
<style>
.subform-view-table th { background:#f1f5f9; font-size:.8rem; font-weight:600; text-transform:uppercase; letter-spacing:.3px; color:#64748b; }
.subform-view-table td { vertical-align:middle; font-size:.9rem; }
.calc-cell { background:#eff6ff; color:#2563eb; font-weight:600; }
.section-tab-btn { border-radius:8px; font-weight:500; font-size:.88rem; }
.section-tab-btn.active { background:#2563eb; color:#fff; border-color:#2563eb; }
</style>
@endpush

@section('content')
<div class="row mt-4 mb-3 align-items-center flex-wrap gap-2">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-file-earmark-text text-primary me-2"></i>
            Detail KPI — {{ $kpiDocument->user->name }} ({{ $kpiDocument->period_year }})
        </h4>
        <small class="text-muted">
            {{ $kpiDocument->user->role_label }} &nbsp;·&nbsp;
            Dibuat: {{ $kpiDocument->created_at->format('d M Y') }}
            @if($kpiDocument->submitted_at)
                &nbsp;·&nbsp; Disubmit: {{ $kpiDocument->submitted_at->format('d M Y H:i') }}
            @endif
        </small>
    </div>
    <div class="col-auto d-flex gap-2 flex-wrap">
        @if(auth()->user()->isStaff())
            <a href="{{ route('kpi.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            @if($kpiDocument->status === 'draft')
                <a href="{{ route('kpi.edit', $kpiDocument->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
            @endif
        @else
            <a href="{{ route('hr.kpi.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            <a href="{{ route('hr.kpi.edit', $kpiDocument->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit/Review
            </a>
            <button class="btn btn-danger btn-sm"
                    data-delete-url="{{ route('hr.kpi.destroy', $kpiDocument->id) }}"
                    data-delete-desc="Dokumen KPI milik {{ $kpiDocument->user->name }} ({{ $kpiDocument->period_year }}) akan dihapus permanen.">
                <i class="bi bi-trash3 me-1"></i>Hapus
            </button>
        @endif
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i>Cetak
        </button>
    </div>
</div>

{{-- Status & Score Summary --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <div class="mb-2">
                    <span class="status-badge {{ $kpiDocument->status_badge_class }} fs-6 px-3 py-2">
                        {{ $kpiDocument->status_label }}
                    </span>
                </div>
                <small class="text-muted">Status Dokumen</small>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body">
                <div class="row g-2 text-center">
                    @php
                        $jdTotal  = $kpiDocument->jobdescs->sum('total_mandays_penugasan');
                        $ciTotal  = $kpiDocument->continuesImprovements->sum('point');
                        $sdTotal  = $kpiDocument->selfDevelopments->sum('point');
                        $hrTotal  = $kpiDocument->hrActivities->sum('point');
                        $pkTotal  = $kpiDocument->kinerjaPerilakus->sum('score');
                    @endphp
                    <div class="col border-end">
                        <div class="text-muted small">Jobdesc</div>
                        <div class="fw-bold text-primary fs-5">{{ number_format($jdTotal, 2) }}</div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">Cont. Improvement</div>
                        <div class="fw-bold text-success fs-5">{{ number_format($ciTotal, 2) }}</div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">Self Development</div>
                        <div class="fw-bold text-warning fs-5">{{ number_format($sdTotal, 2) }}</div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">HR Activity</div>
                        <div class="fw-bold" style="color:#7c3aed; font-size:1.25rem;">{{ number_format($hrTotal, 2) }}</div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">Kinerja Perilaku</div>
                        <div class="fw-bold text-info fs-5">{{ number_format($pkTotal, 2) }}</div>
                    </div>
                    <div class="col">
                        <div class="text-muted small fw-semibold">TOTAL SCORE</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem;">{{ number_format($kpiDocument->total_score, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tab Navigation --}}
<ul class="nav nav-tabs kpi-tabs mb-0" style="border-bottom:none;">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#view-jobdesc">Jobdesc</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-ci">Continues Improvement</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-sd">Self Development</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-hr">HR Activity</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-perilaku">Kinerja Perilaku</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-history">
        <i class="bi bi-clock-history me-1"></i>History
        <span class="badge bg-secondary ms-1">{{ $kpiDocument->histories->count() }}</span>
    </a></li>
</ul>

<div class="tab-content card border-top-0 rounded-0 rounded-bottom">
    <div class="card-body">

        {{-- JOBDESC --}}
        <div class="tab-pane fade show active" id="view-jobdesc">
            <div class="section-header"><i class="bi bi-briefcase"></i> Jobdesc</div>
            @if($kpiDocument->jobdescs->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Jobdesc</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Penilaian Koef. On Time & On Budget</th>
                            <th>Penilaian Grade Project</th>
                            <th>Nama Kegiatan dan Bukti</th>
                            <th>Mandays Proyek</th>
                            <th class="calc-cell">Jumlah Koefisien (OTB+Grade)</th>
                            <th class="calc-cell">Total Mandays Penugasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->jobdescs as $i => $jd)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ number_format($jd->penilaian_koefisien_ontime_onbudget, 2) }}</td>
                            <td>{{ number_format($jd->penilaian_grade_project, 2) }}</td>
                            <td>{{ $jd->nama_kegiatan_bukti ?: '—' }}</td>
                            <td>{{ number_format($jd->mandays_proyek, 2) }}</td>
                            <td class="calc-cell">{{ number_format($jd->jumlah_koefisien, 2) }}</td>
                            <td class="calc-cell">{{ number_format($jd->total_mandays_penugasan, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-primary">
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Total Mandays Penugasan:</td>
                            <td class="fw-bold">{{ number_format($jdTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- CONTINUES IMPROVEMENT --}}
        <div class="tab-pane fade" id="view-ci">
            <div class="section-header"><i class="bi bi-arrow-repeat"></i> Continues Improvement</div>
            @if($kpiDocument->continuesImprovements->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Continues Improvement</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis Kegiatan / Bukti</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th></tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->continuesImprovements as $i => $ci)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><span class="badge bg-success-subtle text-success">{{ $ci->jenis_kegiatan_bukti }}</span></td>
                            <td>{{ $ci->kegiatan }}</td>
                            <td>{{ number_format($ci->mandays, 2) }}</td>
                            <td class="calc-cell">{{ number_format($ci->koefisien, 4) }}</td>
                            <td class="calc-cell">{{ number_format($ci->point, 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-success">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold">{{ number_format($ciTotal, 4) }}</td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- SELF DEVELOPMENT --}}
        <div class="tab-pane fade" id="view-sd">
            <div class="section-header"><i class="bi bi-person-check"></i> Self Development</div>
            @if($kpiDocument->selfDevelopments->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Self Development</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis SD</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th></tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->selfDevelopments as $i => $sd)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><span class="badge bg-warning-subtle text-warning">{{ $sd->jenis_sd }}</span></td>
                            <td>{{ $sd->kegiatan }}</td>
                            <td>{{ number_format($sd->mandays, 2) }}</td>
                            <td class="calc-cell">{{ number_format($sd->koefisien, 4) }}</td>
                            <td class="calc-cell">{{ number_format($sd->point, 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-warning">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold">{{ number_format($sdTotal, 4) }}</td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- HR ACTIVITY --}}
        <div class="tab-pane fade" id="view-hr">
            <div class="section-header"><i class="bi bi-people"></i> HR Activity</div>
            @if($kpiDocument->hrActivities->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data HR Activity</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis Kegiatan</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th></tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->hrActivities as $i => $hr)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><span class="badge" style="background:#ede9fe;color:#7c3aed;">{{ $hr->jenis_kegiatan }}</span></td>
                            <td>{{ $hr->kegiatan }}</td>
                            <td>{{ number_format($hr->mandays, 2) }}</td>
                            <td class="calc-cell">{{ number_format($hr->koefisien, 4) }}</td>
                            <td class="calc-cell">{{ number_format($hr->point, 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="background:#ede9fe;">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold">{{ number_format($hrTotal, 4) }}</td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- KINERJA PERILAKU --}}
        <div class="tab-pane fade" id="view-perilaku">
            <div class="section-header"><i class="bi bi-star-half"></i> Kinerja Perilaku</div>
            @if($kpiDocument->kinerjaPerilakus->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Kinerja Perilaku</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Aspek Kinerja</th>
                            <th>Definisi</th>
                            <th class="text-center">Min. Capaian</th>
                            <th>Indikator</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Score</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->kinerjaPerilakus as $i => $kp)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><strong>{{ $kp->aspek_kinerja }}</strong></td>
                            <td><small>{{ $kp->definisi }}</small></td>
                            <td class="text-center"><span class="badge bg-warning text-dark">≥ {{ $kp->minimum_capaian }}</span></td>
                            <td><small>{{ $kp->indikator }}</small></td>
                            <td><small>{{ $kp->deskripsi }}</small></td>
                            <td class="text-center">
                                <span class="fw-bold fs-5 {{ $kp->score >= $kp->minimum_capaian ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($kp->score, 2) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($kp->score >= $kp->minimum_capaian)
                                    <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Tercapai</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-lg me-1"></i>Belum Tercapai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-info">
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Total Score Kinerja Perilaku:</td>
                            <td class="text-center fw-bold fs-5">{{ number_format($pkTotal, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- HISTORY --}}
        <div class="tab-pane fade" id="view-history">
            <div class="section-header"><i class="bi bi-clock-history"></i> Riwayat Perubahan</div>
            @if($kpiDocument->histories->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-clock me-2"></i>Belum ada riwayat perubahan</p>
            @else
                @foreach($kpiDocument->histories as $hist)
                <div class="history-item">
                    <div class="history-dot {{ match($hist->action) { 'create' => 'bg-success', 'update' => 'bg-warning', 'delete' => 'bg-danger', 'submit' => 'bg-primary', default => 'bg-secondary' } }}"></div>
                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-1">
                        <div>
                            <span class="badge {{ $hist->action_badge_class }} me-1">{{ $hist->action_label }}</span>
                            @if($hist->section)
                                <span class="badge bg-light text-dark border me-1">{{ $hist->section_label }}</span>
                            @endif
                            <span class="text-dark small">{{ $hist->description }}</span>
                        </div>
                        <small class="text-muted">{{ $hist->created_at->format('d M Y H:i') }}</small>
                    </div>
                    <small class="text-muted">
                        <i class="bi bi-person-circle me-1"></i>
                        Oleh: <strong>{{ $hist->changedBy->name }}</strong> ({{ $hist->changedBy->role_label }})
                    </small>
                    @if($hist->old_data && $hist->action === 'update')
                        <div class="mt-1">
                            <a class="btn btn-xs btn-outline-secondary btn-sm py-0 px-2" data-bs-toggle="collapse"
                               href="#histDetail{{ $hist->id }}">
                                <i class="bi bi-code-slash me-1"></i>Detail Perubahan
                            </a>
                            <div class="collapse mt-2" id="histDetail{{ $hist->id }}">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <small class="text-muted fw-semibold d-block mb-1">Data Sebelum:</small>
                                        <pre class="bg-light rounded p-2" style="font-size:.75rem; max-height:150px; overflow:auto;">{{ json_encode($hist->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-semibold d-block mb-1">Data Sesudah:</small>
                                        <pre class="bg-light rounded p-2" style="font-size:.75rem; max-height:150px; overflow:auto;">{{ json_encode($hist->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            @endif
        </div>

    </div>{{-- card-body --}}
</div>{{-- tab-content --}}

@if($kpiDocument->notes)
<div class="alert alert-light border mt-3">
    <i class="bi bi-chat-text me-2"></i><strong>Catatan:</strong> {{ $kpiDocument->notes }}
</div>
@endif

@endsection

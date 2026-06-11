@extends('layouts.app')

@section('title', 'Review KPI — ' . $kpiDocument->user->name)

@push('styles')
<style>
.subform-view-table th { background:#f1f5f9; font-size:.8rem; font-weight:600; text-transform:uppercase; color:#64748b; }
.calc-cell { background:#eff6ff; color:#2563eb; font-weight:600; }
.inline-edit-form { display:none; background:#f8fafc; padding:1rem; border-radius:8px; border:1px solid #e2e8f0; margin-top:.5rem; }
.inline-edit-form.show { display:block; }
</style>
@endpush

@section('content')
<div class="row mt-4 mb-3 align-items-center flex-wrap gap-2">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-file-earmark-check text-primary me-2"></i>
            Review KPI — {{ $kpiDocument->user->name }} ({{ $kpiDocument->period_year }})
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
        <a href="{{ route('hr.kpi.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <a href="{{ route('hr.kpi.edit', $kpiDocument->id) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <button class="btn btn-danger btn-sm"
                data-delete-url="{{ route('hr.kpi.destroy', $kpiDocument->id) }}"
                data-delete-desc="Dokumen KPI milik {{ $kpiDocument->user->name }} ({{ $kpiDocument->period_year }}) akan dihapus permanen.">
            <i class="bi bi-trash3 me-1"></i>Hapus
        </button>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i>Cetak
        </button>
    </div>
</div>

{{-- Score Summary --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <span class="status-badge {{ $kpiDocument->status_badge_class }} fs-6 px-3 py-2">
                    {{ $kpiDocument->status_label }}
                </span>
                <small class="text-muted mt-2">Status Dokumen</small>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body">
                <div class="row g-2 text-center">
                    @php
                        $jdTotal = $kpiDocument->jobdescs->sum('total_mandays_penugasan');
                        $ciTotal = $kpiDocument->continuesImprovements->sum('point');
                        $sdTotal = $kpiDocument->selfDevelopments->sum('point');
                        $hrTotal = $kpiDocument->hrActivities->sum('point');
                        $pkTotal = $kpiDocument->kinerjaPerilakus->sum('score');
                    @endphp
                    <div class="col border-end"><div class="text-muted small">Jobdesc</div><div class="fw-bold text-primary fs-5">{{ number_format($jdTotal,2) }}</div></div>
                    <div class="col border-end"><div class="text-muted small">CI</div><div class="fw-bold text-success fs-5">{{ number_format($ciTotal,2) }}</div></div>
                    <div class="col border-end"><div class="text-muted small">Self Dev</div><div class="fw-bold text-warning fs-5">{{ number_format($sdTotal,2) }}</div></div>
                    <div class="col border-end"><div class="text-muted small">HR Act</div><div class="fw-bold fs-5" style="color:#7c3aed">{{ number_format($hrTotal,2) }}</div></div>
                    <div class="col border-end"><div class="text-muted small">Perilaku</div><div class="fw-bold text-info fs-5">{{ number_format($pkTotal,2) }}</div></div>
                    <div class="col"><div class="text-muted small fw-semibold">TOTAL</div><div class="fw-bold text-dark" style="font-size:1.5rem;">{{ number_format($kpiDocument->total_score,2) }}</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs kpi-tabs mb-0" style="border-bottom:none;">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#hr-jobdesc">Jobdesc</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-ci">Continues Improvement</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-sd">Self Development</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-hr">HR Activity</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-perilaku">Kinerja Perilaku</a></li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#hr-history">
            <i class="bi bi-clock-history me-1"></i>History
            <span class="badge bg-secondary ms-1">{{ $kpiDocument->histories->count() }}</span>
        </a>
    </li>
</ul>

<div class="tab-content card border-top-0 rounded-0 rounded-bottom">
    <div class="card-body">

        {{-- JOBDESC --}}
        <div class="tab-pane fade show active" id="hr-jobdesc">
            <div class="section-header"><i class="bi bi-briefcase"></i> Jobdesc</div>
            @if($kpiDocument->jobdescs->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Jobdesc</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th><th>Koef. OTB</th><th>Grade Project</th>
                            <th>Nama Kegiatan & Bukti</th><th>Mandays Proyek</th>
                            <th class="calc-cell">Jumlah Koef.</th>
                            <th class="calc-cell">Total Mandays</th>
                            <th class="text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->jobdescs as $i => $jd)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ number_format($jd->penilaian_koefisien_ontime_onbudget,2) }}</td>
                            <td>{{ number_format($jd->penilaian_grade_project,2) }}</td>
                            <td>{{ $jd->nama_kegiatan_bukti ?: '—' }}</td>
                            <td>{{ number_format($jd->mandays_proyek,2) }}</td>
                            <td class="calc-cell">{{ number_format($jd->jumlah_koefisien,2) }}</td>
                            <td class="calc-cell">{{ number_format($jd->total_mandays_penugasan,2) }}</td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-outline-warning btn-sm"
                                        onclick="toggleEdit('jd{{ $jd->id }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr id="jd{{ $jd->id }}-row" style="display:none;">
                            <td colspan="8" class="p-0">
                                <form method="POST"
                                      action="{{ route('hr.kpi.update.jobdesc', [$kpiDocument->id, $jd->id]) }}"
                                      class="p-3 bg-light">
                                    @csrf @method('PUT')
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Koef. OTB</label>
                                            <input type="number" name="penilaian_koefisien_ontime_onbudget" class="form-control form-control-sm" value="{{ $jd->penilaian_koefisien_ontime_onbudget }}" step="0.01" min="0">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Grade Project</label>
                                            <input type="number" name="penilaian_grade_project" class="form-control form-control-sm" value="{{ $jd->penilaian_grade_project }}" step="0.01" min="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small mb-1">Nama Kegiatan & Bukti</label>
                                            <input type="text" name="nama_kegiatan_bukti" class="form-control form-control-sm" value="{{ $jd->nama_kegiatan_bukti }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Mandays Proyek</label>
                                            <input type="number" name="mandays_proyek" class="form-control form-control-sm" value="{{ $jd->mandays_proyek }}" step="0.01" min="0">
                                        </div>
                                        <div class="col-md-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success btn-sm flex-grow-1">
                                                <i class="bi bi-check-lg"></i> Simpan
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('jd{{ $jd->id }}')">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-primary">
                        <tr><td colspan="6" class="text-end fw-bold">Total:</td><td class="fw-bold">{{ number_format($jdTotal,2) }}</td><td></td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- CONTINUES IMPROVEMENT --}}
        <div class="tab-pane fade" id="hr-ci">
            <div class="section-header"><i class="bi bi-arrow-repeat"></i> Continues Improvement</div>
            @if($kpiDocument->continuesImprovements->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis Kegiatan/Bukti</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th><th class="text-center">Edit</th></tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->continuesImprovements as $i => $ci)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><span class="badge bg-success-subtle text-success">{{ $ci->jenis_kegiatan_bukti }}</span></td>
                            <td>{{ $ci->kegiatan }}</td>
                            <td>{{ number_format($ci->mandays,2) }}</td>
                            <td class="calc-cell">{{ number_format($ci->koefisien,4) }}</td>
                            <td class="calc-cell">{{ number_format($ci->point,4) }}</td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-outline-warning btn-sm" onclick="toggleEdit('ci{{ $ci->id }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr id="ci{{ $ci->id }}-row" style="display:none;">
                            <td colspan="7" class="p-0">
                                <form method="POST" action="{{ route('hr.kpi.update.ci', [$kpiDocument->id, $ci->id]) }}" class="p-3 bg-light">
                                    @csrf @method('PUT')
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Jenis Kegiatan/Bukti</label>
                                            <select name="jenis_kegiatan_bukti" class="form-select form-select-sm">
                                                @foreach(array_keys(\App\Models\KpiContinuesImprovement::$koefisienMap) as $opt)
                                                    <option value="{{ $opt }}" {{ $ci->jenis_kegiatan_bukti===$opt?'selected':'' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small mb-1">Kegiatan</label>
                                            <input type="text" name="kegiatan" class="form-control form-control-sm" value="{{ $ci->kegiatan }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Mandays</label>
                                            <input type="number" name="mandays" class="form-control form-control-sm" value="{{ $ci->mandays }}" step="0.01" min="0">
                                        </div>
                                        <div class="col-md-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success btn-sm flex-grow-1"><i class="bi bi-check-lg"></i> Simpan</button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('ci{{ $ci->id }}')"><i class="bi bi-x"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-success">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold">{{ number_format($ciTotal,4) }}</td><td></td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- SELF DEVELOPMENT --}}
        <div class="tab-pane fade" id="hr-sd">
            <div class="section-header"><i class="bi bi-person-check"></i> Self Development</div>
            @if($kpiDocument->selfDevelopments->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis SD</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th><th class="text-center">Edit</th></tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->selfDevelopments as $i => $sd)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><span class="badge bg-warning-subtle text-warning">{{ $sd->jenis_sd }}</span></td>
                            <td>{{ $sd->kegiatan }}</td>
                            <td>{{ number_format($sd->mandays,2) }}</td>
                            <td class="calc-cell">{{ number_format($sd->koefisien,4) }}</td>
                            <td class="calc-cell">{{ number_format($sd->point,4) }}</td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-outline-warning btn-sm" onclick="toggleEdit('sd{{ $sd->id }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr id="sd{{ $sd->id }}-row" style="display:none;">
                            <td colspan="7" class="p-0">
                                <form method="POST" action="{{ route('hr.kpi.update.sd', [$kpiDocument->id, $sd->id]) }}" class="p-3 bg-light">
                                    @csrf @method('PUT')
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Jenis SD</label>
                                            <select name="jenis_sd" class="form-select form-select-sm">
                                                @foreach(array_keys(\App\Models\KpiSelfDevelopment::$koefisienMap) as $opt)
                                                    <option value="{{ $opt }}" {{ $sd->jenis_sd===$opt?'selected':'' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small mb-1">Kegiatan</label>
                                            <input type="text" name="kegiatan" class="form-control form-control-sm" value="{{ $sd->kegiatan }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Mandays</label>
                                            <input type="number" name="mandays" class="form-control form-control-sm" value="{{ $sd->mandays }}" step="0.01" min="0">
                                        </div>
                                        <div class="col-md-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success btn-sm flex-grow-1"><i class="bi bi-check-lg"></i> Simpan</button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('sd{{ $sd->id }}')"><i class="bi bi-x"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-warning">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold">{{ number_format($sdTotal,4) }}</td><td></td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- HR ACTIVITY --}}
        <div class="tab-pane fade" id="hr-hr">
            <div class="section-header"><i class="bi bi-people"></i> HR Activity</div>
            @if($kpiDocument->hrActivities->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis Kegiatan</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th><th class="text-center">Edit</th></tr>
                    </thead>
                    <tbody>
                        @foreach($kpiDocument->hrActivities as $i => $hr)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><span class="badge" style="background:#ede9fe;color:#7c3aed;">{{ $hr->jenis_kegiatan }}</span></td>
                            <td>{{ $hr->kegiatan }}</td>
                            <td>{{ number_format($hr->mandays,2) }}</td>
                            <td class="calc-cell">{{ number_format($hr->koefisien,4) }}</td>
                            <td class="calc-cell">{{ number_format($hr->point,4) }}</td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-outline-warning btn-sm" onclick="toggleEdit('hr{{ $hr->id }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr id="hr{{ $hr->id }}-row" style="display:none;">
                            <td colspan="7" class="p-0">
                                <form method="POST" action="{{ route('hr.kpi.update.hr_activity', [$kpiDocument->id, $hr->id]) }}" class="p-3 bg-light">
                                    @csrf @method('PUT')
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Jenis Kegiatan</label>
                                            <select name="jenis_kegiatan" class="form-select form-select-sm">
                                                @foreach(array_keys(\App\Models\KpiHrActivity::$koefisienMap) as $opt)
                                                    <option value="{{ $opt }}" {{ $hr->jenis_kegiatan===$opt?'selected':'' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small mb-1">Kegiatan</label>
                                            <input type="text" name="kegiatan" class="form-control form-control-sm" value="{{ $hr->kegiatan }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Mandays</label>
                                            <input type="number" name="mandays" class="form-control form-control-sm" value="{{ $hr->mandays }}" step="0.01" min="0">
                                        </div>
                                        <div class="col-md-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success btn-sm flex-grow-1"><i class="bi bi-check-lg"></i> Simpan</button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('hr{{ $hr->id }}')"><i class="bi bi-x"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="background:#ede9fe;">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold">{{ number_format($hrTotal,4) }}</td><td></td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- KINERJA PERILAKU --}}
        <div class="tab-pane fade" id="hr-perilaku">
            <div class="section-header"><i class="bi bi-star-half"></i> Kinerja Perilaku</div>
            @if($kpiDocument->kinerjaPerilakus->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data</p>
            @else
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Aspek Kinerja</th><th>Definisi</th><th>Min. Capaian</th><th>Indikator</th><th>Deskripsi</th><th class="text-center">Score</th><th class="text-center">Status</th><th class="text-center">Edit</th></tr>
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
                                    {{ number_format($kp->score,2) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($kp->score >= $kp->minimum_capaian)
                                    <span class="badge bg-success">Tercapai</span>
                                @else
                                    <span class="badge bg-danger">Belum</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-outline-warning btn-sm" onclick="toggleEdit('kp{{ $kp->id }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr id="kp{{ $kp->id }}-row" style="display:none;">
                            <td colspan="9" class="p-0">
                                <form method="POST" action="{{ route('hr.kpi.update.perilaku', [$kpiDocument->id, $kp->id]) }}" class="p-3 bg-light">
                                    @csrf @method('PUT')
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Score (0-100)</label>
                                            <input type="number" name="score" class="form-control form-control-sm" value="{{ $kp->score }}" min="0" max="100" step="0.01">
                                        </div>
                                        <div class="col-md-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success btn-sm flex-grow-1"><i class="bi bi-check-lg"></i> Simpan</button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('kp{{ $kp->id }}')"><i class="bi bi-x"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-info">
                        <tr><td colspan="6" class="text-end fw-bold">Total Score Perilaku:</td><td class="text-center fw-bold fs-5">{{ number_format($pkTotal,2) }}</td><td colspan="2"></td></tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        {{-- HISTORY --}}
        <div class="tab-pane fade" id="hr-history">
            <div class="section-header"><i class="bi bi-clock-history"></i> Riwayat Perubahan</div>
            @if($kpiDocument->histories->isEmpty())
                <p class="text-muted text-center py-3"><i class="bi bi-clock me-2"></i>Belum ada riwayat perubahan</p>
            @else
                @foreach($kpiDocument->histories as $hist)
                <div class="history-item">
                    <div class="history-dot {{ match($hist->action){ 'create'=>'bg-success','update'=>'bg-warning','delete'=>'bg-danger','submit'=>'bg-primary',default=>'bg-secondary' } }}"></div>
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
                            <a class="btn btn-xs btn-outline-secondary btn-sm py-0 px-2" data-bs-toggle="collapse" href="#hd{{ $hist->id }}">
                                <i class="bi bi-code-slash me-1"></i>Detail
                            </a>
                            <div class="collapse mt-2" id="hd{{ $hist->id }}">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <small class="text-muted fw-semibold d-block mb-1">Sebelum:</small>
                                        <pre class="bg-light rounded p-2" style="font-size:.75rem;max-height:150px;overflow:auto;">{{ json_encode($hist->old_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-semibold d-block mb-1">Sesudah:</small>
                                        <pre class="bg-light rounded p-2" style="font-size:.75rem;max-height:150px;overflow:auto;">{{ json_encode($hist->new_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleEdit(id) {
    const row = document.getElementById(id + '-row');
    if (row) {
        row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
    }
}
</script>
@endpush

@extends('layouts.app')

@section('title', 'Edit KPI Staff — ' . $kpiDocument->user->name)

@push('styles')
<style>
.form-section { background:#fff; border-radius:12px; border:1px solid #e2e8f0; margin-bottom:1.5rem; overflow:hidden; }
.form-section-header { background:linear-gradient(90deg,#7c3aed,#8b5cf6); color:#fff; padding:.9rem 1.25rem; font-weight:600; display:flex; align-items:center; gap:.5rem; }
.form-section-body { padding:1.25rem; }
.subform-table th { background:#f8fafc; font-size:.8rem; font-weight:600; text-transform:uppercase; color:#64748b; white-space:nowrap; }
.subform-table td { vertical-align:middle; }
.calc-field { background:#eff6ff !important; color:#2563eb; font-weight:600; border-color:#bfdbfe !important; cursor:not-allowed; }
</style>
@endpush

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-pencil-square text-primary me-2"></i>
            Edit/Review KPI — {{ $kpiDocument->user->name }} ({{ $kpiDocument->period_year }})
        </h4>
        <small class="text-muted">{{ $user->name }} · {{ $user->role_label }}</small>
    </div>
    <div class="col-auto d-flex gap-2">
        <a href="{{ route('hr.kpi.show', $kpiDocument->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="alert alert-warning py-2 mb-4">
    <i class="bi bi-shield-exclamation me-2"></i>
    Segala perubahan yang Anda lakukan akan tercatat di <strong>History</strong> dan dapat dilihat oleh staff yang bersangkutan.
</div>

<form method="POST" action="{{ route('hr.kpi.update', $kpiDocument->id) }}" id="hrEditForm">
    @csrf
    @method('PUT')

    {{-- Document Info & Status Update --}}
    <div class="form-section">
        <div class="form-section-header">
            <i class="bi bi-info-circle"></i> Informasi & Status Dokumen
        </div>
        <div class="form-section-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Staff</label>
                    <input type="text" class="form-control-plaintext fw-bold" value="{{ $kpiDocument->user->name }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Periode</label>
                    <input type="text" class="form-control-plaintext fw-bold" value="{{ $kpiDocument->period_year }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Total Score</label>
                    <input type="text" class="form-control-plaintext fw-bold text-primary" value="{{ number_format($kpiDocument->total_score, 2) }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="submitted" {{ $kpiDocument->status=='submitted' ? 'selected':'' }}>Disubmit</option>
                        <option value="reviewed"  {{ $kpiDocument->status=='reviewed'  ? 'selected':'' }}>Ditinjau</option>
                        <option value="approved"  {{ $kpiDocument->status=='approved'  ? 'selected':'' }}>Disetujui</option>
                    </select>
                    @if($kpiDocument->status === 'draft')
                        <small class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>Dokumen masih Draft</small>
                    @endif
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Catatan HR/Manager</label>
                    <input type="text" name="notes" class="form-control" placeholder="Catatan review..."
                           value="{{ old('notes', $kpiDocument->notes) }}">
                </div>
            </div>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <ul class="nav tab-form-nav border-bottom mb-0" style="background:#f8fafc;padding:.75rem 1rem 0;border-radius:12px 12px 0 0;border:1px solid #e2e8f0;border-bottom:none;">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#hr-edit-jobdesc">Jobdesc</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-edit-ci">Continues Improvement</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-edit-sd">Self Development</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-edit-hr">HR Activity</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#hr-edit-perilaku">Kinerja Perilaku</a></li>
    </ul>

    <div class="tab-content" style="background:#f8fafc;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 12px 12px;padding:1.25rem;">

        {{-- JOBDESC --}}
        <div class="tab-pane fade show active" id="hr-edit-jobdesc">
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#1d4ed8,#2563eb);">
                    <i class="bi bi-briefcase"></i> Jobdesc
                </div>
                <div class="form-section-body">
                    @if($kpiDocument->jobdescs->isEmpty())
                        <p class="text-muted"><i class="bi bi-inbox me-2"></i>Tidak ada data Jobdesc</p>
                    @else
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:160px">Koef. OTB</th>
                                    <th style="min-width:160px">Grade Project</th>
                                    <th style="min-width:200px">Nama Kegiatan & Bukti</th>
                                    <th style="min-width:120px">Mandays Proyek</th>
                                    <th style="min-width:150px" class="text-info">Jumlah Koef. <i class="bi bi-lock-fill"></i></th>
                                    <th style="min-width:150px" class="text-info">Total Mandays <i class="bi bi-lock-fill"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kpiDocument->jobdescs as $i => $jd)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td><input type="number" name="jobdesc[{{ $jd->id }}][penilaian_koefisien_ontime_onbudget]" class="form-control form-control-sm jd-otb" value="{{ $jd->penilaian_koefisien_ontime_onbudget }}" step="0.01" min="0" oninput="hrCalcJD(this.closest('tr'))"></td>
                                    <td><input type="number" name="jobdesc[{{ $jd->id }}][penilaian_grade_project]" class="form-control form-control-sm jd-grade" value="{{ $jd->penilaian_grade_project }}" step="0.01" min="0" oninput="hrCalcJD(this.closest('tr'))"></td>
                                    <td><input type="text" name="jobdesc[{{ $jd->id }}][nama_kegiatan_bukti]" class="form-control form-control-sm" value="{{ $jd->nama_kegiatan_bukti }}"></td>
                                    <td><input type="number" name="jobdesc[{{ $jd->id }}][mandays_proyek]" class="form-control form-control-sm jd-mandays" value="{{ $jd->mandays_proyek }}" step="0.01" min="0" oninput="hrCalcJD(this.closest('tr'))"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field jd-jumlah" value="{{ number_format($jd->jumlah_koefisien,2,'.','')}}" readonly tabindex="-1"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field jd-total" value="{{ number_format($jd->total_mandays_penugasan,2,'.','')}}" readonly tabindex="-1"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CI --}}
        <div class="tab-pane fade" id="hr-edit-ci">
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#16a34a,#22c55e);">
                    <i class="bi bi-arrow-repeat"></i> Continues Improvement
                </div>
                <div class="form-section-body">
                    @if($kpiDocument->continuesImprovements->isEmpty())
                        <p class="text-muted"><i class="bi bi-inbox me-2"></i>Tidak ada data CI</p>
                    @else
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered">
                            <thead><tr><th>#</th><th style="min-width:230px">Jenis Kegiatan/Bukti</th><th style="min-width:200px">Kegiatan</th><th style="min-width:110px">Mandays</th><th style="min-width:100px" class="text-info">Koefisien <i class="bi bi-lock-fill"></i></th><th style="min-width:100px" class="text-info">Point <i class="bi bi-lock-fill"></i></th></tr></thead>
                            <tbody>
                                @foreach($kpiDocument->continuesImprovements as $i => $ci)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>
                                        <select name="ci_edit[{{ $ci->id }}][jenis_kegiatan_bukti]" class="form-select form-select-sm ci-jenis" onchange="hrCalcCI(this.closest('tr'))">
                                            @foreach(array_keys(\App\Models\KpiContinuesImprovement::$koefisienMap) as $opt)
                                                <option value="{{ $opt }}" {{ $ci->jenis_kegiatan_bukti===$opt?'selected':'' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="ci_edit[{{ $ci->id }}][kegiatan]" class="form-control form-control-sm" value="{{ $ci->kegiatan }}"></td>
                                    <td><input type="number" name="ci_edit[{{ $ci->id }}][mandays]" class="form-control form-control-sm ci-mandays" value="{{ $ci->mandays }}" step="0.01" min="0" oninput="hrCalcCI(this.closest('tr'))"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field ci-koef" value="{{ number_format($ci->koefisien,4,'.','')}}" readonly tabindex="-1"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field ci-point" value="{{ number_format($ci->point,4,'.','')}}" readonly tabindex="-1"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- SD --}}
        <div class="tab-pane fade" id="hr-edit-sd">
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#ca8a04,#fbbf24);">
                    <i class="bi bi-person-check"></i> Self Development
                </div>
                <div class="form-section-body">
                    @if($kpiDocument->selfDevelopments->isEmpty())
                        <p class="text-muted"><i class="bi bi-inbox me-2"></i>Tidak ada data SD</p>
                    @else
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered">
                            <thead><tr><th>#</th><th style="min-width:230px">Jenis SD</th><th style="min-width:200px">Kegiatan</th><th style="min-width:110px">Mandays</th><th style="min-width:100px" class="text-info">Koefisien <i class="bi bi-lock-fill"></i></th><th style="min-width:100px" class="text-info">Point <i class="bi bi-lock-fill"></i></th></tr></thead>
                            <tbody>
                                @foreach($kpiDocument->selfDevelopments as $i => $sd)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>
                                        <select name="sd_edit[{{ $sd->id }}][jenis_sd]" class="form-select form-select-sm sd-jenis" onchange="hrCalcSD(this.closest('tr'))">
                                            @foreach(array_keys(\App\Models\KpiSelfDevelopment::$koefisienMap) as $opt)
                                                <option value="{{ $opt }}" {{ $sd->jenis_sd===$opt?'selected':'' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="sd_edit[{{ $sd->id }}][kegiatan]" class="form-control form-control-sm" value="{{ $sd->kegiatan }}"></td>
                                    <td><input type="number" name="sd_edit[{{ $sd->id }}][mandays]" class="form-control form-control-sm sd-mandays" value="{{ $sd->mandays }}" step="0.01" min="0" oninput="hrCalcSD(this.closest('tr'))"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field sd-koef" value="{{ number_format($sd->koefisien,4,'.','')}}" readonly tabindex="-1"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field sd-point" value="{{ number_format($sd->point,4,'.','')}}" readonly tabindex="-1"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- HR ACTIVITY --}}
        <div class="tab-pane fade" id="hr-edit-hr">
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#7c3aed,#8b5cf6);">
                    <i class="bi bi-people"></i> HR Activity
                </div>
                <div class="form-section-body">
                    @if($kpiDocument->hrActivities->isEmpty())
                        <p class="text-muted"><i class="bi bi-inbox me-2"></i>Tidak ada data HR Activity</p>
                    @else
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered">
                            <thead><tr><th>#</th><th style="min-width:230px">Jenis Kegiatan</th><th style="min-width:200px">Kegiatan</th><th style="min-width:110px">Mandays</th><th style="min-width:100px" class="text-info">Koefisien <i class="bi bi-lock-fill"></i></th><th style="min-width:100px" class="text-info">Point <i class="bi bi-lock-fill"></i></th></tr></thead>
                            <tbody>
                                @foreach($kpiDocument->hrActivities as $i => $hr)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>
                                        <select name="hr_edit[{{ $hr->id }}][jenis_kegiatan]" class="form-select form-select-sm hr-jenis" onchange="hrCalcHR(this.closest('tr'))">
                                            @foreach(array_keys(\App\Models\KpiHrActivity::$koefisienMap) as $opt)
                                                <option value="{{ $opt }}" {{ $hr->jenis_kegiatan===$opt?'selected':'' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="hr_edit[{{ $hr->id }}][kegiatan]" class="form-control form-control-sm" value="{{ $hr->kegiatan }}"></td>
                                    <td><input type="number" name="hr_edit[{{ $hr->id }}][mandays]" class="form-control form-control-sm hr-mandays" value="{{ $hr->mandays }}" step="0.01" min="0" oninput="hrCalcHR(this.closest('tr'))"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field hr-koef" value="{{ number_format($hr->koefisien,4,'.','')}}" readonly tabindex="-1"></td>
                                    <td><input type="text" class="form-control form-control-sm calc-field hr-point" value="{{ number_format($hr->point,4,'.','')}}" readonly tabindex="-1"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KINERJA PERILAKU --}}
        <div class="tab-pane fade" id="hr-edit-perilaku">
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#0891b2,#22d3ee);">
                    <i class="bi bi-star-half"></i> Kinerja Perilaku
                </div>
                <div class="form-section-body">
                    @if($kpiDocument->kinerjaPerilakus->isEmpty())
                        <p class="text-muted"><i class="bi bi-inbox me-2"></i>Tidak ada data Kinerja Perilaku</p>
                    @else
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aspek Kinerja <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Definisi <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Min. Capaian <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Indikator <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Deskripsi <i class="bi bi-lock-fill text-info"></i></th>
                                    <th style="min-width:110px">Score</th>
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
                                    <td>
                                        <input type="number"
                                               name="perilaku_edit[{{ $kp->id }}][score]"
                                               class="form-control form-control-sm"
                                               value="{{ $kp->score }}"
                                               min="0" max="100" step="0.01">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- end tab-content --}}

    {{-- ACTION BUTTONS --}}
    <div class="card border-warning mt-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <i class="bi bi-info-circle text-warning me-2"></i>
                <small class="text-muted">Perubahan akan dicatat di history dan dapat dilihat oleh staff.</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('hr.kpi.show', $kpiDocument->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const CI_KOEFISIEN = @json(\App\Models\KpiContinuesImprovement::$koefisienMap);
const SD_KOEFISIEN = @json(\App\Models\KpiSelfDevelopment::$koefisienMap);
const HR_KOEFISIEN = @json(\App\Models\KpiHrActivity::$koefisienMap);

function hrCalcJD(row) {
    const otb   = parseFloat(row.querySelector('.jd-otb').value)||0;
    const grade = parseFloat(row.querySelector('.jd-grade').value)||0;
    const md    = parseFloat(row.querySelector('.jd-mandays').value)||0;
    const jml   = otb + grade;
    row.querySelector('.jd-jumlah').value = jml.toFixed(2);
    row.querySelector('.jd-total').value  = (jml * md).toFixed(2);
}
function hrCalcCI(row) {
    const jenis = row.querySelector('.ci-jenis').value;
    const md    = parseFloat(row.querySelector('.ci-mandays').value)||0;
    const koef  = CI_KOEFISIEN[jenis]||0.5;
    row.querySelector('.ci-koef').value  = koef.toFixed(4);
    row.querySelector('.ci-point').value = (koef*md).toFixed(4);
}
function hrCalcSD(row) {
    const jenis = row.querySelector('.sd-jenis').value;
    const md    = parseFloat(row.querySelector('.sd-mandays').value)||0;
    const koef  = SD_KOEFISIEN[jenis]||0.5;
    row.querySelector('.sd-koef').value  = koef.toFixed(4);
    row.querySelector('.sd-point').value = (koef*md).toFixed(4);
}
function hrCalcHR(row) {
    const jenis = row.querySelector('.hr-jenis').value;
    const md    = parseFloat(row.querySelector('.hr-mandays').value)||0;
    const koef  = HR_KOEFISIEN[jenis]||0.5;
    row.querySelector('.hr-koef').value  = koef.toFixed(4);
    row.querySelector('.hr-point').value = (koef*md).toFixed(4);
}
</script>
@endpush

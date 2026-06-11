@extends('layouts.app')

@section('title', 'Edit KPI ' . $kpiDocument->period_year)

@push('styles')
<style>
.form-section { background:#fff; border-radius:12px; border:1px solid #e2e8f0; margin-bottom:1.5rem; overflow:hidden; }
.form-section-header { background: linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; padding:.9rem 1.25rem; font-weight:600; display:flex; align-items:center; gap:.5rem; }
.form-section-body { padding:1.25rem; }
.subform-table th { background:#f8fafc; font-size:.8rem; font-weight:600; text-transform:uppercase; color:#64748b; white-space:nowrap; }
.subform-table td { vertical-align:middle; }
.subform-table input, .subform-table select { font-size:.85rem; }
.calc-field { background:#eff6ff !important; color:#2563eb; font-weight:600; border-color:#bfdbfe !important; cursor:not-allowed; }
.btn-add-row { border-style:dashed; }
</style>
@endpush

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Edit KPI — {{ $kpiDocument->period_year }}</h4>
        <small class="text-muted">{{ $user->name }} · {{ $user->role_label }}</small>
    </div>
    <div class="col-auto">
        <a href="{{ route('kpi.show', $kpiDocument->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<form method="POST" action="{{ route('kpi.update', $kpiDocument->id) }}" id="kpiForm">
    @csrf
    @method('PUT')

    {{-- Header Info --}}
    <div class="form-section">
        <div class="form-section-header">
            <i class="bi bi-info-circle"></i> Informasi Dokumen KPI
        </div>
        <div class="form-section-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Periode Tahun</label>
                    <input type="text" class="form-control-plaintext fw-bold" value="{{ $kpiDocument->period_year }}" readonly>
                    <input type="hidden" name="period_year" value="{{ $kpiDocument->period_year }}">
                </div>
                <div class="col-md-9">
                    <label class="form-label fw-semibold">Catatan (Opsional)</label>
                    <input type="text" name="notes" class="form-control" placeholder="Catatan tambahan..."
                           value="{{ old('notes', $kpiDocument->notes) }}">
                </div>
            </div>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <ul class="nav tab-form-nav border-bottom mb-0" style="background:#f8fafc; padding:.75rem 1rem 0; border-radius:12px 12px 0 0; border:1px solid #e2e8f0; border-bottom:none;">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-hasil">Penilaian Kinerja Hasil</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-perilaku">Penilaian Kinerja Perilaku</a></li>
    </ul>

    <div class="tab-content" style="background:#f8fafc; border:1px solid #e2e8f0; border-top:none; border-radius:0 0 12px 12px; padding:1.25rem;">

        <div class="tab-pane fade show active" id="tab-hasil">

            {{-- SUBFORM 1: JOBDESC --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#1d4ed8,#2563eb);">
                    <i class="bi bi-briefcase"></i> Sub Form 1: Jobdesc
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="jobdescTable">
                            <thead>
                                <tr>
                                    <th style="min-width:50px">#</th>
                                    <th style="min-width:180px">Penilaian Koefisien On Time &amp; On Budget</th>
                                    <th style="min-width:160px">Penilaian Grade Project</th>
                                    <th style="min-width:200px">Nama Kegiatan dan Bukti</th>
                                    <th style="min-width:120px">Mandays Proyek</th>
                                    <th style="min-width:200px" class="text-info">Jumlah Koefisien <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th style="min-width:200px" class="text-info">Total Mandays Penugasan <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="jobdescBody">
                                @forelse($kpiDocument->jobdescs as $i => $jd)
                                    <tr class="jobdesc-row">
                                        @include('kpi.partials.jobdesc_row', ['index' => $i, 'row' => $jd])
                                    </tr>
                                @empty
                                    <tr class="jobdesc-row">
                                        @include('kpi.partials.jobdesc_row', ['index' => 0, 'row' => null])
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" class="bg-light">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-add-row" onclick="addJobdescRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Mandays: <strong class="text-primary" id="jobdescTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SUBFORM 2: CONTINUES IMPROVEMENT --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#16a34a,#22c55e);">
                    <i class="bi bi-arrow-repeat"></i> Sub Form 2: Continues Improvement
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="ciTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:220px">Jenis Kegiatan / Bukti</th>
                                    <th style="min-width:200px">Kegiatan</th>
                                    <th style="min-width:110px">Mandays</th>
                                    <th style="min-width:110px" class="text-info">Koefisien <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th style="min-width:110px" class="text-info">Point <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="ciBody">
                                @forelse($kpiDocument->continuesImprovements as $i => $ci)
                                    <tr class="ci-row">
                                        @include('kpi.partials.ci_row', ['index' => $i, 'row' => $ci, 'ciOptions' => $ciOptions])
                                    </tr>
                                @empty
                                    <tr class="ci-row">
                                        @include('kpi.partials.ci_row', ['index' => 0, 'row' => null, 'ciOptions' => $ciOptions])
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <button type="button" class="btn btn-outline-success btn-sm btn-add-row" onclick="addCIRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Point: <strong class="text-success" id="ciTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SUBFORM 3: SELF DEVELOPMENT --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#ca8a04,#fbbf24);">
                    <i class="bi bi-person-check"></i> Sub Form 3: Self Development
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="sdTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:220px">Jenis SD</th>
                                    <th style="min-width:200px">Kegiatan</th>
                                    <th style="min-width:110px">Mandays</th>
                                    <th style="min-width:110px" class="text-info">Koefisien <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th style="min-width:110px" class="text-info">Point <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sdBody">
                                @forelse($kpiDocument->selfDevelopments as $i => $sd)
                                    <tr class="sd-row">
                                        @include('kpi.partials.sd_row', ['index' => $i, 'row' => $sd, 'sdOptions' => $sdOptions])
                                    </tr>
                                @empty
                                    <tr class="sd-row">
                                        @include('kpi.partials.sd_row', ['index' => 0, 'row' => null, 'sdOptions' => $sdOptions])
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <button type="button" class="btn btn-outline-warning btn-sm btn-add-row" onclick="addSDRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Point: <strong class="text-warning" id="sdTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SUBFORM 4: HR ACTIVITY --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#7c3aed,#8b5cf6);">
                    <i class="bi bi-people"></i> Sub Form 4: HR Activity
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="hrTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:220px">Jenis Kegiatan</th>
                                    <th style="min-width:200px">Kegiatan</th>
                                    <th style="min-width:110px">Mandays</th>
                                    <th style="min-width:110px" class="text-info">Koefisien <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th style="min-width:110px" class="text-info">Point <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="hrBody">
                                @forelse($kpiDocument->hrActivities as $i => $hr)
                                    <tr class="hr-row">
                                        @include('kpi.partials.hr_row', ['index' => $i, 'row' => $hr, 'hrOptions' => $hrOptions])
                                    </tr>
                                @empty
                                    <tr class="hr-row">
                                        @include('kpi.partials.hr_row', ['index' => 0, 'row' => null, 'hrOptions' => $hrOptions])
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <button type="button" class="btn btn-outline-secondary btn-sm btn-add-row" onclick="addHRRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Point: <strong class="text-secondary" id="hrTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>{{-- end tab-hasil --}}

        {{-- TAB 2: KINERJA PERILAKU --}}
        <div class="tab-pane fade" id="tab-perilaku">
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#0891b2,#22d3ee);">
                    <i class="bi bi-star-half"></i> Sub Form: Kinerja Perilaku
                </div>
                <div class="form-section-body">
                    <div class="alert alert-info py-2 mb-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Kolom bertanda <i class="bi bi-lock-fill text-info"></i> tidak dapat diubah. Isi hanya kolom <strong>Score</strong>.
                    </div>
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aspek Kinerja <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Definisi <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Min. Capaian <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Indikator <i class="bi bi-lock-fill text-info"></i></th>
                                    <th>Deskripsi <i class="bi bi-lock-fill text-info"></i></th>
                                    <th style="min-width:110px">Score <span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $masterPerilaku = \App\Models\KpiKinerjaPerilaku::getMasterData(); @endphp
                                @foreach($masterPerilaku as $i => $master)
                                @php
                                    $existing = $kpiDocument->kinerjaPerilakus->get($i);
                                    $scoreVal = $existing ? $existing->score : old("perilaku.$i.score", 0);
                                @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><strong>{{ $master['aspek_kinerja'] }}</strong></td>
                                    <td><small>{{ $master['definisi'] }}</small></td>
                                    <td class="text-center"><span class="badge bg-warning text-dark">≥ {{ $master['minimum_capaian'] }}</span></td>
                                    <td><small>{{ $master['indikator'] }}</small></td>
                                    <td><small>{{ $master['deskripsi'] }}</small></td>
                                    <td>
                                        <input type="number"
                                               name="perilaku[{{ $i }}][score]"
                                               class="form-control perilaku-score"
                                               min="0" max="100" step="0.01"
                                               placeholder="0-100"
                                               value="{{ number_format((float)$scoreVal, 2, '.', '') }}"
                                               data-min="{{ $master['minimum_capaian'] }}"
                                               oninput="updatePerilakuTotal()">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <td colspan="6" class="text-end fw-bold">Total Score Perilaku:</td>
                                    <td><strong class="text-primary" id="perilakuTotal">0.00</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- end tab-content --}}

    {{-- SUMMARY & ACTIONS --}}
    <div class="card border-primary mt-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="row g-2 text-center">
                        <div class="col">
                            <small class="text-muted d-block">Jobdesc</small>
                            <strong class="text-primary" id="summJobdesc">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">CI</small>
                            <strong class="text-success" id="summCI">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">Self Dev</small>
                            <strong class="text-warning" id="summSD">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">HR Act</small>
                            <strong class="text-secondary" id="summHR">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">Perilaku</small>
                            <strong class="text-info" id="summPerilaku">0.00</strong>
                        </div>
                        <div class="col border-start">
                            <small class="text-muted d-block">TOTAL</small>
                            <strong class="text-dark fs-5" id="summTotal">0.00</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex justify-content-end gap-2 mt-3 mt-md-0">
                    <button type="submit" name="action" value="draft" class="btn btn-outline-secondary">
                        <i class="bi bi-floppy me-1"></i>Simpan Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Submit KPI
                    </button>
                </div>
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

let jobdescRowCount = {{ $kpiDocument->jobdescs->count() ?: 1 }};
let ciRowCount      = {{ $kpiDocument->continuesImprovements->count() ?: 1 }};
let sdRowCount      = {{ $kpiDocument->selfDevelopments->count() ?: 1 }};
let hrRowCount      = {{ $kpiDocument->hrActivities->count() ?: 1 }};

function calcJobdescRow(row) {
    const otb     = parseFloat(row.querySelector('.jd-otb').value) || 0;
    const grade   = parseFloat(row.querySelector('.jd-grade').value) || 0;
    const mandays = parseFloat(row.querySelector('.jd-mandays').value) || 0;
    const jumlah  = otb + grade;
    row.querySelector('.jd-jumlah').value = jumlah.toFixed(2);
    row.querySelector('.jd-total').value  = (jumlah * mandays).toFixed(2);
    updateJobdescTotal();
}
function updateJobdescTotal() {
    let s = 0; document.querySelectorAll('.jd-total').forEach(e => s += parseFloat(e.value)||0);
    document.getElementById('jobdescTotal').textContent = s.toFixed(2);
    document.getElementById('summJobdesc').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function addJobdescRow() {
    const idx = jobdescRowCount++;
    const tr  = document.createElement('tr'); tr.className = 'jobdesc-row';
    tr.innerHTML = `<td>${idx+1}</td>
        <td><input type="number" name="jobdesc[${idx}][penilaian_koefisien_ontime_onbudget]" class="form-control jd-otb" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td><input type="number" name="jobdesc[${idx}][penilaian_grade_project]" class="form-control jd-grade" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td><input type="text" name="jobdesc[${idx}][nama_kegiatan_bukti]" class="form-control" placeholder="Nama kegiatan & bukti..."></td>
        <td><input type="number" name="jobdesc[${idx}][mandays_proyek]" class="form-control jd-mandays" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field jd-jumlah" value="0.00" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field jd-total" value="0.00" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove();updateJobdescTotal();"><i class="bi bi-trash3"></i></button></td>`;
    document.getElementById('jobdescBody').appendChild(tr);
}

function calcCIRow(row) {
    const jenis = row.querySelector('.ci-jenis').value;
    const md    = parseFloat(row.querySelector('.ci-mandays').value)||0;
    const koef  = CI_KOEFISIEN[jenis]||0.5;
    row.querySelector('.ci-koef').value  = koef.toFixed(4);
    row.querySelector('.ci-point').value = (koef*md).toFixed(4);
    updateCITotal();
}
function updateCITotal() {
    let s=0; document.querySelectorAll('.ci-point').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('ciTotal').textContent = s.toFixed(2);
    document.getElementById('summCI').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function getCIOptions() { return Object.keys(CI_KOEFISIEN).map(k=>`<option value="${k}">${k}</option>`).join(''); }
function addCIRow() {
    const idx = ciRowCount++;
    const tr  = document.createElement('tr'); tr.className='ci-row';
    tr.innerHTML = `<td>${idx+1}</td>
        <td><select name="ci[${idx}][jenis_kegiatan_bukti]" class="form-select ci-jenis" onchange="calcCIRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getCIOptions()}</select></td>
        <td><input type="text" name="ci[${idx}][kegiatan]" class="form-control" placeholder="Nama kegiatan..."></td>
        <td><input type="number" name="ci[${idx}][mandays]" class="form-control ci-mandays" min="0" step="0.01" value="0" oninput="calcCIRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field ci-koef" value="0.0000" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field ci-point" value="0.0000" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove();updateCITotal();"><i class="bi bi-trash3"></i></button></td>`;
    document.getElementById('ciBody').appendChild(tr);
}

function calcSDRow(row) {
    const jenis = row.querySelector('.sd-jenis').value;
    const md    = parseFloat(row.querySelector('.sd-mandays').value)||0;
    const koef  = SD_KOEFISIEN[jenis]||0.5;
    row.querySelector('.sd-koef').value  = koef.toFixed(4);
    row.querySelector('.sd-point').value = (koef*md).toFixed(4);
    updateSDTotal();
}
function updateSDTotal() {
    let s=0; document.querySelectorAll('.sd-point').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('sdTotal').textContent = s.toFixed(2);
    document.getElementById('summSD').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function getSDOptions() { return Object.keys(SD_KOEFISIEN).map(k=>`<option value="${k}">${k}</option>`).join(''); }
function addSDRow() {
    const idx = sdRowCount++;
    const tr  = document.createElement('tr'); tr.className='sd-row';
    tr.innerHTML = `<td>${idx+1}</td>
        <td><select name="sd[${idx}][jenis_sd]" class="form-select sd-jenis" onchange="calcSDRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getSDOptions()}</select></td>
        <td><input type="text" name="sd[${idx}][kegiatan]" class="form-control" placeholder="Nama kegiatan..."></td>
        <td><input type="number" name="sd[${idx}][mandays]" class="form-control sd-mandays" min="0" step="0.01" value="0" oninput="calcSDRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field sd-koef" value="0.0000" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field sd-point" value="0.0000" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove();updateSDTotal();"><i class="bi bi-trash3"></i></button></td>`;
    document.getElementById('sdBody').appendChild(tr);
}

function calcHRRow(row) {
    const jenis = row.querySelector('.hr-jenis').value;
    const md    = parseFloat(row.querySelector('.hr-mandays').value)||0;
    const koef  = HR_KOEFISIEN[jenis]||0.5;
    row.querySelector('.hr-koef').value  = koef.toFixed(4);
    row.querySelector('.hr-point').value = (koef*md).toFixed(4);
    updateHRTotal();
}
function updateHRTotal() {
    let s=0; document.querySelectorAll('.hr-point').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('hrTotal').textContent = s.toFixed(2);
    document.getElementById('summHR').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function getHROptions() { return Object.keys(HR_KOEFISIEN).map(k=>`<option value="${k}">${k}</option>`).join(''); }
function addHRRow() {
    const idx = hrRowCount++;
    const tr  = document.createElement('tr'); tr.className='hr-row';
    tr.innerHTML = `<td>${idx+1}</td>
        <td><select name="hr[${idx}][jenis_kegiatan]" class="form-select hr-jenis" onchange="calcHRRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getHROptions()}</select></td>
        <td><input type="text" name="hr[${idx}][kegiatan]" class="form-control" placeholder="Nama kegiatan..."></td>
        <td><input type="number" name="hr[${idx}][mandays]" class="form-control hr-mandays" min="0" step="0.01" value="0" oninput="calcHRRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field hr-koef" value="0.0000" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field hr-point" value="0.0000" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove();updateHRTotal();"><i class="bi bi-trash3"></i></button></td>`;
    document.getElementById('hrBody').appendChild(tr);
}

function updatePerilakuTotal() {
    let s=0; document.querySelectorAll('.perilaku-score').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('perilakuTotal').textContent = s.toFixed(2);
    document.getElementById('summPerilaku').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function updateGrandTotal() {
    const j=parseFloat(document.getElementById('summJobdesc').textContent)||0;
    const c=parseFloat(document.getElementById('summCI').textContent)||0;
    const s=parseFloat(document.getElementById('summSD').textContent)||0;
    const h=parseFloat(document.getElementById('summHR').textContent)||0;
    const p=parseFloat(document.getElementById('summPerilaku').textContent)||0;
    document.getElementById('summTotal').textContent=(j+c+s+h+p).toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    // init totals from existing data
    updateJobdescTotal(); updateCITotal(); updateSDTotal(); updateHRTotal(); updatePerilakuTotal();

    document.querySelectorAll('.perilaku-score').forEach(el=>el.addEventListener('input',updatePerilakuTotal));

    // Recalc existing jobdesc rows on load
    document.querySelectorAll('.jobdesc-row').forEach(row=>{
        row.querySelectorAll('.jd-otb,.jd-grade,.jd-mandays').forEach(inp=>{
            inp.addEventListener('input',()=>calcJobdescRow(row));
        });
    });
    // Recalc existing ci rows
    document.querySelectorAll('.ci-row').forEach(row=>{
        row.querySelectorAll('.ci-jenis,.ci-mandays').forEach(inp=>{
            inp.addEventListener('change',()=>calcCIRow(row));
            inp.addEventListener('input',()=>calcCIRow(row));
        });
    });
    // Recalc existing sd rows
    document.querySelectorAll('.sd-row').forEach(row=>{
        row.querySelectorAll('.sd-jenis,.sd-mandays').forEach(inp=>{
            inp.addEventListener('change',()=>calcSDRow(row));
            inp.addEventListener('input',()=>calcSDRow(row));
        });
    });
    // Recalc existing hr rows
    document.querySelectorAll('.hr-row').forEach(row=>{
        row.querySelectorAll('.hr-jenis,.hr-mandays').forEach(inp=>{
            inp.addEventListener('change',()=>calcHRRow(row));
            inp.addEventListener('input',()=>calcHRRow(row));
        });
    });
});
</script>
@endpush
